<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistImage extends Model
{
    protected $fillable = ['wishlist_id', 'image_url'];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }
}

