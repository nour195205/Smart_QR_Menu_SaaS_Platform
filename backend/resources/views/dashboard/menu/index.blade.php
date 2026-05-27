@extends('layouts.dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 class="page-title" style="margin: 0;">Menu Builder</h1>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-secondary"><i data-lucide="plus"></i> Add Category</a>
            <a href="{{ route('dashboard.items.create') }}" class="btn btn-primary"><i data-lucide="plus"></i> Add Item</a>
        </div>
    </div>
    <p class="page-subtitle">Organize your menu structure. Drag and drop categories and items to reorder them.</p>

    <div class="card">
        @if($categories->isEmpty())
            <div style="text-align: center; padding: 48px; color: var(--text-secondary);">
                <i data-lucide="utensils-crossed" style="width: 48px; height: 48px; opacity: 0.5; margin-bottom: 16px;"></i>
                <p>Your menu is empty.</p>
                <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary" style="margin-top: 16px;">Create First Category</a>
            </div>
        @else
            <form id="reorder-categories-form" action="{{ route('dashboard.categories.reorder') }}" method="POST" style="display: none;">
                @csrf
            </form>
            
            <div id="category-list">
                @foreach($categories->sortBy('sort_order') as $category)
                    <div class="category-block" data-id="{{ $category->id }}" style="margin-bottom: 24px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main);">
                        <!-- Category Header -->
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: var(--bg-surface-hover); border-bottom: 1px solid var(--border); border-radius: 8px 8px 0 0;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i data-lucide="grip-vertical" class="drag-handle-category" style="cursor: grab; color: var(--text-secondary);"></i>
                                <h3 style="margin: 0;">{{ $category->name }}</h3>
                                @if(!$category->is_active)
                                    <span style="font-size: 0.75rem; background: rgba(239,68,68,0.1); color: var(--danger); padding: 4px 8px; border-radius: 4px;">Hidden</span>
                                @endif
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.875rem;">Edit</a>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="item-list-container" data-category-id="{{ $category->id }}" style="padding: 16px;">
                            <form id="reorder-items-form-{{ $category->id }}" action="{{ route('dashboard.items.reorder') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            
                            @if($category->items->isEmpty())
                                <p style="color: var(--text-secondary); margin: 0; font-size: 0.875rem;">No items in this category.</p>
                            @else
                                <div class="sortable-items" data-category="{{ $category->id }}" style="display: flex; flex-direction: column; gap: 8px;">
                                    @foreach($category->items->sortBy('sort_order') as $item)
                                        <div class="item-row" data-id="{{ $item->id }}" style="background: var(--bg-surface); padding: 12px; display: flex; align-items: center; justify-content: space-between;">
                                            <div style="display: flex; align-items: center; gap: 16px;">
                                                <i data-lucide="grip-vertical" class="drag-handle-item" style="cursor: grab; color: var(--text-secondary);"></i>
                                                @if($item->image_url)
                                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                                @else
                                                    <div style="width: 40px; height: 40px; border-radius: 8px; background: var(--bg-surface-hover); display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                                        <i data-lucide="image"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div style="font-weight: 500;">{{ $item->name }}</div>
                                                    <div style="color: var(--accent-primary); font-weight: 600; font-size: 0.875rem;">{{ $restaurant->currency_symbol }}{{ number_format($item->price, 2) }}</div>
                                                </div>
                                            </div>
                                            <div style="display: flex; gap: 8px;">
                                                <a href="{{ route('dashboard.items.edit', $item->id) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.875rem;">Edit</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    // Categories Sortable
    if (document.getElementById('category-list')) {
        new Sortable(document.getElementById('category-list'), {
            handle: '.drag-handle-category',
            animation: 150,
            onEnd: function (evt) {
                const form = document.getElementById('reorder-categories-form');
                const items = evt.to.children;
                form.innerHTML = '@csrf'; // Reset form
                for (let i = 0; i < items.length; i++) {
                    const id = items[i].getAttribute('data-id');
                    form.innerHTML += `<input type="hidden" name="order[${i}]" value="${id}">`;
                }
                form.submit();
            }
        });
    }

    // Items Sortable
    document.querySelectorAll('.sortable-items').forEach(function(el) {
        new Sortable(el, {
            handle: '.drag-handle-item',
            animation: 150,
            onEnd: function (evt) {
                const catId = el.getAttribute('data-category');
                const form = document.getElementById('reorder-items-form-' + catId);
                const items = evt.to.children;
                form.innerHTML = '@csrf';
                for (let i = 0; i < items.length; i++) {
                    const id = items[i].getAttribute('data-id');
                    form.innerHTML += `<input type="hidden" name="order[${i}]" value="${id}">`;
                }
                form.submit();
            }
        });
    });
</script>
@endsection
