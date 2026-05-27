@extends('layouts.dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 class="page-title" style="margin: 0;">Edit Category</h1>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('dashboard.menu.index') }}" class="btn btn-secondary">Back to Menu</a>
            <form method="POST" action="{{ route('dashboard.categories.destroy', $category->id) }}" onsubmit="return confirm('Delete this category and ALL its items?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Category</button>
            </form>
        </div>
    </div>

    <div class="card" style="max-width: 600px;">
        <form method="POST" action="{{ route('dashboard.categories.update', $category->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Category Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description (Optional)</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                @error('description') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 12px; margin-top: 24px;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} style="width: 20px; height: 20px;">
                <label for="is_active" style="font-weight: 500; font-size: 1.1rem; margin: 0; cursor: pointer;">Category is visible</label>
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
