<?php namespace modules\bootstrap\logger;


/**
 * The `LoggableInterface` is an interface in PHP that defines a contract for classes that can be
 * logged. It declares a single method `getLogsDir()` which should be implemented by any class that
 * implements this interface.
 */
interface LoggableInterface
{
  /**
   * Returns the path to the log directory.
   * @return string
   */
  static public function getLogsDir(): string;
}
