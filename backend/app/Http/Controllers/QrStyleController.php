<?php

namespace App\Http\Controllers;

use App\Http\Requests\QrStyleRequest;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * QR code customization management.
 */
class QrStyleController extends Controller
{
    public function __construct(private readonly CloudinaryService $cloudinary) {}

    public function edit(Request $request): View
    {
        $restaurant = $request->attributes->get('restaurant');
        $qrStyle = $restaurant->qrStyle;
        return view('dashboard.qr.index', compact('restaurant', 'qrStyle'));
    }

    public function update(QrStyleRequest $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');
        $data = $request->validated();

        try {
            if ($request->hasFile('logo')) {
                $upload = $this->cloudinary->uploadImage($request->file('logo')->getRealPath(), "qrmenu/{$restaurant->slug}/qr");
                $data['logo_url'] = $upload['url'];
            } elseif (!empty($data['remove_logo'])) {
                $data['logo_url'] = null;
            }
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Image upload failed: ' . $e->getMessage());
        }

        $restaurant->qrStyle()->updateOrCreate(
            ['restaurant_id' => $restaurant->id],
            $data
        );

        return redirect()->route('dashboard.qr.edit')->with('success', 'QR Code style updated successfully.');
    }
}
