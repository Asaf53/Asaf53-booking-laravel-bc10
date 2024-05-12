<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class property_images extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'image'
    ];



    public function property(): BelongsTo
    {
        return $this->BelongsTo(property::class);
    }
}
