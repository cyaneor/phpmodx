<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Class PostMapping for mapping HTTP POST requests onto specific handler methods.
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class PostMapping extends RequestMapping
{
  /**
   * PostMapping constructor.
   * @param array $paths
   * @param array $methods
   */
  public function __construct(array $paths = [], array $methods = [RequestMethod::POST])
  {
    parent::__construct($paths, $methods);
  }
}
