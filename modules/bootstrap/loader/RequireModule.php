<?php namespace modules\bootstrap\loader;
/**
 * @file RequireModule.php
 * @brief Attribute for declaring module dependencies
 *
 * Defines an attribute class used to declare required dependencies
 * for bootstrap modules.
 */

use Attribute;

/**
 * @class RequireModule
 * @brief Attribute for specifying module dependencies
 * @ingroup bootstrap_loader
 *
 * This attribute class is used to declare other modules that a class
 * requires to function properly. The bootstrap loader processes these
 * declarations to ensure all dependencies are loaded before the
 * dependent module is initialized.
 *
 * @property-read string $class Required module class name
 * @property-read string|null $version Optional version constraint
 *
 * @see Bootstrap::loadRequireModules() For the loading implementation
 * @see https://www.php.net/manual/en/language.attributes.php About PHP attributes
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
final class RequireModule
{
    /**
     * @brief Constructs a new module requirement declaration
     * @param string $class Fully qualified class name of required module
     * @param string|null $version Optional version constraint (e.g., "1.2.3")
     *
     * @example
     * #[RequireModule(LoggerInterface::class)]
     * #[RequireModule(DatabaseInterface::class, "2.0.0")]
     * class MyModule {
     *     // Module implementation
     * }
     */
    public function __construct(
        public readonly string $class,
        public readonly ?string $version = null
    ) {
    }
}