<?php

namespace App;

use Laravel\Passport\HasApiTokens;
//use Illuminate\Suport\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    /*public function findForPassport($name){
        echo($name);
        return $this->orWhere('name',$name)->orWhere('email',$name)->first();
    }

    public function validateForPassportPasswordGrant($password){
        echo($password);
        return Hash::check($password,$this->password);
    }*/
}
