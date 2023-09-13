<?php

namespace Yama\NodeInPhp\System;

/**
 * Class Response
 * @package Yama\NodeInPhp\System
 */
class Response
{
    /**
     * @var array
     */
    protected $message;

    /**
     * @var int
     */
    protected $code;

    /**
     * Response constructor.
     * 
     * @param  array $message
     * @param  int $code
     */
    public function __construct(array $message, int $code)
    {
        $this->message = $message;
        $this->code    = $code;
    }

    /**
     * Returns the status code of the response.
     * 
     * @return int
     */
    public function statusCode(): int
    {
        return $this->code;
    }

    /**
     * Returns the output of the response.
     * 
     * @return array
     */
    public function output(): array
    {
        return $this->message;
    }
}