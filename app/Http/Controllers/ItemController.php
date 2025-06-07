<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('images', 'user')->latest();

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

        $items = $query->paginate(10)->withQueryString();

        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'in:Available,Reserved,Sold',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $item = new Item($request->only(['title', 'description', 'price', 'status']));
        $item->user_id = auth()->id(); // FOR THE LOGGED IN USER
        $item->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $item->images()->create(['image_url' => $path]);
            }
        }


        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show($id)
    {
        $item = Item::with(['images', 'user'])->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Item::with('images')->findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'in:Available,Reserved,Sold',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $item->update($request->only(['title', 'description', 'price', 'status']));

        if ($request->hasFile('images')) {
            // Delete old images from storage and DB
            foreach ($item->images as $image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            }

            // Store new images
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('items', 'public');
                $item->images()->create(['image_url' => $path]);
            }
        }

        return redirect()->route('items.index')->with('success', 'Listing updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        foreach ($item->images as $image) { // OPTIONAL: FOR IMAGE DELETION IN STORAGE
            \Storage::disk('public')->delete($image->image_url);
        }

        $item->images()->delete();
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted.');
    }

    public function updateStatus(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Available,Reserved,Sold'
        ]);

        $item->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated.');
    }

    public function respond(Item $item)
    {
        return view('items.respond', compact('item'));
    }

}
