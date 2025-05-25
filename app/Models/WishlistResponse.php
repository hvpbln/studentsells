<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistResponse extends Model
{
    protected $fillable = ['wishlist_id', 'user_id', 'message', 'offer_price'];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
