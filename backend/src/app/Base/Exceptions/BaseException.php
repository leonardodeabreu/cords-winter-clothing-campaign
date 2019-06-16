<?php

namespace App\Base\Exceptions;

use Exception;
use Log;

class BaseException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::debug("Base Report - Trace: {$this->getTraceAsString()} - Code: {$this->getCode()} - Message: {$this->getMessage()}");
    }
}
