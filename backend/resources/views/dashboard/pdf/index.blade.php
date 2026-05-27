@extends('layouts.dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 class="page-title" style="margin: 0;">PDF Menus</h1>
        <a href="{{ route('dashboard.menu.index') }}" class="btn btn-secondary">Switch to Dynamic Menu</a>
    </div>
    <p class="page-subtitle">Upload a PDF file instead of building a dynamic menu. Your customers will see the PDF viewer when they scan the QR code.</p>

    <div class="card" style="margin-bottom: 32px;">
        <form method="POST" action="{{ route('dashboard.pdf.store') }}" enctype="multipart/form-data" style="display: flex; align-items: flex-end; gap: 16px;">
            @csrf
            <div class="form-group" style="flex: 1; margin: 0;">
                <label class="form-label" for="pdf_file">Upload New PDF Menu</label>
                <input type="file" id="pdf_file" name="pdf_file" class="form-control" accept="application/pdf" required>
                @error('pdf_file') <div style="color: var(--danger); font-size: 0.875rem; margin-top: 8px;">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="height: 48px;">Upload</button>
        </form>
    </div>

    @if($pdfMenus->count() > 0)
        <div class="item-list">
            @foreach($pdfMenus as $pdf)
                <div class="item-row">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 12px; border-radius: 8px;">
                            <i data-lucide="file-text"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: 1.1rem;">{{ $pdf->original_name }}</h4>
                            <p style="margin: 4px 0 0; color: var(--text-secondary); font-size: 0.875rem;">Uploaded {{ $pdf->created_at->diffForHumans() }}</p>
                            @if($loop->first)
                                <span style="display: inline-block; margin-top: 8px; background: rgba(16, 185, 129, 0.2); color: var(--success); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">ACTIVE</span>
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ $pdf->pdf_url }}" target="_blank" class="btn btn-secondary">View PDF</a>
                        <form method="POST" action="{{ route('dashboard.pdf.destroy', $pdf->id) }}" onsubmit="return confirm('Are you sure you want to delete this PDF?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i data-lucide="trash-2" style="width: 18px;"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 48px; border: 1px dashed var(--border); border-radius: 12px; color: var(--text-secondary);">
            <i data-lucide="file-text" style="width: 48px; height: 48px; opacity: 0.5; margin-bottom: 16px;"></i>
            <p>You haven't uploaded any PDF menus yet.</p>
        </div>
    @endif
@endsection
