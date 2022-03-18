<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
  protected $fillable = ['user_id', 'company_name', 'company_id'];
}
