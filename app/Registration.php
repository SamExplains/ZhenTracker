<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    //
    protected $fillable = ['creator_id', 'event_id', 'registered'];

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}