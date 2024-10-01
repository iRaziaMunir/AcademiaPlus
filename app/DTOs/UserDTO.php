<?php
namespace App\DTOs;

class UserDTO
{
    public $name;
    public $email;
    public $role;

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
        // $this->role = $role;
    }
}
