<?php

namespace App\Http\Controllers;

use App\Http\Requests\PdfMenuRequest;
use App\Models\PdfMenu;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * PDF menu management.
 */
class PdfMenuController extends Controller
{
    public function __construct(private readonly CloudinaryService $cloudinary) {}

    public function index(Request $request): View
    {
        $restaurant = $request->attributes->get('restaurant');
        $pdfMenus = $restaurant->pdfMenus()->latest()->get();
        return view('dashboard.pdf.index', compact('restaurant', 'pdfMenus'));
    }

    public function store(PdfMenuRequest $request): RedirectResponse
    {
        $restaurant = $request->attributes->get('restaurant');

        try {
            $upload = $this->cloudinary->uploadPdf($request->file('pdf_file')->getRealPath(), "qrmenu/{$restaurant->slug}/pdfs");
        } catch (\Exception $e) {
            return back()->with('error', 'PDF upload failed: ' . $e->getMessage());
        }

        $restaurant->pdfMenus()->create([
            'original_name' => $request->file('pdf_file')->getClientOriginalName(),
            'pdf_url'       => $upload['url'],
        ]);
        
        $restaurant->markDirty();

        return redirect()->route('dashboard.pdf.index')->with('success', 'PDF Menu uploaded successfully.');
    }

    public function destroy(Request $request, PdfMenu $pdfMenu): RedirectResponse
    {
        if ($pdfMenu->restaurant_id !== $request->attributes->get('restaurant')->id) {
            abort(403, 'Unauthorized action.');
        }

        // Optional: delete from Cloudinary here if public_id was saved (we only saved URL).
        // To keep it simple, we just delete the record for now.
        $pdfMenu->delete();
        
        $request->attributes->get('restaurant')->markDirty();

        return redirect()->route('dashboard.pdf.index')->with('success', 'PDF Menu deleted successfully.');
    }
}
