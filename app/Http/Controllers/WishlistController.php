<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $query = Wishlist::with('images', 'user')->latest();

        if ($request->filled('search')) {
            $searchTerms = explode(' ', $request->search);

            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($subQuery) use ($term) {
                        $subQuery->where('title', 'like', "%{$term}%")
                                ->orWhere('description', 'like', "%{$term}%")
                                ->orWhereHas('user', function ($userQuery) use ($term) {
                                    $userQuery->where('name', 'like', "%{$term}%");
                                });
                    });
                }
            });
        }

        $wishlists = $query->paginate(10)->withQueryString();

        return view('wishlists.index', compact('wishlists'));
    }

    public function create()
    {
        return view('wishlists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:150',
            'description' => 'nullable|string',
            'price_range_min' => 'nullable|numeric|min:0',
            'price_range_max' => 'nullable|numeric|gte:price_range_min',
            'status' => 'nullable|in:open,in negotiation,fulfilled,closed',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $wishlist = Wishlist::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price_range_min' => $validated['price_range_min'] ?? null,
            'price_range_max' => $validated['price_range_max'] ?? null,
            'status' => $validated['status'] ?? 'open',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('wishlist_images', 'public');
                $wishlist->images()->create(['image_url' => $path]);
            }
        }

        return redirect()->route('wishlists.index')->with('success', 'Wishlist created successfully.');
    }

    public function show(Wishlist $wishlist)
    {
        $wishlist->load('images', 'responses.user');
        return view('wishlists.show', compact('wishlist'));
    }

    public function edit(Wishlist $wishlist)
    {
        $this->authorize('update', $wishlist);
        return view('wishlists.edit', compact('wishlist'));
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        $this->authorize('update', $wishlist);

        $validated = $request->validate([
            'title' => 'required|max:150',
            'description' => 'nullable|string',
            'price_range_min' => 'nullable|numeric|min:0',
            'price_range_max' => 'nullable|numeric|gte:price_range_min',
            'status' => 'required|in:open,in negotiation,fulfilled,closed',
            'images.*' => 'nullable|image|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:wishlist_images,id',
        ]);

        $wishlist->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price_range_min' => $validated['price_range_min'] ?? null,
            'price_range_max' => $validated['price_range_max'] ?? null,
            'status' => $validated['status'],
        ]);

        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $wishlist->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_url);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('wishlist_images', 'public');
                $wishlist->images()->create(['image_url' => $path]);
            }
        }

        return redirect()->route('wishlists.index')->with('success', 'Wishlist updated successfully.');
    }

    public function updateStatus(Request $request, Wishlist $wishlist)
    {
        $this->authorize('update', $wishlist);

        $validated = $request->validate([
            'status' => 'required|in:open,in negotiation,fulfilled,closed',
        ]);

        $wishlist->update(['status' => $validated['status']]);

        return redirect()->route('wishlists.show', $wishlist->id)->with('success', 'Status updated.');
    }
        public function destroy(Wishlist $wishlist)
    {
        $this->authorize('delete', $wishlist);
        foreach ($wishlist->images as $image) {
            \Storage::disk('public')->delete($image->image_url);
            $image->delete();
        }

        $wishlist->delete();

        return redirect()->route('wishlists.index')->with('success', 'Wishlist deleted successfully.');
    }

}
