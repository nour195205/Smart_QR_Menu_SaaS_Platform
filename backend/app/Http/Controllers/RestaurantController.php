<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantUpdateRequest;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Restaurant profile management.
 */
class RestaurantController extends Controller
{
    public function __construct(private readonly CloudinaryService $cloudinary) {}

    public function edit(Request $request): View
    {
        $restaurant = $request->attributes->get('restaurant');
        return view('dashboard.restaurant.settings', compact('restaurant'));
    }

    public function update(RestaurantUpdateRequest $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');
        $data = $request->validated();

        try {
            if ($request->hasFile('logo')) {
                $upload = $this->cloudinary->uploadImage($request->file('logo')->getRealPath(), "qrmenu/{$restaurant->slug}/logo");
                $data['logo_url'] = $upload['url'];
            }

            if ($request->hasFile('cover')) {
                $upload = $this->cloudinary->uploadImage($request->file('cover')->getRealPath(), "qrmenu/{$restaurant->slug}/cover");
                $data['cover_url'] = $upload['url'];
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Image upload failed: ' . $e->getMessage());
        }

        $restaurant->update($data);

        return redirect()->route('dashboard.restaurant.edit')->with('success', 'Restaurant settings updated successfully.');
    }
}
