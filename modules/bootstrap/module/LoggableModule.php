<?php namespace modules\bootstrap\module;

use modules\bootstrap\logger\LoggableInterface;
use modules\bootstrap\logger\LoggableTrait;
use modules\bootstrap\logger\LoggerAwareInterface;
use modules\bootstrap\logger\LoggerAwareTrait;
use modules\bootstrap\logger\ModuleLogger;

/** 
 * The LoggableModule class is a PHP module that implements the LoggerAwareInterface 
 * and LoggableInterface, and sets the logger to a ModuleLogger object in its constructor.
 */
abstract class LoggableModule extends AbstractModule implements LoggerAwareInterface, LoggableInterface
{
  use LoggerAwareTrait;
  use LoggableTrait;

  /**
   * The constructor function sets the logger to a ModuleLogger object.
   */
  public function __construct()
  {
    $this->setLogger(new ModuleLogger());
  }
}
