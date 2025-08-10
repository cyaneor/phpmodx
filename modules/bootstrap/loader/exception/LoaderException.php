<?php namespace modules\bootstrap\loader\exception;
/**
 * @file LoaderException.php
 * @brief Exception class for module loading failures
 *
 * This file contains the LoaderException class which is thrown when
 * there are problems loading modules or classes in the bootstrap process.
 */

use RuntimeException;

/**
 * @class LoaderException
 * @brief Exception thrown when module loading fails
 *
 * This exception is thrown by the bootstrap loader when:
 * - A module file cannot be found or read
 * - There are problems including/requiring module files
 * - Other loading-related failures occur
 *
 * @extends RuntimeException
 * @see InvalidClassException For invalid class exceptions
 */
class LoaderException extends RuntimeException
{
}