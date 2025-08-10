<?php namespace modules\acceptor\attribute;

/**
 * Enum RequestMethod
 * @package com\longhorn\autumn\attribute
 */
final class RequestMethod {
  /**
   * The HTTP GET method requests a representation of the specified resource.
   * Requests using GET should only be used to request data (they shouldn't include data).
   */
  const GET = 'GET';

  /**
   * The HTTP HEAD method requests the headers that would be returned
   * if the HEAD request's URL was instead requested with the HTTP GET method.
   */
  const HEAD = 'HEAD';

  /**
   * The HTTP POST method sends data to the server.
   * The type of the body of the request is indicated by the Content-Type header.
   */
  const POST = 'POST';

  /**
   * The PUT method replaces all current representations of the target resource with the request payload.
   */
  const PUT = 'PUT';

  /**
   * The HTTP DELETE request method deletes the specified resource.
   */
  const DELETE = 'DELETE';

  /**
   * The HTTP CONNECT method starts two-way communications with the requested resource.
   * It can be used to open a tunnel.
   */
  const CONNECT = 'CONNECT';

  /**
   * The HTTP OPTIONS method requests permitted communication options for a given URL or server.
   * A client can specify a URL with this method, or an asterisk (*) to refer to the entire server.
   */
  const OPTIONS = 'OPTIONS';

  /**
   * The HTTP TRACE method performs a message loop-back test along the path to the target resource,
   * providing a useful debugging mechanism.
   */
  const TRACE = 'TRACE';

  /**
   * The HTTP PATCH request method applies partial modifications to a resource.
   */
  const PATCH = 'PATCH';
}