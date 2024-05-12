<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'country_id',
        'name'
    ];

    function country() {
        return $this->belongsTo(country::class);
    }
    function property() {
        return $this->hasMany(property::class);
    }
}
