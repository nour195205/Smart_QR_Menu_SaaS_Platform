@extends('layouts.dashboard')

@section('content')
<div x-data="themeBuilder()">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="page-title">No-Code Visual Builder</h1>
            <p class="page-subtitle">Design your menu visually. Changes update in real-time.</p>
        </div>
        
        <div style="display: flex; gap: 12px;">
            <button type="button" class="btn btn-secondary" @click="applyPreset('modern')">☕ Modern Cafe</button>
            <button type="button" class="btn btn-secondary" @click="applyPreset('luxury')">✨ Luxury</button>
            <button type="button" class="btn btn-secondary" @click="applyPreset('dark')">🌙 Dark Premium</button>
        </div>
    </div>

    <form id="themeForm" method="POST" action="{{ route('dashboard.theme.update') }}">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start;">
            
            <!-- LEFT PANEL: CONTROLS -->
            <div class="controls-panel card" style="max-height: 80vh; overflow-y: auto;">
                
                <!-- GLOBAL COLORS -->
                <h3 style="margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 8px; color: var(--text-primary);">Global Colors</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group">
                        <label class="form-label">Primary Accent</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.primary_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="primary_color" x-model="theme.primary_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Secondary Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.secondary_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="secondary_color" x-model="theme.secondary_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Background Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.background_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="background_color" x-model="theme.background_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">General Text</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.text_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="text_color" x-model="theme.text_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                </div>

                <!-- TYPOGRAPHY -->
                <h3 style="margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 8px; color: var(--text-primary);">Typography & Layout</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group">
                        <label class="form-label">Font Family</label>
                        <select name="font_family" x-model="theme.font_family" class="form-control" style="height: 40px;">
                            <option value="Outfit">Outfit (Modern)</option>
                            <option value="Inter">Inter (Clean)</option>
                            <option value="Playfair Display">Playfair (Elegant)</option>
                            <option value="Roboto">Roboto (Classic)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Layout Style</label>
                        <select name="layout_style" x-model="theme.layout_style" class="form-control" style="height: 40px;">
                            <option value="grid">Grid (Cards)</option>
                            <option value="list">List (Rows)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Image Position</label>
                        <select name="advanced_settings[image_position]" x-model="theme.advanced.image_position" class="form-control" style="height: 40px;">
                            <option value="top">Top</option>
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Image Shape</label>
                        <select name="advanced_settings[image_shape]" x-model="theme.advanced.image_shape" class="form-control" style="height: 40px;">
                            <option value="square">Square / Rectangle</option>
                            <option value="rounded">Rounded</option>
                            <option value="circle">Circle</option>
                        </select>
                    </div>
                </div>

                <!-- ITEM CARD STYLES -->
                <h3 style="margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 8px; color: var(--text-primary);">Item Card Design</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group">
                        <label class="form-label">Card Background</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.card_background_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="card_background_color" x-model="theme.card_background_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Item Title Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.item_title_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="item_title_color" x-model="theme.item_title_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Price Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.item_price_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="item_price_color" x-model="theme.item_price_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.item_description_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="item_description_color" x-model="theme.item_description_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category Title Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" x-model="theme.category_title_color" style="height: 40px; width: 40px; padding: 0; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="category_title_color" x-model="theme.category_title_color" class="form-control" style="height: 40px;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Text Alignment</label>
                        <select name="text_alignment" x-model="theme.text_alignment" class="form-control" style="height: 40px;">
                            <option value="left">Left</option>
                            <option value="center">Center</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Card Style</label>
                        <select name="card_style" x-model="theme.card_style" class="form-control" style="height: 40px;">
                            <option value="rounded">Rounded</option>
                            <option value="flat">Flat</option>
                            <option value="shadow">Shadow</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hover Effect</label>
                        <select name="advanced_settings[card_hover_effect]" x-model="theme.advanced.card_hover_effect" class="form-control" style="height: 40px;">
                            <option value="none">None</option>
                            <option value="lift">Lift Up</option>
                            <option value="scale">Scale Outline</option>
                        </select>
                    </div>
                </div>

                <!-- ANIMATIONS -->
                <h3 style="margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 8px; color: var(--text-primary);">Animations</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group">
                        <label class="form-label">Animation Style</label>
                        <select name="advanced_settings[animation_style]" x-model="theme.advanced.animation_style" class="form-control" style="height: 40px;">
                            <option value="none">No Animation</option>
                            <option value="fade">Fade In</option>
                            <option value="slide_up">Slide Up</option>
                            <option value="scale">Scale In</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Animation Speed</label>
                        <select name="advanced_settings[animation_speed]" x-model="theme.advanced.animation_speed" class="form-control" style="height: 40px;">
                            <option value="fast">Fast</option>
                            <option value="normal">Normal</option>
                            <option value="slow">Slow</option>
                        </select>
                    </div>
                </div>

                <div style="position: sticky; bottom: 0; background: var(--bg-surface); padding-top: 16px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; z-index: 10;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 12px;">Save Theme & Publish</button>
                </div>
            </div>

            <!-- RIGHT PANEL: LIVE PREVIEW -->
            <div class="preview-panel" style="background: #f3f4f6; border-radius: 32px; border: 8px solid #1f2937; padding: 0; overflow: hidden; height: 800px; max-height: 85vh; position: sticky; top: 20px; display: flex; flex-direction: column;">
                <!-- Browser/Phone Header bar -->
                <div style="background: #1f2937; height: 24px; width: 100%; display: flex; justify-content: center; align-items: center;">
                    <div style="width: 60px; height: 6px; background: #374151; border-radius: 10px;"></div>
                </div>
                
                <!-- Preview Canvas -->
                <div class="preview-canvas" :style="cssVars" style="flex: 1; overflow-y: auto; background: var(--bg-color); color: var(--text-color); font-family: var(--font-family); padding: 24px; transition: all 0.3s ease;">
                    
                    <!-- Header -->
                    <div style="text-align: center; margin-bottom: 32px;">
                        <div style="width: 80px; height: 80px; background: var(--primary-color); border-radius: 50%; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">Logo</div>
                        <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 8px;">{{ $restaurant->name }}</h1>
                        <p style="opacity: 0.8;">The best food in town. Served fresh.</p>
                    </div>

                    <!-- Category Title -->
                    <div style="margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--primary-color); display: inline-block;">
                        <h2 style="font-size: 1.5rem; font-weight: bold; color: var(--category-title-color);">Main Courses</h2>
                    </div>

                    <!-- Item Cards Container -->
                    <div :style="layoutVars" style="display: grid; gap: 24px; width: 100%;">
                        
                        <!-- Dummy Card 1 -->
                        <div class="preview-card" :style="cardVars" :class="cardClasses" style="background: var(--card-bg-custom); overflow: hidden; transition: all 0.3s ease;">
                            <div :style="imageContainerVars">
                                <div :style="imageVars" style="background: #d1d5db; width: 100%;"></div>
                            </div>
                            <div style="padding: 16px; display: flex; flex-direction: column; gap: 8px; text-align: var(--text-align);">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--item-title-color); margin: 0;">Classic Burger</h3>
                                    <span style="font-size: 1.125rem; font-weight: 700; color: var(--item-price-color); white-space: nowrap;">$12.99</span>
                                </div>
                                <p style="font-size: 0.875rem; color: var(--item-desc-color); margin: 0;">Juicy beef patty with lettuce, tomato, and our special sauce.</p>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;" :style="{ justifyContent: theme.text_alignment === 'center' ? 'center' : theme.text_alignment === 'right' ? 'flex-end' : 'flex-start' }">
                                    <span style="font-size: 0.75rem; padding: 2px 8px; background: var(--primary-color); color: white; border-radius: 12px;">Popular</span>
                                </div>
                            </div>
                        </div>

                        <!-- Dummy Card 2 -->
                        <div class="preview-card" :style="cardVars" :class="cardClasses" style="background: var(--card-bg-custom); overflow: hidden; transition: all 0.3s ease;">
                            <div :style="imageContainerVars">
                                <div :style="imageVars" style="background: #d1d5db; width: 100%;"></div>
                            </div>
                            <div style="padding: 16px; display: flex; flex-direction: column; gap: 8px; text-align: var(--text-align);">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--item-title-color); margin: 0;">Margherita Pizza</h3>
                                    <span style="font-size: 1.125rem; font-weight: 700; color: var(--item-price-color); white-space: nowrap;">$14.50</span>
                                </div>
                                <p style="font-size: 0.875rem; color: var(--item-desc-color); margin: 0;">Fresh tomatoes, mozzarella, and basil baked in wood fire.</p>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;" :style="{ justifyContent: theme.text_alignment === 'center' ? 'center' : theme.text_alignment === 'right' ? 'flex-end' : 'flex-start' }">
                                    <span style="font-size: 0.75rem; padding: 2px 8px; background: var(--primary-color); color: white; border-radius: 12px;">Veg</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>

<style>
    /* Card Styles for Live Preview */
    .preview-card.card-rounded { border-radius: 16px; }
    .preview-card.card-flat { border-radius: 0px; border: 1px solid rgba(0,0,0,0.1); }
    .preview-card.card-shadow { border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1); border: none; }
</style>

<script>
    function themeBuilder() {
        return {
            theme: {
                primary_color: '{{ old('primary_color', $theme->primary_color ?? '#FF6B35') }}',
                secondary_color: '{{ old('secondary_color', $theme->secondary_color ?? '#2E294E') }}',
                background_color: '{{ old('background_color', $theme->background_color ?? '#FFFFFF') }}',
                text_color: '{{ old('text_color', $theme->text_color ?? '#1A1A2E') }}',
                category_title_color: '{{ old('category_title_color', $theme->category_title_color ?? '#1A1A2E') }}',
                item_title_color: '{{ old('item_title_color', $theme->item_title_color ?? '#1A1A2E') }}',
                item_description_color: '{{ old('item_description_color', $theme->item_description_color ?? '#666666') }}',
                item_price_color: '{{ old('item_price_color', $theme->item_price_color ?? '#FF6B35') }}',
                card_background_color: '{{ old('card_background_color', $theme->card_background_color ?? '#FFFFFF') }}',
                text_alignment: '{{ old('text_alignment', $theme->text_alignment ?? 'left') }}',
                font_family: '{{ old('font_family', $theme->font_family ?? 'Outfit') }}',
                card_style: '{{ old('card_style', $theme->card_style ?? 'rounded') }}',
                layout_style: '{{ old('layout_style', $theme->layout_style ?? 'grid') }}',
                
                advanced: {
                    image_position: '{{ old('advanced_settings.image_position', $theme->advanced_settings['image_position'] ?? 'top') }}',
                    image_shape: '{{ old('advanced_settings.image_shape', $theme->advanced_settings['image_shape'] ?? 'square') }}',
                    card_hover_effect: '{{ old('advanced_settings.card_hover_effect', $theme->advanced_settings['card_hover_effect'] ?? 'lift') }}',
                    animation_style: '{{ old('advanced_settings.animation_style', $theme->advanced_settings['animation_style'] ?? 'fade') }}',
                    animation_speed: '{{ old('advanced_settings.animation_speed', $theme->advanced_settings['animation_speed'] ?? 'normal') }}',
                }
            },
            
            get cssVars() {
                return {
                    '--primary-color': this.theme.primary_color,
                    '--bg-color': this.theme.background_color,
                    '--text-color': this.theme.text_color,
                    '--font-family': `"${this.theme.font_family}", sans-serif`,
                    '--card-bg-custom': this.theme.card_background_color,
                    '--item-title-color': this.theme.item_title_color,
                    '--item-price-color': this.theme.item_price_color,
                    '--item-desc-color': this.theme.item_description_color,
                    '--category-title-color': this.theme.category_title_color,
                    '--text-align': this.theme.text_alignment,
                }
            },

            get layoutVars() {
                return {
                    'gridTemplateColumns': this.theme.layout_style === 'grid' ? 'repeat(auto-fill, minmax(280px, 1fr))' : '1fr',
                }
            },

            get cardVars() {
                const isHorizontal = this.theme.advanced.image_position === 'left' || this.theme.advanced.image_position === 'right';
                return {
                    'display': 'flex',
                    'flexDirection': isHorizontal ? (this.theme.advanced.image_position === 'left' ? 'row' : 'row-reverse') : 'column',
                    'border': this.theme.card_style === 'rounded' ? '1px solid rgba(0,0,0,0.05)' : 'none',
                    'transform': this.theme.advanced.card_hover_effect === 'lift' ? 'translateY(-2px)' : 'none',
                }
            },

            get imageContainerVars() {
                const isHorizontal = this.theme.advanced.image_position === 'left' || this.theme.advanced.image_position === 'right';
                return {
                    'width': isHorizontal ? '120px' : '100%',
                    'flexShrink': '0',
                    'padding': this.theme.advanced.image_shape === 'circle' ? '16px' : '0',
                }
            },

            get imageVars() {
                const isHorizontal = this.theme.advanced.image_position === 'left' || this.theme.advanced.image_position === 'right';
                const shape = this.theme.advanced.image_shape;
                return {
                    'height': isHorizontal ? '120px' : '200px',
                    'borderRadius': shape === 'circle' ? '50%' : (shape === 'rounded' ? '12px' : '0'),
                    'margin': shape === 'circle' && isHorizontal ? 'auto' : '0',
                }
            },

            get cardClasses() {
                return {
                    'card-rounded': this.theme.card_style === 'rounded',
                    'card-flat': this.theme.card_style === 'flat',
                    'card-shadow': this.theme.card_style === 'shadow',
                }
            },
            
            applyPreset(preset) {
                if(preset === 'dark') {
                    this.theme.background_color = '#111827';
                    this.theme.card_background_color = '#1F2937';
                    this.theme.text_color = '#F9FAFB';
                    this.theme.category_title_color = '#F9FAFB';
                    this.theme.item_title_color = '#F9FAFB';
                    this.theme.item_description_color = '#9CA3AF';
                    this.theme.item_price_color = '#F59E0B';
                    this.theme.primary_color = '#F59E0B';
                    this.theme.font_family = 'Playfair Display';
                    this.theme.card_style = 'shadow';
                    this.theme.advanced.image_shape = 'rounded';
                }
                if(preset === 'luxury') {
                    this.theme.background_color = '#FAF9F6';
                    this.theme.card_background_color = '#FFFFFF';
                    this.theme.text_color = '#2C3E50';
                    this.theme.category_title_color = '#D4AF37';
                    this.theme.item_title_color = '#2C3E50';
                    this.theme.item_description_color = '#7F8C8D';
                    this.theme.item_price_color = '#D4AF37';
                    this.theme.primary_color = '#D4AF37';
                    this.theme.font_family = 'Playfair Display';
                    this.theme.text_alignment = 'center';
                    this.theme.card_style = 'flat';
                    this.theme.advanced.image_position = 'top';
                    this.theme.advanced.image_shape = 'square';
                }
                if(preset === 'modern') {
                    this.theme.background_color = '#F3F4F6';
                    this.theme.card_background_color = '#FFFFFF';
                    this.theme.text_color = '#1F2937';
                    this.theme.category_title_color = '#111827';
                    this.theme.item_title_color = '#111827';
                    this.theme.item_description_color = '#6B7280';
                    this.theme.item_price_color = '#10B981';
                    this.theme.primary_color = '#10B981';
                    this.theme.font_family = 'Inter';
                    this.theme.text_alignment = 'left';
                    this.theme.card_style = 'rounded';
                    this.theme.advanced.image_position = 'left';
                    this.theme.advanced.image_shape = 'rounded';
                    this.theme.layout_style = 'list';
                }
            }
        }
    }
</script>
@endsection
