<?php namespace modules\bootstrap\loader;
/**
 * @file StorageInterface.php
 * @brief Interface for module storage and retrieval
 *
 * Defines the contract for classes that store and manage loaded modules.
 * Provides methods for accessing, checking, and iterating over stored objects.
 */

use Countable;

/**
 * @interface StorageInterface
 * @brief Interface for module object storage
 *
 * This interface defines the standard operations for:
 * - Storing loaded module objects
 * - Retrieving modules by class name
 * - Checking for module existence
 * - Iterating through stored modules
 *
 * @extends Countable Allows counting stored objects (e.g., count($storage))
 */
interface StorageInterface extends Countable
{
    /**
     * @brief Retrieves a stored object by its class name
     * @param string $class The fully qualified class name to retrieve
     * @return object Reference to the requested object
     * @throws \OutOfBoundsException If the class is not found in storage
     *
     * @note Returns by reference to allow modification of stored objects
     */
    function &get(string $class): object;

    /**
     * @brief Checks if an object of specified class exists in storage
     * @param string $class The fully qualified class name to check
     * @return bool True if the object exists, false otherwise
     */
    function has(string $class): bool;

    /**
     * @brief Iterates through stored objects with optional filtering
     * @param callable $callback Function to execute for each object.
     *        Signature: function(object $object): ?bool
     *        Return false to stop iteration.
     * @param string|null $class Optional interface/class name to filter by.
     *        Only objects implementing/extending this class will be processed.
     * @return object|null The last processed object or null if none processed
     *
     * @example
     * $storage->each(function($module) {
     *     if ($module->shouldProcess()) {
     *         $module->process();
     *     }
     * }, ProcessableInterface::class);
     */
    function each(callable $callback, ?string $class = null): ?object;
}