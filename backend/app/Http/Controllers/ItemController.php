<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Item CRUD and reordering.
 */
class ItemController extends Controller
{
    public function __construct(private readonly CloudinaryService $cloudinary) {}

    public function create(Request $request): View
    {
        $restaurant = $request->attributes->get('restaurant');
        $categories = $restaurant->categories;
        return view('dashboard.menu.items.create', compact('categories'));
    }

    public function store(ItemRequest $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');
        $data = $request->validated();
        
        // Ensure category belongs to this restaurant
        $category = $restaurant->categories()->findOrFail($data['category_id']);
        
        $maxSortOrder = $category->items()->max('sort_order') ?? -1;
        $data['sort_order'] = $maxSortOrder + 1;
        $data['tags'] = !empty($data['tags']) ? array_map('trim', explode(',', $data['tags'])) : null;

        try {
            if ($request->hasFile('image')) {
                $upload = $this->cloudinary->uploadImage($request->file('image')->getRealPath(), "qrmenu/{$restaurant->slug}/items");
                $data['image_url'] = $upload['url'];
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Image upload failed: ' . $e->getMessage());
        }

        $restaurant->items()->create($data);

        return redirect()->route('dashboard.menu.index')->with('success', 'Item created successfully.');
    }

    public function edit(Request $request, Item $item): View
    {
        $this->authorizeItem($request, $item);
        $restaurant = $request->attributes->get('restaurant');
        $categories = $restaurant->categories;
        return view('dashboard.menu.items.edit', compact('item', 'categories'));
    }

    public function update(ItemRequest $request, Item $item): RedirectResponse
    {
        $this->authorizeItem($request, $item);
        $restaurant = $request->attributes->get('restaurant');
        $data = $request->validated();
        
        // Ensure category belongs to this restaurant
        $restaurant->categories()->findOrFail($data['category_id']);
        
        $data['tags'] = !empty($data['tags']) ? array_map('trim', explode(',', $data['tags'])) : null;

        try {
            if ($request->hasFile('image')) {
                $upload = $this->cloudinary->uploadImage($request->file('image')->getRealPath(), "qrmenu/{$restaurant->slug}/items");
                $data['image_url'] = $upload['url'];
            } elseif (!empty($data['remove_image'])) {
                $data['image_url'] = null;
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Image upload failed: ' . $e->getMessage());
        }

        $item->update($data);

        return redirect()->route('dashboard.menu.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Request $request, Item $item): RedirectResponse
    {
        $this->authorizeItem($request, $item);
        $item->delete();
        return redirect()->route('dashboard.menu.index')->with('success', 'Item deleted successfully.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            $restaurant->items()->where('id', $id)->update(['sort_order' => $index]);
        }
        
        $restaurant->markDirty();

        return redirect()->route('dashboard.menu.index')->with('success', 'Items reordered.');
    }
    
    private function authorizeItem(Request $request, Item $item): void
    {
        if ($item->restaurant_id !== $request->attributes->get('restaurant')->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
