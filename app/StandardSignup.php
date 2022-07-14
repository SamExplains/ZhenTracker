<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandardSignup extends Model
{
    //
    protected $fillable = ['email', 'zip', 'name', 'password', 'uuid', 'qrcode_src', 'profile_image_src', 'token', 'role', 'phone'];
    protected $hidden = ['password'];
}