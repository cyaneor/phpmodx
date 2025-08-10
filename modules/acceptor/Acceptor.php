<?php namespace modules\acceptor;

include_once('attribute/Controller.php');
include_once('attribute/Mapping.php');
include_once('attribute/RequestMethod.php');
include_once('attribute/RequestMapping.php');
include_once('attribute/PathVariable.php');
include_once('attribute/GetMapping.php');
include_once('attribute/PostMapping.php');
include_once('attribute/PatchMapping.php');
include_once('attribute/DeleteMapping.php');
include_once('attribute/PutMapping.php');

use modules\acceptor\attribute\Controller;
use modules\acceptor\attribute\RequestMapping;
use modules\bootstrap\loader\LoaderAwareInterface;
use modules\bootstrap\loader\LoaderInterface;
use modules\bootstrap\module\AbstractModule;
use modules\bootstrap\module\Application;
use modules\bootstrap\module\ModuleInfo;
use modules\bootstrap\module\ModuleInterface;
use modules\bootstrap\module\ModuleResult;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

final class Acceptor extends AbstractModule implements Application, LoaderAwareInterface
{
  /**
   * Decoded requested URI.
   * @var string
   */
  public readonly string $uri;

  /**
   * Contains requested query.
   * @var string
   */
  public readonly string $query;

  /**
   * Contains the requested method.
   * @var string
   */
  public readonly string $method;
  
  /**
   * Arguments that will be received from the controller found to process the request.
   * Example: [path => '/station/{id}/create', args => [id => 0]]
   * @var array|false
   */
  public array|false $args;

  /**
   * Acceptor initialization.
   * @param LoaderInterface $loader
   * @return void
   */
  public function __construct(protected readonly LoaderInterface $loader)
  {
    $this->uri = array_key_first($_REQUEST);
    $this->query = $_REQUEST[$this->uri];
    $this->method = $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Acceptor main function.
   * @return ModuleResult
   */
  public function onMainModule(): ModuleResult
  {
    $this->loader->each(function (ModuleInterface $module) use (&$uri) {
      $class = $module->getReflectionClass();
      # The Controller must contain the initial URI path that includes all others.
      # This will speed up the process of finding the necessary method to process the request.
      return ($this->args = $this->findRequestClass($class))
        ? $this->handleRequestMethod($module, $class->getMethods()) : ModuleResult::Continue;
    }, Controller::class);
    return ModuleResult::Handled;
  }

  /**
   * Returns an array containing the path and variables
   * if one of the controller paths matches the requested path.
   * @param ReflectionClass $class
   * @return array|false
   */
  private function findRequestClass(ReflectionClass $class): array|false
  {
    if ($attributes = $class->getAttributes(RequestMapping::class, ReflectionAttribute::IS_INSTANCEOF)) {
      /** @var RequestMapping $requestMapping */
      $requestMapping = $attributes[0]->newInstance();
      # If the class does not contain methods, then it supports all request methods.
      if (!$requestMapping->methods || in_array($this->method, $requestMapping->methods)) {
        foreach($requestMapping->paths as $path) {
          if (($vars = $this->getPathVariables($this->uri, $path)) !== false) {
            return ['path' => $path, 'vars' => $vars];
          }
        }
      }
    }
    return false; # The Controller does not accept a requested path and method.
  }

  /**
   * Returns an array of parameters from the path Uri by template.
   * @param string $uri
   * @param string $pattern
   * @return array|false
   */
  public static function getPathVariables(string $uri, string $pattern): array|false
  {
    $levels = explode('/', $uri);
    $chunks = explode('/', $pattern);

    # When the length of the URI turned out to be shorter than the length of the template
    if (count($levels) < count($chunks)) {
      return false;
    }

    $args = [];
    foreach ($chunks as $index => $value) {
      if ($value && $value[0] == '{' && $value[-1] == '}' && $levels[$index] !== "") {
        $key = trim($value, '{}');
        $args[$key] = $levels[$index];
      } elseif ($value != $levels[$index]) {
        return false;
      }
    }
    return $args;
  }

  /**
   * Looks for the specified request method in the body of the class and calls it,
   * passing it all the necessary arguments.
   * @param object $object
   * @param ReflectionMethod[] $methods
   * @return ModuleResult
   * @throws ReflectionException
   */
  private function handleRequestMethod(object $object, array $methods): ModuleResult
  {
    foreach($methods as $method) {
      if ($attributes = $method->getAttributes(RequestMapping::class, ReflectionAttribute::IS_INSTANCEOF)) {
        /** @var RequestMapping $requestMapping */
        $requestMapping = $attributes[0]->newInstance();
        if (in_array($this->method, $requestMapping->methods)) {
          $vars = [];

          if ($requestMapping->paths) {
            $uri = $this->getMethodPath($this->getControllerPath());
            foreach ($requestMapping->paths as $path) {
              if (($vars = self::getPathVariables($uri, $path)) !== false)
                break;
            }
          }

          if (is_array($vars)) {
            # Priority should always remain with the variables specified to the method.
            $vars = $this->bindVariables($method->getParameters(), $vars, $this->args['vars']);
            return $method->invoke($object, ...$vars);
          }
        }
      }
    }
    return ModuleResult::Continue;
  }

  /**
   * Returns the path for the method based on the requested path.
   * @param string $path
   * @return string
   */
  private function getMethodPath(string $path): string
  {
    return self::addPathSeparator(mb_substr($this->uri, mb_strlen($path)));
  }

  /**
   * Adds a separator at the end of the URI path.
   * If there is already a separator at the end of the path, it does not add it again.
   * If an empty string is passed, it also adds a separator.
   * @param string $path
   * @return string
   */
  private static function addPathSeparator(string $path): string
  {
    return $path && $path[-1] == '/' ? $path : "$path/";
  }

  /**
   * Collects the path from the template and variables (if the controller has been found).
   * @return string|false
   */
  private function getControllerPath(): string|false
  {
    return $this->args ? self::substitutes($this->args['path'], $this->args['vars']) : false;
  }

  /**
   * Substitutes variables under the URI template and returns a string.
   * @param string $uri
   * @param array $vars
   * @return string
   */
  private static function substitutes(string $uri, array $vars = []): string
  {
    $replace = [];
    foreach ($vars as $key => $val) {
      $replace['{' . $key . '}'] = $val;
    }
    return strtr($uri, $replace);
  }

  /**
   * Binds variables and parameter names.
   * @param ReflectionParameter[] $parameters
   * @param array ...$arrays
   * @return array
   */
  private function bindVariables(array $parameters, array ...$arrays): array
  {
    $vars = [];
    foreach ($parameters as $parameter) {
      foreach ($arrays as $array) {
        if (isset($array[$parameter->name])) {
          $vars[$parameter->name] = $array[$parameter->name];
          break;
        }
      }
    }
    return $vars;
  }

  /**
   * Returns information about the module.
   * @return ModuleInfo
   */
  static function getModuleInfo(): ModuleInfo
  {
    return new ModuleInfo('Acceptor Requests', '1.0.0', 'Clay Whitelytning', 'Simplifies web application development');
  }
}