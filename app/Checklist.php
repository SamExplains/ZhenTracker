<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = 'checklists';
    protected $fillable = ['company_id', 'item', 'completed'];
}
