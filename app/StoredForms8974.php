<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoredForms8974 extends Model
{
    // use HasFactory;
    protected $table = 'stored_forms8974s';
    protected $fillable = ['company_id',
                        'form_name',
                        'form_year',
                        'eid',
                        'name',
                        'credit_checkbox',
                        'quarter',
                        'part_one',
                        'part_one_total',
                        'seven',
                        'eight',
                        'nine',
                        'ten',
                        'eleven',
                        'eleven_checkbox',
                        'twelve'];
}