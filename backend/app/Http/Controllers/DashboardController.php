<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard overview.
     */
    public function index(Request $request): View
    {
        $restaurant = $request->attributes->get('restaurant');

        // Calculate some basic stats
        $categoriesCount = $restaurant->categories()->count();
        $itemsCount = $restaurant->items()->count();
        $activePdf = $restaurant->pdfMenus()->latest()->first();

        return view('dashboard.index', compact('restaurant', 'categoriesCount', 'itemsCount', 'activePdf'));
    }
}
