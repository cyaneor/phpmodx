<?php namespace modules\bootstrap\module;

use Stringable;

/**
 * Class ModuleInfo
 * @package bootstrap\module
 */
final class ModuleInfo implements Stringable
{
  public function __construct(public readonly string $name,
                              public readonly string $version,
                              public readonly string $author,
                              public readonly string $description,
                              public readonly ?string $url = null,
                              public readonly ?string $license = null)
  {
  }

  /**
   * Magic method {@see https://www.php.net/manual/en/language.oop5.magic.php#object.tostring}
   * allows a class to decide how it will react when it is treated like a string.
   *
   * @return string Returns string representation of the object that
   * implements this interface (and/or "__toString" magic method).
   */
  public function __toString(): string
  {
    return "$this->name v.$this->version ($this->author)";
  }
}
