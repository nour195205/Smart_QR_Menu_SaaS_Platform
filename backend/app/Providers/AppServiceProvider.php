<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Item;
use App\Models\PdfMenu;
use App\Models\Theme;
use App\Observers\CategoryObserver;
use App\Observers\ItemObserver;
use App\Observers\PdfMenuObserver;
use App\Observers\ThemeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Registers model observers that automatically mark the restaurant as
     * having unpublished changes whenever menu-related data is modified.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
        Item::observe(ItemObserver::class);
        Theme::observe(ThemeObserver::class);
        PdfMenu::observe(PdfMenuObserver::class);
    }
}

