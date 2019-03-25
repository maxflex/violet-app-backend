<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Utils\Phone;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birthdate', 'gender',
        'phone', 'city_id',
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function city()
    {
        return $this->belongsTo(Geo\City::class);
    }

    public function setPasswordAttribute($password)
    {
        if (! empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = Phone::clean($value);
    }
}
