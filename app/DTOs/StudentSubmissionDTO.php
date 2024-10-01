<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class StudentSubmissionDTO
{
    public string $name;
    public string $email;
    public UploadedFile  $cvFile;

    public function __construct(string $name, string $email, UploadedFile  $cvFile)
    {
        $this->name = $name;
        $this->email = $email;
        $this->cvFile = $cvFile;
    }
}
