@extends('layouts.dashboard')

@section('content')
    <h1 class="page-title">Restaurant Settings</h1>
    <p class="page-subtitle">Manage your restaurant's profile, contact information, and branding images.</p>

    <div class="card" style="max-width: 800px;">
        <form method="POST" action="{{ route('dashboard.restaurant.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Restaurant Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $restaurant->name) }}" required>
                @error('name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $restaurant->description) }}</textarea>
                @error('description') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $restaurant->phone) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="address">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $restaurant->address) }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="currency_code">Currency Code * (e.g. USD, EUR)</label>
                    <input type="text" id="currency_code" name="currency_code" class="form-control" value="{{ old('currency_code', $restaurant->currency_code) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="currency_symbol">Currency Symbol * (e.g. $, €)</label>
                    <input type="text" id="currency_symbol" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $restaurant->currency_symbol) }}" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <label class="form-label" for="menu_type">Active Menu Type *</label>
                <select id="menu_type" name="menu_type" class="form-control" required>
                    <option value="dynamic" {{ old('menu_type', $restaurant->menu_type) === 'dynamic' ? 'selected' : '' }}>Dynamic Menu (Categories & Items)</option>
                    <option value="pdf" {{ old('menu_type', $restaurant->menu_type) === 'pdf' ? 'selected' : '' }}>PDF Menu (Uploaded File)</option>
                </select>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 8px;">Select which menu mode customers will see when they scan your QR code.</p>
                @error('menu_type') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <hr style="border-color: var(--border); margin: 32px 0;">

            <div class="form-group">
                <label class="form-label" for="logo">Restaurant Logo (Image)</label>
                @if($restaurant->logo_url)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ $restaurant->logo_url }}" alt="Logo" style="height: 64px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label class="form-label" for="cover">Cover Image</label>
                @if($restaurant->cover_url)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ $restaurant->cover_url }}" alt="Cover" style="height: 120px; width: 100%; object-fit: cover; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" id="cover" name="cover" class="form-control" accept="image/*">
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
