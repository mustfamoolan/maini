<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'image',
        'order',
    ];

    /**
     * Get the dishes for the category.
     */
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }
}
