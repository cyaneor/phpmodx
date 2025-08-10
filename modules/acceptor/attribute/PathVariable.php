<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Class PathVariable
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class PathVariable
{
  /**
   * PathVariable constructor.
   * @param string $name
   */
  public function __construct(public readonly string $name)
  {
  }
}
