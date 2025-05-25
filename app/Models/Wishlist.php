<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'price_range_min', 'price_range_max', 'status'];

    public function images()
    {
        return $this->hasMany(WishlistImage::class);
    }

    public function responses()
    {
        return $this->hasMany(WishlistResponse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

