<?php namespace modules\bootstrap\logger;

use modules\bootstrap\module\ModuleInterface;
use Stringable;

/**
 * Interface LoggerInterface
 * An interface containing one function for writing logs of various levels.
 */
interface LoggerInterface
{
  /**
   * Logs with an arbitrary level.
   *
   * @param LoggableInterface $module Interface of the module regarding which you want to write the log.
   * @param LoggerLevel $level The log level to be logged.
   * @param string|Stringable $message Log message.
   * @param mixed ...$args Additional arguments that can be used to format the message.
   *
   * @return void
   */
  public function log(LoggableInterface $module, LoggerLevel $level, string|Stringable $message, mixed ...$args): void;
}
