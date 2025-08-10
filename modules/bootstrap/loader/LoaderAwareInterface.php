<?php namespace modules\bootstrap\loader;
/**
 * @file LoaderAwareInterface.php
 * @brief Interface for loader-aware objects
 *
 * Defines the contract for objects that require access to a module loader.
 * Used for dependency injection of the loader instance.
 */

/**
 * @interface LoaderAwareInterface
 * @brief Interface for loader-dependent components
 *
 * This interface marks objects that:
 * - Need access to the module loader during construction
 * - Depend on loader functionality
 * - Should receive their loader instance via dependency injection
 *
 * @see LoaderInterface The loader interface being injected
 */
interface LoaderAwareInterface
{
    /**
     * @brief Constructs a loader-aware object
     * @param LoaderInterface $loader The module loader instance
     *
     * Implementing classes should:
     * - Store the loader instance for later use
     * - Use the loader to access other modules if needed
     *
     * @example
     * class ExampleModule implements LoaderAwareInterface {
     *     private LoaderInterface $loader;
     *
     *     public function __construct(LoaderInterface $loader) {
     *         $this->loader = $loader;
     *     }
     * }
     */
    public function __construct(LoaderInterface $loader);
}