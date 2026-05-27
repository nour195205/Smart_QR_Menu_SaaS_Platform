<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Theme settings management.
 */
class ThemeController extends Controller
{
    public function edit(Request $request): View
    {
        $restaurant = $request->attributes->get('restaurant');
        $theme = $restaurant->theme;
        return view('dashboard.theme.index', compact('restaurant', 'theme'));
    }

    public function update(ThemeRequest $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');
        
        $restaurant->theme()->updateOrCreate(
            ['restaurant_id' => $restaurant->id],
            $request->validated()
        );

        return redirect()->route('dashboard.theme.edit')->with('success', 'Theme updated successfully.');
    }
}
