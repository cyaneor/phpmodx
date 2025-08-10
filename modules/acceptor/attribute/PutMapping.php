<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Class PutMapping for mapping HTTP PUT requests onto specific handler methods.
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class PutMapping extends RequestMapping
{
  /**
   * PutMapping constructor.
   * @param array $paths
   * @param array $methods
   */
  public function __construct(array $paths, array $methods = [RequestMethod::PUT])
  {
    parent::__construct($paths, $methods);
  }
}
