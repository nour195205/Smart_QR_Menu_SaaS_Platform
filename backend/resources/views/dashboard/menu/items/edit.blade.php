@extends('layouts.dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 class="page-title" style="margin: 0;">Edit Item</h1>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('dashboard.menu.index') }}" class="btn btn-secondary">Back to Menu</a>
            <form method="POST" action="{{ route('dashboard.items.destroy', $item->id) }}" onsubmit="return confirm('Delete this item completely?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Item</button>
            </form>
        </div>
    </div>

    <div class="card" style="max-width: 800px;">
        <form method="POST" action="{{ route('dashboard.items.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="category_id">Category *</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="name">Item Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                @error('name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="price">Price *</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $item->price) }}" step="0.01" min="0" required>
                @error('price') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description (Optional)</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $item->description) }}</textarea>
                @error('description') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="tags">Tags (Comma separated, e.g. Vegan, Spicy, Gluten-Free)</label>
                <input type="text" id="tags" name="tags" class="form-control" value="{{ old('tags', is_array($item->tags) ? implode(', ', $item->tags) : '') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="image">Item Image</label>
                @if($item->image_url)
                    <div style="margin-bottom: 12px; display: flex; align-items: center; gap: 16px;">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" style="height: 64px; border-radius: 8px; border: 1px solid var(--border); object-fit: cover;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="remove_image" value="1">
                            <span>Remove Image</span>
                        </label>
                    </div>
                @endif
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 12px; margin-top: 24px;">
                <input type="hidden" name="is_available" value="0">
                <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', $item->is_available) ? 'checked' : '' }} style="width: 20px; height: 20px;">
                <label for="is_available" style="font-weight: 500; font-size: 1.1rem; margin: 0; cursor: pointer;">Item is available</label>
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
