<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyDueDates extends Model
{
    protected $fillable = [
      'company_id',
      'date',
      'title',
      'description',
    ];

}
