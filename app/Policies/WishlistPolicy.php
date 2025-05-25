<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;

class WishlistPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Wishlist $wishlist)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role === 'student';
    }

    public function update(User $user, Wishlist $wishlist)
    {
        return $user->id === $wishlist->user_id;
    }

    public function delete(User $user, Wishlist $wishlist)
    {
        return $user->id === $wishlist->user_id;
    }

}
