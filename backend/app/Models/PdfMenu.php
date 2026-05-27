<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PdfMenu extends Model
{
    protected $fillable = [
        'restaurant_id',
        'pdf_url',
        'original_name',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
