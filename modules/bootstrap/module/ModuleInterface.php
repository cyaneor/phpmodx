<?php namespace modules\bootstrap\module;

use ReflectionClass;

/**
 * The `ModuleInterface` is an interface in PHP that defines a contract for classes that implement it.
 * It declares a set of methods that must be implemented by any class that wants to be considered a
 * "module" in the application.
 */
interface ModuleInterface
{
  /**
   * Returns the path to the root directory.
   * @return string
   */
  static function getRootDir(): string;

  /**
   * Returns the path to the modules' directory.
   * @return string
   */
  static function getModulesDir(): string;

  /**
   * Returns the path to the module directory.
   * @return string
   */
  static function getModuleDir(): string;
  
  /**
   * Returns the path to the module file.
   * @return string
   */
  static function getModuleFile(): string;
  
  /**
   * Returns a new instance of the ReflectionClass.
   * @return ReflectionClass
   */
  static function getReflectionClass(): ReflectionClass;

  /**
   * Returns information about the module.
   * @return ModuleInfo
   */
  static function getModuleInfo(): ModuleInfo;
}