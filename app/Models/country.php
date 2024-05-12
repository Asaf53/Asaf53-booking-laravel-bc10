<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    function city() {
        return $this->hasMany(city::class);
    }
    function property() {
        return $this->hasMany(property::class);
    }
}
