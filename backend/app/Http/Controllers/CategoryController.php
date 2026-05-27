<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Category CRUD and reordering.
 */
class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $restaurant = $request->attributes->get('restaurant');
        $categories = $restaurant->categories()->withCount('items')->get();
        return view('dashboard.menu.index', compact('restaurant', 'categories'));
    }

    public function create(Request $request): View
    {
        return view('dashboard.menu.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');
        
        $maxSortOrder = $restaurant->categories()->max('sort_order') ?? -1;
        
        $restaurant->categories()->create([
            ...$request->validated(),
            'sort_order' => $maxSortOrder + 1,
        ]);

        return redirect()->route('dashboard.menu.index')->with('success', 'Category created successfully.');
    }

    public function edit(Request $request, Category $category): View
    {
        $this->authorizeCategory($request, $category);
        return view('dashboard.menu.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $this->authorizeCategory($request, $category);
        
        $category->update($request->validated());

        return redirect()->route('dashboard.menu.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->authorizeCategory($request, $category);
        
        $category->delete();

        return redirect()->route('dashboard.menu.index')->with('success', 'Category deleted successfully.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');
        $order = $request->input('order', []);

        foreach ($order as $index => $id) {
            $restaurant->categories()->where('id', $id)->update(['sort_order' => $index]);
        }
        
        // Mark as dirty explicitly since update Quietly may be used or bulk update
        $restaurant->markDirty();

        return redirect()->route('dashboard.menu.index')->with('success', 'Categories reordered.');
    }
    
    private function authorizeCategory(Request $request, Category $category): void
    {
        if ($category->restaurant_id !== $request->attributes->get('restaurant')->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
