<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['rater_id', 'ratee_id', 'rating'];

    public function rater() {
        return $this->belongsTo(User::class, 'rater_id');
    }

    public function ratee() {
        return $this->belongsTo(User::class, 'ratee_id');
    }
}
