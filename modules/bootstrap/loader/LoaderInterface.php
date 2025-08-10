<?php namespace modules\bootstrap\loader;
/**
 * @file LoaderInterface.php
 * @brief Core loader interface for module management system
 *
 * Defines the fundamental contract for module loaders within the bootstrap system.
 * Serves as the base interface that all module loaders must implement.
 */

/**
 * @interface LoaderInterface
 * @brief Core module loader interface
 *
 * This interface represents the fundamental capabilities of the module loader system.
 * It extends StorageInterface to provide both loading functionality and storage capabilities.
 *
 * As the base interface for all loaders, it ensures:
 * - Consistent access to loaded modules
 * - Standardized module storage behavior
 * - Interoperability between different loader implementations
 *
 * @extends StorageInterface Inherits all storage capabilities including:
 *   - Object retrieval via get()
 *   - Existence checking via has()
 *   - Iteration via each()
 *   - Countability
 *
 * @see StorageInterface For basic storage operations
 * @see Bootstrap For the primary implementation
 */
interface LoaderInterface extends StorageInterface
{
    // Interface body intentionally left blank as this serves as a marker interface
    // that combines StorageInterface capabilities with loader semantics
}