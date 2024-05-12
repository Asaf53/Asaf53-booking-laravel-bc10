<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class property_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo'
    ];

    public function property(): HasMany
    {
        return $this->HasMany(property::class);
    }
}
