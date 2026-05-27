@extends('layouts.dashboard')

@section('content')
    <h1 class="page-title">Welcome back, {{ $restaurant->name }}</h1>
    <p class="page-subtitle">Here is a quick overview of your menu performance and status.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
        <div class="card" style="display: flex; align-items: center; gap: 16px;">
            <div style="background: rgba(255,107,53,0.1); color: var(--accent-primary); padding: 16px; border-radius: 12px;">
                <i data-lucide="layers" style="width: 32px; height: 32px;"></i>
            </div>
            <div>
                <p style="margin: 0; color: var(--text-secondary); font-size: 0.875rem;">Total Categories</p>
                <h3 style="margin: 0; font-size: 1.5rem;">{{ $categoriesCount }}</h3>
            </div>
        </div>

        <div class="card" style="display: flex; align-items: center; gap: 16px;">
            <div style="background: rgba(16,185,129,0.1); color: var(--success); padding: 16px; border-radius: 12px;">
                <i data-lucide="utensils-crossed" style="width: 32px; height: 32px;"></i>
            </div>
            <div>
                <p style="margin: 0; color: var(--text-secondary); font-size: 0.875rem;">Total Items</p>
                <h3 style="margin: 0; font-size: 1.5rem;">{{ $itemsCount }}</h3>
            </div>
        </div>

        <div class="card" style="display: flex; align-items: center; gap: 16px;">
            <div style="background: rgba(59,130,246,0.1); color: #3B82F6; padding: 16px; border-radius: 12px;">
                <i data-lucide="file-text" style="width: 32px; height: 32px;"></i>
            </div>
            <div>
                <p style="margin: 0; color: var(--text-secondary); font-size: 0.875rem;">PDF Menu</p>
                <h3 style="margin: 0; font-size: 1.5rem;">{{ $activePdf ? 'Active' : 'None' }}</h3>
            </div>
        </div>
    </div>

    <div class="card">
        <h3>Quick Actions</h3>
        <div style="display: flex; gap: 16px; margin-top: 16px;">
            <a href="{{ route('dashboard.menu.index') }}" class="btn btn-secondary">Edit Menu</a>
            <a href="{{ route('dashboard.qr.edit') }}" class="btn btn-secondary">Download QR Code</a>
        </div>
    </div>
@endsection
