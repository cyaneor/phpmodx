<?php namespace modules\bootstrap\logger;

use Stringable;

interface LoggerAwareInterface
{
  /**
   * Sets the logger instance on the object.
   * @param LoggerInterface $logger The logger instance to be used.
   * @return void
   */
  function setLogger(LoggerInterface $logger): void;

  /**
   * Logs an emergency level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function emergency(string|Stringable $message, mixed ...$args): void;

  /**
   * Logs an alert level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function alert(string|Stringable $message, mixed ...$args): void;

  /**
   * Logs a critical level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function critical(string|Stringable $message, mixed ...$args): void;

  /**
   * Logs an error level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function error(string|Stringable $message, mixed ...$args): void;

  /**
   * Logs a warning level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function warning(string|Stringable $message, mixed ...$args): void;

  /**
   * Logs a notice level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function notice(string|Stringable $message, mixed ...$args): void;

  /**
   * Logs an info level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function info(string|Stringable $message, mixed ...$args): void;

  /**
   * Logs a debug level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  function debug(string|Stringable $message, mixed ...$args): void;
}
