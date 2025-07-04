<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Wishlist;
use App\Models\WishlistResponse;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistResponses()
    {
        return $this->hasMany(WishlistResponse::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function listingResponses()
    {
        return $this->hasMany(ListingResponse::class);
    }

        public function ratingsGiven() {
        return $this->hasMany(Rating::class, 'rater_id');
    }

    public function ratingsReceived() {
        return $this->hasMany(Rating::class, 'ratee_id');
    }

    public function averageRating() {
        return round($this->ratingsReceived()->avg('rating'), 1);
    }

    public function hasRatedBy($userId) {
        return $this->ratingsReceived()->where('rater_id', $userId)->exists();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
