<?php

namespace Curl\Exceptions;

use Curl\Exception as CurlException;

class InvalidArgumentException extends \UnexpectedValueException implements CurlException {}
