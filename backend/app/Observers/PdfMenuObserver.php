<?php

namespace App\Observers;

use App\Models\PdfMenu;

/**
 * Marks the parent restaurant as having unpublished changes
 * whenever a PDF menu is uploaded or deleted.
 */
class PdfMenuObserver
{
    public function created(PdfMenu $pdfMenu): void
    {
        $pdfMenu->restaurant->markDirty();
    }

    public function deleted(PdfMenu $pdfMenu): void
    {
        $pdfMenu->restaurant->markDirty();
    }
}
