<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;

/**
 * Builds the complete static JSON structure for a restaurant's public menu.
 *
 * This JSON is the ONLY data source for customer-facing pages.
 * It is generated on publish and synced to GitHub → served by Netlify CDN.
 */
class MenuJsonGenerator
{
    /**
     * Generate the full JSON payload for a restaurant.
     *
     * @return array<string, mixed>
     */
    public function generate(Restaurant $restaurant): array
    {
        // Eager-load all required relationships in one query set
        $restaurant->loadMissing([
            'categories.items',
            'theme',
            'pdfMenus' => fn ($query) => $query->latest()->limit(1),
        ]);

        return [
            'restaurant' => $this->buildRestaurantData($restaurant),
            'theme'      => $this->buildThemeData($restaurant),
            'categories' => $this->buildCategoriesData($restaurant),
            'pdf_url'    => $this->getActivePdfUrl($restaurant),
            'generated_at' => now()->toIso8601String(),
        ];
    }

    // ─── Private builders ────────────────────────────────────────────────────

    /**
     * @return array<string, mixed>
     */
    private function buildRestaurantData(Restaurant $restaurant): array
    {
        return [
            'name'            => $restaurant->name,
            'slug'            => $restaurant->slug,
            'logo_url'        => $restaurant->logo_url,
            'cover_url'       => $restaurant->cover_url,
            'description'     => $restaurant->description,
            'phone'           => $restaurant->phone,
            'address'         => $restaurant->address,
            'social_links'    => $restaurant->social_links ?? [],
            'menu_type'       => $restaurant->menu_type,
            'currency_code'   => $restaurant->currency_code,
            'currency_symbol' => $restaurant->currency_symbol,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function buildThemeData(Restaurant $restaurant): ?array
    {
        $theme = $restaurant->theme;

        if (! $theme) {
            return null;
        }

        return [
            'primary_color'    => $theme->primary_color,
            'secondary_color'  => $theme->secondary_color,
            'background_color' => $theme->background_color,
            'text_color'       => $theme->text_color,
            'font_family'      => $theme->font_family,
            'card_style'       => $theme->card_style,
            'dark_mode'        => (bool) $theme->dark_mode,
            'layout_style'     => $theme->layout_style,
        ];
    }

    /**
     * Build categories array — only for dynamic menus.
     * Inactive categories and unavailable items are excluded from the JSON
     * to keep the payload lean. Available items are always included.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildCategoriesData(Restaurant $restaurant): array
    {
        if ($restaurant->menu_type !== 'dynamic') {
            return [];
        }

        return $restaurant->categories
            ->where('is_active', true)
            ->values()
            ->map(fn (Category $category) => [
                'id'          => $category->id,
                'name'        => $category->name,
                'description' => $category->description,
                'image_url'   => $category->image_url,
                'items'       => $this->buildItemsData($category, $restaurant),
            ])
            ->toArray();
    }

    /**
     * Build items for a single category.
     * All items (available and unavailable) are included so the frontend
     * can style unavailable items as greyed-out/sold-out.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildItemsData(Category $category, Restaurant $restaurant): array
    {
        return $category->items
            ->values()
            ->map(fn (Item $item) => [
                'id'              => $item->id,
                'name'            => $item->name,
                'description'     => $item->description,
                'price'           => number_format((float) $item->price, 2, '.', ''),
                'currency_symbol' => $restaurant->currency_symbol,
                'image_url'       => $item->image_url, // null is valid — frontend handles gracefully
                'tags'            => $item->tags ?? [],
                'is_available'    => (bool) $item->is_available,
            ])
            ->toArray();
    }

    /**
     * Returns the Cloudinary URL of the most recently uploaded PDF,
     * or null if no PDF exists.
     */
    private function getActivePdfUrl(Restaurant $restaurant): ?string
    {
        return $restaurant->pdfMenus->first()?->pdf_url;
    }
}
