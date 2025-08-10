<?php namespace modules\bootstrap\module;

use ReflectionClass;

/**
 * The `ModuleTrait` is a PHP trait that provides a set of methods 
 * for working with modules in a PHP application. 
 */
trait ModuleTrait
{
  /**
   * Returns the path to the root directory.
   * @return string
   */
  final static public function getRootDir(): string
  {
    return dirname(self::getModulesDir());
  }

  /**
   * Returns the path to the modules' directory.
   * @return string
   */
  final static public function getModulesDir(): string
  {
    return dirname(self::getModuleDir());
  }

  /**
   * Returns the path to the module directory.
   * @return string
   */
  final static public function getModuleDir(): string
  {
    return dirname(self::getModuleFile());
  }

  /**
   * Returns the path to the module file.
   * @return string
   */
  final static public function getModuleFile(): string
  {
    return self::getReflectionClass()->getFileName();
  }

  /**
   * Returns a new instance of the ReflectionClass.
   * @return ReflectionClass
   */
  final static public function getReflectionClass(): ReflectionClass
  {
    return new ReflectionClass(static::class);
  }
}