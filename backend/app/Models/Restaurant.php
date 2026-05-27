<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Restaurant extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo_url',
        'cover_url',
        'description',
        'phone',
        'address',
        'social_links',
        'menu_type',
        'currency_code',
        'currency_symbol',
        'is_active',
        'has_unpublished_changes',
        'last_published_at',
        'last_sync_status',
        'sync_error_message',
    ];

    protected $casts = [
        'social_links'             => 'array',
        'is_active'                => 'boolean',
        'has_unpublished_changes'  => 'boolean',
        'last_published_at'        => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Categories ordered by sort_order ascending.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('sort_order');
    }

    /**
     * All items (regardless of category) — useful for JSON generation.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function theme(): HasOne
    {
        return $this->hasOne(Theme::class);
    }

    public function qrStyle(): HasOne
    {
        return $this->hasOne(QrStyle::class);
    }

    public function pdfMenus(): HasMany
    {
        return $this->hasMany(PdfMenu::class)->latest();
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Mark this restaurant as having unsaved/unpublished changes.
     * Called by model observers on every CRUD operation.
     */
    public function markDirty(): void
    {
        // Only update if not already marked — avoids unnecessary DB writes
        if (! $this->has_unpublished_changes) {
            $this->updateQuietly(['has_unpublished_changes' => true]);
        }
    }

    /**
     * Generate a URL-safe slug from a given name,
     * appending a numeric suffix to ensure uniqueness.
     */
    public static function generateUniqueSlug(string $name): string
    {
        $base    = \Illuminate\Support\Str::slug($name);
        $slug    = $base;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
