<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Wishlist;
use App\Models\WishlistResponse;

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
        public function responses()
    {
        $responses = WishlistResponse::with(['wishlist', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.responses', compact('responses'));
    }

    public function deleteResponse(WishlistResponse $response)
    {
        $response->delete();

        return redirect()->route('admin.responses')->with('success', 'Response deleted successfully.');
    }
}
