<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Class RequestMapping
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class RequestMapping implements Mapping
{
  /**
   * RequestMapping constructor.
   * @param array $paths
   * @param array $methods
   */
  public function __construct(public readonly array $paths = [], public readonly array $methods = [])
  {
  }
}
