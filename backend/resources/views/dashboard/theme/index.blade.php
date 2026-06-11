@extends('layouts.dashboard')

@section('content')
    <h1 class="page-title">Theme & Brand</h1>
    <p class="page-subtitle">Customize the appearance of your public menu.</p>

    <div class="card" style="max-width: 800px;">
        <form method="POST" action="{{ route('dashboard.theme.update') }}">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div class="form-group">
                    <label class="form-label" for="primary_color">Primary Color (Accent)</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $theme->primary_color ?? '#FF6B35') }}" oninput="document.getElementById('primary_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="primary_color_text" class="form-control" value="{{ old('primary_color', $theme->primary_color ?? '#FF6B35') }}" oninput="document.getElementById('primary_color').value = this.value">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="secondary_color">Secondary Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $theme->secondary_color ?? '#2E294E') }}" oninput="document.getElementById('secondary_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="secondary_color_text" class="form-control" value="{{ old('secondary_color', $theme->secondary_color ?? '#2E294E') }}" oninput="document.getElementById('secondary_color').value = this.value">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="background_color">Page Background Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="background_color" name="background_color" value="{{ old('background_color', $theme->background_color ?? '#FFFFFF') }}" oninput="document.getElementById('background_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="background_color_text" class="form-control" value="{{ old('background_color', $theme->background_color ?? '#FFFFFF') }}" oninput="document.getElementById('background_color').value = this.value">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="text_color">General Text Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="text_color" name="text_color" value="{{ old('text_color', $theme->text_color ?? '#1A1A2E') }}" oninput="document.getElementById('text_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="text_color_text" class="form-control" value="{{ old('text_color', $theme->text_color ?? '#1A1A2E') }}" oninput="document.getElementById('text_color').value = this.value">
                    </div>
                </div>
            </div>

            <h3 style="margin-top: 32px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Advanced Granular Styles</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
                <div class="form-group">
                    <label class="form-label" for="category_title_color">Category Title Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="category_title_color" name="category_title_color" value="{{ old('category_title_color', $theme->category_title_color ?? '#1A1A2E') }}" oninput="document.getElementById('category_title_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="category_title_color_text" class="form-control" value="{{ old('category_title_color', $theme->category_title_color ?? '#1A1A2E') }}" oninput="document.getElementById('category_title_color').value = this.value">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="item_title_color">Item Title Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="item_title_color" name="item_title_color" value="{{ old('item_title_color', $theme->item_title_color ?? '#1A1A2E') }}" oninput="document.getElementById('item_title_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="item_title_color_text" class="form-control" value="{{ old('item_title_color', $theme->item_title_color ?? '#1A1A2E') }}" oninput="document.getElementById('item_title_color').value = this.value">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="item_description_color">Item Description Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="item_description_color" name="item_description_color" value="{{ old('item_description_color', $theme->item_description_color ?? '#666666') }}" oninput="document.getElementById('item_description_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="item_description_color_text" class="form-control" value="{{ old('item_description_color', $theme->item_description_color ?? '#666666') }}" oninput="document.getElementById('item_description_color').value = this.value">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="item_price_color">Item Price Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="item_price_color" name="item_price_color" value="{{ old('item_price_color', $theme->item_price_color ?? '#FF6B35') }}" oninput="document.getElementById('item_price_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="item_price_color_text" class="form-control" value="{{ old('item_price_color', $theme->item_price_color ?? '#FF6B35') }}" oninput="document.getElementById('item_price_color').value = this.value">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="card_background_color">Card Background Color</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="color" id="card_background_color" name="card_background_color" value="{{ old('card_background_color', $theme->card_background_color ?? '#FFFFFF') }}" oninput="document.getElementById('card_background_color_text').value = this.value" style="height: 48px; width: 48px; border-radius: 8px; border: 1px solid var(--border); padding: 0;">
                        <input type="text" id="card_background_color_text" class="form-control" value="{{ old('card_background_color', $theme->card_background_color ?? '#FFFFFF') }}" oninput="document.getElementById('card_background_color').value = this.value">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="text_alignment">Card Text Alignment</label>
                    <select id="text_alignment" name="text_alignment" class="form-control" style="height: 48px;">
                        <option value="left" {{ old('text_alignment', $theme->text_alignment ?? '') == 'left' ? 'selected' : '' }}>Left</option>
                        <option value="center" {{ old('text_alignment', $theme->text_alignment ?? '') == 'center' ? 'selected' : '' }}>Center</option>
                        <option value="right" {{ old('text_alignment', $theme->text_alignment ?? '') == 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="font_family">Font Family</label>
                <select id="font_family" name="font_family" class="form-control">
                    <option value="Outfit" {{ old('font_family', $theme->font_family ?? '') == 'Outfit' ? 'selected' : '' }}>Outfit</option>
                    <option value="Inter" {{ old('font_family', $theme->font_family ?? '') == 'Inter' ? 'selected' : '' }}>Inter</option>
                    <option value="Roboto" {{ old('font_family', $theme->font_family ?? '') == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                    <option value="Playfair Display" {{ old('font_family', $theme->font_family ?? '') == 'Playfair Display' ? 'selected' : '' }}>Playfair Display</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="card_style">Item Card Style</label>
                <select id="card_style" name="card_style" class="form-control">
                    <option value="rounded" {{ old('card_style', $theme->card_style ?? '') == 'rounded' ? 'selected' : '' }}>Rounded (Modern)</option>
                    <option value="flat" {{ old('card_style', $theme->card_style ?? '') == 'flat' ? 'selected' : '' }}>Flat (Minimalist)</option>
                    <option value="shadow" {{ old('card_style', $theme->card_style ?? '') == 'shadow' ? 'selected' : '' }}>Shadow (Elevated)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="layout_style">Menu Layout</label>
                <select id="layout_style" name="layout_style" class="form-control">
                    <option value="grid" {{ old('layout_style', $theme->layout_style ?? '') == 'grid' ? 'selected' : '' }}>Grid</option>
                    <option value="list" {{ old('layout_style', $theme->layout_style ?? '') == 'list' ? 'selected' : '' }}>List</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 12px; margin-top: 24px;">
                <input type="hidden" name="dark_mode" value="0">
                <input type="checkbox" id="dark_mode" name="dark_mode" value="1" {{ old('dark_mode', $theme->dark_mode ?? false) ? 'checked' : '' }} style="width: 20px; height: 20px;">
                <label for="dark_mode" style="font-weight: 500; font-size: 1.1rem; margin: 0; cursor: pointer;">Enable Dark Mode Default</label>
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Save Theme Settings</button>
            </div>
        </form>
    </div>
@endsection
