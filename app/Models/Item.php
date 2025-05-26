<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'status'];

    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
