<?php

namespace Curl\Exceptions;

use Curl\Exception as CurlException;

class UnexpectedValueException extends \UnexpectedValueException implements CurlException {}
