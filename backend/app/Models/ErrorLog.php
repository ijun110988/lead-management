<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'error_message',
        'endpoint',
        'status_code',
        'timestamp'
    ];
}
