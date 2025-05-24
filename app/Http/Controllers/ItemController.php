<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('images');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            });
        }

        $items = $query->latest()->get();

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

        $item = Item::create($request->only(['title', 'description', 'price', 'status']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('item_images', 'public');
                $item->images()->create(['image_url' => $path]);
            }
        }

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show($id)
    {
        $item = Item::with('images')->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Item::with('images')->findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'in:Available,Reserved,Sold',
        ]);

        $item->update($request->only(['title', 'description', 'price', 'status']));

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
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
}
