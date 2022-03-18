<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialData extends Model
{
    protected $fillable = ['name', 'title', 'amount', 'selected_type', 'company_id', 'qq_id', 'qq_year', 'qualifying_percent', 'activities', 'allocations'];
}
