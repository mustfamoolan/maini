<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dish extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the category that owns the dish.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
