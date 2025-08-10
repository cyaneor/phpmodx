<?php namespace modules\bootstrap\logger;

/**
 * Trait LoggerTrait
 * Contents a function to get the path to a logger directory.
 */
trait LoggableTrait
{
  /**
   * Returns the path to the log directory.
   * @return string
   */
  final static public function getLogsDir(): string
  {
    return self::getRootDir() . DIRECTORY_SEPARATOR . 'logs';
  }
}
