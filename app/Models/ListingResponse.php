<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingResponse extends Model
{
    protected $fillable = ['item_id', 'user_id', 'message', 'offer_price'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

