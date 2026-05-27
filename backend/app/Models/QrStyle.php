<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrStyle extends Model
{
    protected $fillable = [
        'restaurant_id',
        'dot_style',
        'corner_square_style',
        'corner_dot_style',
        'dot_color',
        'background_color',
        'gradient_enabled',
        'gradient_color_1',
        'gradient_color_2',
        'gradient_type',
        'logo_url',
        'frame_style',
        'top_text',
        'bottom_text',
    ];

    protected $casts = [
        'gradient_enabled' => 'boolean',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
