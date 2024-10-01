<?php

namespace App\DTOs;

class AddUserDTO
{
    public $name;
    public $email;
    public $role;
    public $password;

    public function __construct(string $name, string $email, string $role, ?string $password = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }
}
