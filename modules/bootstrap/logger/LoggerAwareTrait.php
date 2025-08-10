<?php namespace modules\bootstrap\logger;

use Stringable;

/** 
 * The `LoggerAwareTrait` is a PHP trait that provides logging functionality to a class. It defines a
 * set of methods for logging messages at different levels (emergency, alert, critical, error, warning,
 * notice, info, debug).
 */
trait LoggerAwareTrait
{
  /**
   * A logger instance.
   * @var LoggerInterface $logger
   */
  protected LoggerInterface $logger;

  /**
   * Sets the logger instance on the object.
   * @param LoggerInterface $logger The logger instance to be used.
   * @return void
   */
  public function setLogger(LoggerInterface $logger): void
  {
    $this->logger = $logger;
  }

  /**
   * Logs an emergency level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function emergency(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Emergency, $message, ...$args);
  }

  /**
   * Logs an alert level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function alert(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Alert, $message, ...$args);
  }

  /**
   * Logs a critical level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function critical(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Critical, $message, ...$args);
  }

  /**
   * Logs an error level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function error(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Error, $message, ...$args);
  }

  /**
   * Logs a warning level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function warning(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Warning, $message, ...$args);
  }

  /**
   * Logs a notice level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function notice(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Notice, $message, ...$args);
  }

  /**
   * Logs an info level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function info(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Info, $message, ...$args);
  }

  /**
   * Logs a debug level message.
   * @param string|Stringable $message The message to be logged.
   * @param mixed ...$args Additional arguments used to format the message.
   * @return void
   */
  public function debug(string|Stringable $message, mixed ...$args): void
  {
    $this->logger->log($this, LoggerLevel::Debug, $message, ...$args);
  }
}
