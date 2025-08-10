<?php
/**
 * @file bootstrap.php
 * @brief Main bootstrap module for the application
 *
 * This file contains the core bootstrap functionality that initializes
 * and manages all application modules. It handles module loading,
 * dependency management, and provides fault-tolerant execution.
 */

namespace modules\bootstrap;

/* Logger */
include_once('logger/LoggerAwareInterface.php');
include_once('logger/LoggerInterface.php');
include_once('logger/LoggerAwareTrait.php');
include_once('logger/LoggableInterface.php');
include_once('logger/LoggableTrait.php');
include_once('logger/ModuleLogger.php');
include_once('logger/LoggerLevel.php');
/* Loader */
include_once('loader/exception/LoaderException.php');
include_once('loader/exception/InvalidClassException.php');
include_once('loader/StorageInterface.php');
include_once('loader/LoaderInterface.php');
include_once('loader/ObjectAccessorTrait.php');
include_once('loader/RequireModule.php');
include_once('loader/LoaderAwareInterface.php');
/* Module */
include_once('module/Configurable.php');
include_once('module/ConfigurableTrait.php');
include_once('module/Application.php');
include_once('module/ModuleInterface.php');
include_once('module/ModuleTrait.php');
include_once('module/AbstractModule.php');
include_once('module/ModuleInfo.php');
include_once('module/ModuleResult.php');
include_once('module/LoggableModule.php');

use modules\bootstrap\loader\exception\InvalidClassException;
use modules\bootstrap\loader\exception\LoaderException;
use modules\bootstrap\loader\LoaderAwareInterface;
use modules\bootstrap\loader\LoaderInterface;
use modules\bootstrap\loader\ObjectAccessorTrait;
use modules\bootstrap\loader\RequireModule;
use modules\bootstrap\module\Application;
use modules\bootstrap\module\Configurable;
use modules\bootstrap\module\ConfigurableTrait;
use modules\bootstrap\module\LoggableModule;
use modules\bootstrap\module\ModuleInfo;
use modules\bootstrap\module\ModuleInterface;
use modules\bootstrap\module\ModuleResult;
use OverflowException;
use ReflectionClass;
use ReflectionException;
use Throwable;

/**
 * @class Bootstrap
 * @brief Core bootstrap class that initializes and manages application modules
 *
 * This class is responsible for:
 * - Loading and initializing all application modules
 * - Managing module dependencies
 * - Providing fault-tolerant execution
 * - Handling exceptions across modules
 * - Implementing configuration management
 *
 * @implements LoaderInterface
 * @implements Application
 * @implements Configurable
 * @extends LoggableModule
 */
final class Bootstrap extends LoggableModule implements LoaderInterface, Application, Configurable
{
    use ObjectAccessorTrait;
    use ConfigurableTrait;

    /**
     * @var ModuleInterface[] $objects Array of loaded module instances
     */
    private array $objects = [];

    /**
     * @brief Gets module information
     * @return ModuleInfo Information about the bootstrap module
     */
    public static function getModuleInfo(): ModuleInfo
    {
        return new ModuleInfo('Bootstrap', '1.0.0', 'Clay Whitelytning', 'Main modules loader');
    }

    /**
     * @brief Main module execution method
     * @details This method:
     * 1. Sets up exception handling
     * 2. Loads all required modules
     * 3. Executes onMainModule() for each application module
     * @return ModuleResult Returns ModuleResult::Handled when complete
     */
    public function onMainModule(): ModuleResult
    {
        $this->setExceptionHandler();
        $this->onLoadModules();

        $this->each(function (Application $application) {
            try {
                return $application->onMainModule();
            } catch(Throwable $throwable) {
                $this->logThrowable($throwable);
            }
            return false;
        }, Application::class);

        return ModuleResult::Handled;
    }

    /**
     * @brief Sets global exception handler
     * @return callable|null Previous exception handler
     */
    private function setExceptionHandler(): ?callable
    {
        return set_exception_handler(function (Throwable $throwable) {
            $this->logThrowable($throwable);
        });
    }

    /**
     * @brief Logs throwable exceptions
     * @param Throwable $throwable Exception to log
     */
    private function logThrowable(Throwable $throwable): void
    {
        $this->error($throwable->getMessage());
    }

    /**
     * @brief Loads modules from configuration
     */
    private function onLoadModules(): void
    {
        if ($requireModules = $this->getRequireModulesFromFile()) {
            $this->loadRequireModules(...$requireModules);
        }
    }

    /**
     * @brief Gets required modules from configuration file
     * @return RequireModule[] Array of required modules
     */
    private function getRequireModulesFromFile(): array
    {
        $requires = [];
        if ($modules = self::getConfig('bootstrap.json')) {
            foreach ($modules as $module) {
                if (isset($module['class'])) {
                    $requires[] = new RequireModule($module['class'], $module['version'] ?? null);
                }
            }
        }
        return $requires;
    }

    /**
     * @brief Loads required modules with dependency checking
     * @param RequireModule ...$modules Modules to load
     * @throws OverflowException If circular dependency is detected
     */
    private function loadRequireModules(RequireModule ...$modules): void
    {
        foreach ($modules as $module) {
            try {
                $class = $module->class;
                if ($this->has($class)) continue;

                $reflectionClass = $this->loadClass($class);
                $requireModules = $this->getRequireModules($reflectionClass);

                if ($this->containClassModule($module, ...$requireModules)) {
                    throw new OverflowException("Overflow when including requested module ($class)");
                }

                $this->loadRequireModules(...$requireModules);
                $this->attachModule($this->newInstance($reflectionClass));
            } catch (Throwable $throwable) {
                $this->logThrowable($throwable);
            }
        }
    }

    /**
     * @brief Loads a class file and returns its reflection
     * @param string $class Class name to load
     * @return ReflectionClass Reflection of the loaded class
     * @throws LoaderException If file cannot be loaded
     * @throws InvalidClassException If class is invalid
     */
    private function loadClass(string $class): ReflectionClass
    {
        $filename = self::getRootDir() . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

        if (is_readable($filename)) {
            @include_once($filename);
            if (class_exists($class)) {
                return new ReflectionClass($class);
            }
            throw new InvalidClassException("Invalid class path ($class)");
        }
        throw new LoaderException("Module file is missing ($filename)");
    }

    /**
     * @brief Gets required modules from class attributes
     * @param ReflectionClass $class Class to inspect
     * @return RequireModule[] Array of required modules
     */
    private function getRequireModules(ReflectionClass $class): array
    {
        $modules = [];
        $attributes = $class->getAttributes(RequireModule::class);
        foreach ($attributes as $attribute) {
            $modules[] = $attribute->newInstance();
        }
        return $modules;
    }

    /**
     * @brief Creates new module instance
     * @param ReflectionClass $class Class to instantiate
     * @return ModuleInterface New module instance
     * @throws InvalidClassException If class doesn't implement ModuleInterface
     * @throws ReflectionException If instantiation fails
     */
    private function newInstance(ReflectionClass $class): ModuleInterface
    {
        if ($class->implementsInterface(ModuleInterface::class)) {
            return $class->implementsInterface(LoaderAwareInterface::class)
                ? $class->newInstance($this) : $class->newInstance();
        }
        throw new InvalidClassException("Class does not implements module interface ($class->name)");
    }

    /**
     * @brief Checks if module is in required modules list
     * @param RequireModule $checkableModule Module to check
     * @param RequireModule ...$requireModules Modules to check against
     * @return bool True if module is found in list
     */
    private function containClassModule(RequireModule $checkableModule, RequireModule ...$requireModules): bool
    {
        foreach ($requireModules as $requireModule) {
            if ($checkableModule->class == $requireModule::class) {
                return true;
            }
        }
        return false;
    }

    /**
     * @brief Attaches a module to the loaded modules list
     * @param ModuleInterface $module Module to attach
     */
    private function attachModule(ModuleInterface $module): void
    {
        $this->objects[$module::class] = $module;
    }
}