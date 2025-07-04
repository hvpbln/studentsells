<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'reference_id', 'message', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}