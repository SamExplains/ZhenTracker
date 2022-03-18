<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    //
  protected $table = 'alerts';
  protected $fillable = ['company_id', 'company_ein', 'company_name', 'title', 'body', 'created_at'];
}
