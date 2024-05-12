<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class property_rooms extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'capacity',
        'price',
        'number',
        'singel_beds',
        // 'single_beds',
        'double_beds',
    ];

    public function property(): BelongsTo
    {
        return $this->BelongsTo(property::class);
    }
}
