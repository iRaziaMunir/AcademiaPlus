<?php
// app/DTOs/CreateManagerDTO.php

namespace App\DTOs;

class CreateManagerDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
