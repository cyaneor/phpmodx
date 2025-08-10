<?php namespace modules\acceptor\attribute;

use Attribute;

/**
 * Interface ResponseBody indicates a method return value should be bound to the web response body.
 * @package com\longhorn\autumn\attribute
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
interface ResponseBody
{
}