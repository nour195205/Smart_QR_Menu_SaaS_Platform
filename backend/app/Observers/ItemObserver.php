<?php

namespace App\Observers;

use App\Models\Item;

/**
 * Marks the parent restaurant as having unpublished changes
 * whenever an item is created, updated, or deleted.
 */
class ItemObserver
{
    public function created(Item $item): void
    {
        $item->restaurant->markDirty();
    }

    public function updated(Item $item): void
    {
        $item->restaurant->markDirty();
    }

    public function deleted(Item $item): void
    {
        $item->restaurant->markDirty();
    }
}
