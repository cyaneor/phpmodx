<?php namespace modules\bootstrap\logger;

/**
 * @enum LoggerLevel
 * Helps categorize logger levels and prioritize logging alerts.
 */
enum LoggerLevel: int
{
  /**
   * @case debug
   * Used for debugging purposes.
   */
  case Debug = 0;

  /**
   * @case info
   * Informational message.
   */
  case Info = 1;

  /**
   * @case notice
   * Normal but significant condition.
   */
  case Notice = 2;

  /**
   * @case warning
   * May indicate a potential problem.
   */
  case Warning = 3;

  /**
   * @case error
   * Error conditions.
   */
  case Error = 4;

  /**
   * @case critical
   * Critical conditions, typically requires immediate attention.
   */
  case Critical = 5;

  /**
   * @case alert
   * Action must be taken immediately.
   */
  case Alert = 6;

  /**
   * @case emergency
   * The System is unusable.
   */
  case Emergency = 7;
}