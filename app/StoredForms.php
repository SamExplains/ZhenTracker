<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoredForms extends Model
{
    //
    protected $table = 'stored_forms';
    protected $fillable = [ 'company_id',
                            'form_name',
                            'form_year',
                            'eid',
                            'name',
                            'trade_name',
                            'address',
                            'city',
                            'state',
                            'zip',
                            'foreign_country_name',
                            'foreign_country_providence',
                            'foreign_country_postal_code',
                            'quarter',
                            'one',
                            'two',
                            'three',
                            'four',
                            'five_a',
                            'five_aa',
                            'five_aaa',
                            'five_b',
                            'five_c',
                            'five_d',
                            'five_e',
                            'five_f',
                            'six',
                            'seven',
                            'eight',
                            'nine',
                            'ten',
                            'eleven_a',
                            'eleven_b',
                            'eleven_c',
                            'eleven_d',
                            'eleven_g',
                            'twelve',
                            'thirteen',
                            'thirteen_b',
                            'thirteen_c',
                            'thirteen_d',
                            'thirteen_e',
                            'thirteen_f',
                            'thirteen_g',
                            'thirteen_h',
                            'thirteen_i',
                            'fourteen',
                            'fifteen',
                            'fifteen_checkbox',
                            'sixteen_a',
                            'sixteen_b',
                            'sixteen_b_month_1',
                            'sixteen_b_month_2',
                            'sixteen_b_month_3',
                            'sixteen_b_sum',
                            'sixteen_c',
  ];

}