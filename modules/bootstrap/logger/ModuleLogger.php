<?php namespace modules\bootstrap\logger;

use DateTime;
use Stringable;

final class ModuleLogger implements LoggerInterface
{
  /**
   * Generates a timestamp string in the "Y-m-d H:i:s,ms" format, where
   * Y is a four-digit year, m is a two-digit month, d is a two-digit day,
   * H is a two-digit hour, i is a two-digit minute, s is a two-digit second,
   * and ms is the milliseconds portion of the current time.
   *
   * @return string
   * The timestamp string in the specified format.
   */
  private function timestamp(): string
  {
    $date = new DateTime();
    $milliseconds = round($date->format('u') / 1000);
    return $date->format("Y-m-d - H:i:s") . ':' . $milliseconds;
  }

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
  public function log(LoggableInterface $module, LoggerLevel $level, Stringable|string $message, ...$args): void
  {
    # Getting the path and create a directory for logs if it does not exist
    $logsDir = $module::getLogsDir();
    if (!is_dir($logsDir)) { mkdir($logsDir); }

    # The prefix will allow you to separate logs with errors
    # and logs without errors (debug, info, notice, warning)
    $prefix = $level->value > 3 ? 'E' : 'L';

    $class = $module::class;
    $message = $this->interpolate($message, $args);
    $filename = $prefix . (new DateTime())->format('Ydm') ;
    $filepath = $logsDir . DIRECTORY_SEPARATOR . $filename . '.log';
    $timestamp = $this->timestamp();

    @file_put_contents($filepath, "$timestamp:\t[$level->name]\t[$class]\t$message\n", FILE_APPEND | LOCK_EX);
  }

  /**
   * Processes the logging message, replacing placeholders
   * in the $message with their corresponding values from $context.
   *
   * @param Stringable|string $message
   * The message string containing placeholders.
   *
   * @param array $args
   * The context array that contains values for placeholders (optional).
   *
   * @return string
   * The processed message with placeholders replaced with actual values.
   */
  private function interpolate(Stringable|string $message, array $args = []): string
  {
    $replace = [];
    foreach ($args as $key => $value) {
      if (!is_array($value) && (!is_object($value) || method_exists($value, '__toString'))) {
        $replace['{' . $key . '}'] = $value;
      }
    }
    return strtr($message, $replace);
  }
}