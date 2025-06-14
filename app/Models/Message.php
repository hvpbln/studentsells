<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'item_id',
        'wishlist_id',
        'message_text',
        'is_read',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class)->withDefault([
            'title' => '[Deleted Item]',
            'price' => 0,
            'images' => [],
        ]);
    }

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class)->withDefault([
            'title' => '[Deleted Wishlist]',
            'price_range' => '',
            'images' => [],
        ]);
    }
}