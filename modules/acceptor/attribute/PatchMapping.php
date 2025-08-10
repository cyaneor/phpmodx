<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Class PatchMapping for mapping HTTP PATCH requests onto specific handler methods.
 * @package com\longhorn\autumn
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class PatchMapping extends RequestMapping
{
  /**
   * PatchMapping constructor.
   * @param array $paths
   * @param array $methods
   */
  public function __construct(array $paths = [], array $methods = [RequestMethod::PATCH])
  {
    parent::__construct($paths, $methods);
  }
}
