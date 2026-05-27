@extends('layouts.dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 class="page-title" style="margin: 0;">Add Category</h1>
        <a href="{{ route('dashboard.menu.index') }}" class="btn btn-secondary">Back to Menu</a>
    </div>

    <div class="card" style="max-width: 600px;">
        <form method="POST" action="{{ route('dashboard.categories.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Category Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                @error('name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description (Optional)</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                @error('description') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 12px; margin-top: 24px;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 20px; height: 20px;">
                <label for="is_active" style="font-weight: 500; font-size: 1.1rem; margin: 0; cursor: pointer;">Category is visible</label>
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Create Category</button>
            </div>
        </form>
    </div>
@endsection
