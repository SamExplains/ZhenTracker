<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'uid',
      'name',
      'email',
      'photoURL',
      'description',
      'registration_date',
      'points',
      'status',
      'online',
      'signup_procedure',
      'disabled',
      'email_verified_at',
      'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



  /****/
  public function associations(){
    return $this->hasMany(Association::class);
  }


}
