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
        'font_family',
        'card_style',
        'dark_mode',
        'layout_style',
    ];

    protected $casts = [
        'dark_mode' => 'boolean',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
