<?php namespace modules\bootstrap\loader\exception;
/**
 * @file InvalidClassException.php
 * @brief Exception thrown when an invalid class is encountered during module loading
 *
 * This exception is thrown when the bootstrap loader encounters a class that doesn't meet
 * the required criteria for being a valid module.
 */

/**
 * @class InvalidClassException
 * @brief Exception for invalid module class scenarios
 *
 * This exception is thrown when:
 * - A class file exists but doesn't contain the expected class
 * - A class doesn't implement the required ModuleInterface
 * - A class fails other validity checks during loading
 *
 * @extends LoaderException
 * @final This class should not be extended
 *
 * @see LoaderException For general loading failures
 * @see LoaderInterface For loader requirements
 * @see ModuleInterface For module requirements
 */
final class InvalidClassException extends LoaderException
{
}