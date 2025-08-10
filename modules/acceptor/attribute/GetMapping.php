<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Class GetMapping for mapping HTTP GET requests onto specific handler methods.
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class GetMapping extends RequestMapping
{
  /**
   * GetMapping constructor.
   * @param array $paths
   * @param array $methods
   */
  public function __construct(array $paths = [], array $methods = [RequestMethod::GET])
  {
    parent::__construct($paths, $methods);
  }
}
