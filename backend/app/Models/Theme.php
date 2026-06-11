<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theme extends Model
{
    protected $fillable = [
        'restaurant_id',
        'primary_color',
        'secondary_color',
        'background_color',
        'text_color',
        'category_title_color',
        'item_title_color',
        'item_description_color',
        'item_price_color',
        'card_background_color',
        'text_alignment',
        'font_family',
        'card_style',
        'dark_mode',
        'layout_style',
        'advanced_settings',
    ];

    protected $casts = [
        'dark_mode' => 'boolean',
        'advanced_settings' => 'array',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
