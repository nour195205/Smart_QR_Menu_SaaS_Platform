<?php

namespace App\Observers;

use App\Models\Theme;

/**
 * Marks the parent restaurant as having unpublished changes
 * whenever the theme is saved (theme changes affect public JSON).
 */
class ThemeObserver
{
    public function created(Theme $theme): void
    {
        $theme->restaurant->markDirty();
    }

    public function updated(Theme $theme): void
    {
        $theme->restaurant->markDirty();
    }
}
