<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiRequestLog extends Model
{
    use HasFactory;

    protected $fillable = [

        'ip_address',
        'user_agent',
        'request_method',
        'request_url',
        'request_body',
        'response_body',
        'response_status_code',
    ];
}
