@extends('layouts.dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 class="page-title" style="margin: 0;">Add Item</h1>
        <a href="{{ route('dashboard.menu.index') }}" class="btn btn-secondary">Back to Menu</a>
    </div>

    @if($categories->isEmpty())
        <div class="alert alert-error">You need to create a category before you can add items.</div>
    @else
        <div class="card" style="max-width: 800px;">
            <form method="POST" action="{{ route('dashboard.items.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="category_id">Category *</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Item Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    @error('name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="price">Price *</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0" required>
                    @error('price') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description (Optional)</label>
                    <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    @error('description') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="tags">Tags (Comma separated, e.g. Vegan, Spicy, Gluten-Free)</label>
                    <input type="text" id="tags" name="tags" class="form-control" value="{{ old('tags') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="image">Item Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 12px; margin-top: 24px;">
                    <input type="hidden" name="is_available" value="0">
                    <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} style="width: 20px; height: 20px;">
                    <label for="is_available" style="font-weight: 500; font-size: 1.1rem; margin: 0; cursor: pointer;">Item is available</label>
                </div>

                <div style="margin-top: 32px;">
                    <button type="submit" class="btn btn-primary">Create Item</button>
                </div>
            </form>
        </div>
    @endif
@endsection
