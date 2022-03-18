<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualifyingQuestionsYears extends Model
{
    //
    protected $fillable = ['year', 'companyId'];


    public function financial_data()
    {
      return $this->hasMany(FinancialData::class, 'qq_id');
    }

}
