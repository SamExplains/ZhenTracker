<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    //
  protected $table = 'forms';
  protected $fillable = ['company_id', 'form_type', 'quarter','year', 'period', 'file_one_url','file_two_url', 'additional_files'];
}
