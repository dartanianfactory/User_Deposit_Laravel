<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'Пользователь не найден';

    public function __construct(string $message = null) 
    {
        if ($message) {
            $this->message = $message;
        }

        parent::__construct($this->message);
    }
}
