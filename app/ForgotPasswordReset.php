<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgotPasswordReset extends Model
{
    protected $fillable = [
        'code',
        'email',
    ];
}