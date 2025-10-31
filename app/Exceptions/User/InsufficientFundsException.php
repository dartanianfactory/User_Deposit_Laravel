<?php

namespace App\Exceptions\User;

use Exception;

class InsufficientFundsException extends Exception
{
    protected $message = 'Недостаточно средств для выполнения операции';

    public function __construct(string $message = null) 
    {
        if ($message) {
            $this->message = $message;
        }

        parent::__construct($this->message);
    }
}
