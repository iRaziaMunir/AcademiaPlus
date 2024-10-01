<?php

namespace App\DTOs;

class PasswordSetupDTO
{
    public string $token;
    public string $password;

    public function __construct(string $token, string $password)
    {
        $this->token = $token;
        $this->password = $password;
    }
}
