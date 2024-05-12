<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'locations',
        'country_id',
        'city_id',
        'property_type_id',
    ];

    public function property_type(): BelongsTo
    {
        return $this->BelongsTo(property_type::class);
    }
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
    public function country(): BelongsTo
    {
        return $this->BelongsTo(country::class);
    }
    public function city(): BelongsTo
    {
        return $this->BelongsTo(city::class);
    }
    public function property_details(): HasMany
    {
        return $this->HasMany(property_rooms::class);
    }
    public function property_images(): HasMany
    {
        return $this->HasMany(property_images::class);
    }
}
