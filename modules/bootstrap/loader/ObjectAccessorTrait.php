<?php namespace modules\bootstrap\loader;
/**
 * @file ObjectAccessorTrait.php
 * @brief Trait providing object storage access functionality
 *
 * Implements common object access methods for classes that need to manage
 * collections of objects stored in a protected $objects array.
 */

use OutOfBoundsException;
use TypeError;

/**
 * @trait ObjectAccessorTrait
 * @brief Provides standardized object access methods
 *
 * This trait implements the core functionality required by StorageInterface,
 * providing basic object storage and retrieval capabilities through:
 * - Countable implementation (count())
 * - Object iteration (each())
 * - Existence checking (has())
 * - Object retrieval (get())
 *
 * @property array $objects Protected array storing objects by class name
 *
 * @see StorageInterface The interface this trait implements
 * @see LoaderInterface For usage in loader implementations
 */
trait ObjectAccessorTrait
{
    /**
     * @var array $objects Stores objects indexed by their class names
     * @brief Internal object storage array
     */
    protected array $objects = [];

    /**
     * @brief Returns the count of stored objects
     * @return int Number of objects currently stored
     *
     * @implements Countable::count()
     */
    public function count(): int
    {
        return count($this->objects);
    }

    /**
     * @brief Iterates through objects with optional filtering
     * @param callable $callback Function to execute for each matching object.
     *        Signature: function(object $object): bool
     *        Return true to stop iteration and return current object.
     * @param string|null $class Optional class/interface name to filter by
     * @return object|null First object where callback returns true, or null
     *
     * @example
     * // Find first logger instance
     * $logger = $this->each(
     *     fn($obj) => true, // return first match
     *     LoggerInterface::class
     * );
     */
    public function each(callable $callback, ?string $class = null): ?object
    {
        foreach ($this->objects as $object) {
            if ((!$class || $object instanceof $class) && $callback($object)) {
                return $object;
            }
        }
        return null;
    }

    /**
     * @brief Checks if an object of specified class exists
     * @param string $class Fully qualified class name to check
     * @return bool True if object exists, false otherwise
     *
     * @throws TypeError If $class is not a string
     */
    public function has(string $class): bool
    {
        return isset($this->objects[$class]);
    }

    /**
     * @brief Retrieves an object by class name
     * @param string $class Fully qualified class name to retrieve
     * @return object Reference to the requested object
     * @throws OutOfBoundsException If object doesn't exist
     *
     * @note Returns by reference to allow object modification
     * @warning Call has() first to check existence or catch potential exception
     */
    public function &get(string $class): object
    {
        return $this->objects[$class];
    }
}