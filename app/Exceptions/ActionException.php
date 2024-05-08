<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class ActionException
 * @package App\Exceptions
 */
class ActionException extends Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link https://php.net/manual/en/exception.construct.php
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param null|Throwable $previous [optional] The previous throwable used for the exception chaining.
     */
    public function __construct($message, $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
