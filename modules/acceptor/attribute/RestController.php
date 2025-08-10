<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Interface RestController a convenience attribute that is itself attributed with @Controller and @ResponseBody.
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_CLASS)]
interface RestController extends Controller, ResponseBody
{
}