<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishlistItem extends Model
{
    /** @use HasFactory<\Database\Factories\WishlistItemFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'board_id',
        'title',
        'price',
        'image_url',
        'item_url',
        'source',
    ];

    /**
     * Get the board that owns the wishlist item.
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
