<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps =false;

    /**Relations */
    public function products()
    {
        return $this->hasMany(Products::class,'company');
    }
}
