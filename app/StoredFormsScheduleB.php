<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoredFormsScheduleB extends Model
{
  protected $table = 'stored_forms_schedule_b_s';
  protected $fillable = ['company_id',
                        'form_name',
                        'form_year',
                        'eid',
                        'name',
                        'quarter',
                        'month_one',
                        'month_one_tax_liability',
                        'month_two',
                        'month_two_tax_liability',
                        'month_three',
                        'month_three_tax_liability',
                        'total_liability'];
}