<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'property_id',
        'property_room_id',
        'country_id',
        'city_id',
        'address',
        'check-in',
        'check-out',
        'price',
        'people',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
    public function property(): BelongsTo
    {
        return $this->BelongsTo(property::class);
    }
    public function property_room(): BelongsTo
    {
        return $this->BelongsTo(property_rooms::class);
    }
    public function country(): BelongsTo
    {
        return $this->BelongsTo(country::class);
    }
    public function city(): BelongsTo
    {
        return $this->BelongsTo(city::class);
    }
}
