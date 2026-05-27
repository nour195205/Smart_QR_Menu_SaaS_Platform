<?php

namespace App\Observers;

use App\Models\Category;

/**
 * Marks the parent restaurant as having unpublished changes
 * whenever a category is created, updated, or deleted.
 */
class CategoryObserver
{
    public function created(Category $category): void
    {
        $category->restaurant->markDirty();
    }

    public function updated(Category $category): void
    {
        $category->restaurant->markDirty();
    }

    public function deleted(Category $category): void
    {
        $category->restaurant->markDirty();
    }
}
