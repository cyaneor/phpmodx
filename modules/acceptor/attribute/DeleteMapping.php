<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Class DeleteMapping for mapping HTTP DELETE requests onto specific handler methods.
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class DeleteMapping extends RequestMapping
{
  /**
   * DeleteMapping constructor.
   * @param array $paths
   * @param array $methods
   */
  public function __construct(array $paths = [], array $methods = [RequestMethod::DELETE])
  {
    parent::__construct($paths, $methods);
  }
}
