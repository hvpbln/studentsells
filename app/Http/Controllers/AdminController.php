<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Wishlist;
use App\Models\WishlistResponse;
use App\Models\ListingResponse;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with pending users count.
     */
    public function dashboard()
    {
        $pendingUsersCount = User::where('status', 'pending')->count();

        return view('admin.dashboard', compact('pendingUsersCount'));
    }

    /**
     * Show all users for management.
     */
    public function manageUsers()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.manageUsers', compact('users'));
    }

    /**
     * Show users with pending status.
     */
    public function showPendingUsers()
    {
        $pendingUsers = User::where('status', 'pending')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users', compact('pendingUsers'));
    }
    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.manageUsers')->with('success', 'User deleted successfully.');
    }
    /**
     * Update user status (pending, active, banned).
     */
    public function updateUserStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,active,banned',
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return redirect()->route('admin.manageUsers')->with('success', 'User status updated successfully.');
    }

    /**
     * Show all listings (items) for admin management.
     */
    public function listings()
    {
        $items = Item::with('user')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.listings', compact('items'));
    }

    /**
     * Delete a listing.
     */
        public function deleteListing(Item $item)
    {
        $item->delete();

        return redirect()->route('admin.listings')->with('success', 'Listing deleted successfully.');
    }

    /**
     * Show all wishlists for admin management.
     */
    public function wishlists()
    {
        $wishlists = Wishlist::with('user')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.wishlists', compact('wishlists'));
    }

    /**
     * Delete a wishlist.
     */
    public function deleteWishlist(Wishlist $wishlist)
    {
        $wishlist->delete();

        return redirect()->route('admin.wishlists')->with('success', 'Wishlist deleted successfully.');
    }

    /**
     * Show both wishlist and listing responses.
     */
    public function responses()
    {
        $wishlistResponses = WishlistResponse::with(['wishlist', 'user'])->latest()->get();
        $listingResponses = ListingResponse::with(['item', 'user'])->latest()->get();

        return view('admin.responses', compact('wishlistResponses', 'listingResponses'));
    }

    /**
     * Delete a wishlist response.
     */
    public function deleteWishlistResponse(WishlistResponse $response)
    {
        $response->delete();
        return redirect()->route('admin.responses')->with('success', 'Wishlist response deleted successfully.');
    }

    /**
     * Delete a listing response.
     */
    public function deleteListingResponse(ListingResponse $response)
    {
        $response->delete();
        return redirect()->route('admin.responses')->with('success', 'Listing response deleted successfully.');
    }
    public function showUserPosts($userId)
    {
        $user = \App\Models\User::findOrFail($userId);

        $listings = \App\Models\Item::where('user_id', $user->id)->latest()->get();
        $wishlists = \App\Models\Wishlist::where('user_id', $user->id)->latest()->get();
        $wishlistResponses = \App\Models\WishlistResponse::where('user_id', $user->id)->latest()->get();
        $listingResponses = \App\Models\ListingResponse::where('user_id', $user->id)->latest()->get();

        return view('admin.user_posts', compact('user', 'listings', 'wishlists', 'wishlistResponses', 'listingResponses'));
    }

}
