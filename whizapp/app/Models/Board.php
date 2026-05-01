<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Board extends Model
{
    /** @use HasFactory<\Database\Factories\BoardFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'share_token',
        'is_public',
        'user_id',
    ];

    /**
     * Get the user that owns the board.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all wishlist items for the board.
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    /**
     * Get up to 4 thumbnail images from wishlist items.
     */
    public function thumbnailImages(): Collection
    {
        return $this->wishlistItems()
            ->whereNotNull('image_url')
            ->limit(4)
            ->pluck('image_url');
    }

    /**
     * Get the total amount of all wishlist items.
     */
    public function totalAmount(): float
    {
        return $this->wishlistItems()->sum('price');
    }
}
