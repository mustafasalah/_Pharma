<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'phone_number',
        'address_id',
        'gender'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Relations */
    public function address()
    {
<<<<<<< HEAD
        return $this->hasOne(Addresses::class,'id'); //modified address_id to id
=======
        return $this->belongsTo(Addresses::class, 'address_id'); //modified address_id to id
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
    }
    public function orders()
    {
        return $this->hasMany(Orders::class, 'address_id');
    }
    public function pharmacy()
    {
        return $this->hasOne(Pharmacies::class, 'address_id');
    }

<<<<<<< HEAD
    public function fullName() {
        return $this->first_name . " " . $this->last_name;
    }

=======
    public function fullName()
    {
        return $this->first_name . " " . $this->last_name;
    }
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
}
