@extends('layouts.dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 class="page-title" style="margin: 0;">QR Code Customization</h1>
            <p class="page-subtitle" style="margin-top: 8px;">Design the QR code that your customers will scan to view the menu.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 16px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 16px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="qr-layout" style="display: grid; grid-template-columns: 1fr 350px; gap: 32px; align-items: start;">
        
        <!-- Left Column: Settings Form -->
        <div class="card">
            <form id="qr-form" method="POST" action="{{ route('dashboard.qr.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Dot Style & Color -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="dot_style">Dot Style</label>
                        <select id="dot_style" name="dot_style" class="form-control">
                            <option value="square" {{ old('dot_style', $qrStyle?->dot_style) == 'square' ? 'selected' : '' }}>Square</option>
                            <option value="dots" {{ old('dot_style', $qrStyle?->dot_style) == 'dots' ? 'selected' : '' }}>Dots</option>
                            <option value="rounded" {{ old('dot_style', $qrStyle?->dot_style) == 'rounded' ? 'selected' : '' }}>Rounded</option>
                            <option value="extra-rounded" {{ old('dot_style', $qrStyle?->dot_style) == 'extra-rounded' ? 'selected' : '' }}>Extra Rounded</option>
                            <option value="classy" {{ old('dot_style', $qrStyle?->dot_style) == 'classy' ? 'selected' : '' }}>Classy</option>
                            <option value="classy-rounded" {{ old('dot_style', $qrStyle?->dot_style) == 'classy-rounded' ? 'selected' : '' }}>Classy Rounded</option>
                        </select>
                        @error('dot_style') <div style="color: var(--danger); font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="dot_color">Foreground Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" id="dot_color_picker" class="form-control" style="width: 48px; padding: 4px; cursor: pointer;" value="{{ old('dot_color', $qrStyle?->dot_color ?? '#000000') }}">
                            <input type="text" id="dot_color" name="dot_color" class="form-control" style="flex: 1;" value="{{ old('dot_color', $qrStyle?->dot_color ?? '#000000') }}">
                        </div>
                        @error('dot_color') <div style="color: var(--danger); font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Corner Styles -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="corner_square_style">Corner Square Style</label>
                        <select id="corner_square_style" name="corner_square_style" class="form-control">
                            <option value="square" {{ old('corner_square_style', $qrStyle?->corner_square_style) == 'square' ? 'selected' : '' }}>Square</option>
                            <option value="dot" {{ old('corner_square_style', $qrStyle?->corner_square_style) == 'dot' ? 'selected' : '' }}>Dot</option>
                            <option value="extra-rounded" {{ old('corner_square_style', $qrStyle?->corner_square_style) == 'extra-rounded' ? 'selected' : '' }}>Extra Rounded</option>
                        </select>
                        @error('corner_square_style') <div style="color: var(--danger); font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="corner_dot_style">Corner Dot Style</label>
                        <select id="corner_dot_style" name="corner_dot_style" class="form-control">
                            <option value="square" {{ old('corner_dot_style', $qrStyle?->corner_dot_style) == 'square' ? 'selected' : '' }}>Square</option>
                            <option value="dot" {{ old('corner_dot_style', $qrStyle?->corner_dot_style) == 'dot' ? 'selected' : '' }}>Dot</option>
                        </select>
                        @error('corner_dot_style') <div style="color: var(--danger); font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Background & Gradient -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="background_color">Background Color</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" id="background_color_picker" class="form-control" style="width: 48px; padding: 4px; cursor: pointer;" value="{{ old('background_color', $qrStyle?->background_color ?? '#ffffff') }}">
                            <input type="text" id="background_color" name="background_color" class="form-control" style="flex: 1;" value="{{ old('background_color', $qrStyle?->background_color ?? '#ffffff') }}">
                        </div>
                        @error('background_color') <div style="color: var(--danger); font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-group" style="margin: 0; display: flex; align-items: center; gap: 8px; margin-top: 32px;">
                        <input type="hidden" name="gradient_enabled" value="0">
                        <input type="checkbox" id="gradient_enabled" name="gradient_enabled" value="1" {{ old('gradient_enabled', $qrStyle?->gradient_enabled) ? 'checked' : '' }}>
                        <label for="gradient_enabled" style="margin: 0; cursor: pointer;">Enable Gradient Foreground</label>
                    </div>
                </div>

                <!-- Gradient Options -->
                <div id="gradient_options" style="display: none; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 24px; padding: 16px; background: rgba(0,0,0,0.02); border-radius: 8px;">
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="gradient_color_1">Gradient Color 1</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" id="gradient_color_1_picker" class="form-control" style="width: 48px; padding: 4px; cursor: pointer;" value="{{ old('gradient_color_1', $qrStyle?->gradient_color_1 ?? '#000000') }}">
                            <input type="text" id="gradient_color_1" name="gradient_color_1" class="form-control" style="flex: 1;" value="{{ old('gradient_color_1', $qrStyle?->gradient_color_1 ?? '#000000') }}">
                        </div>
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="gradient_color_2">Gradient Color 2</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="color" id="gradient_color_2_picker" class="form-control" style="width: 48px; padding: 4px; cursor: pointer;" value="{{ old('gradient_color_2', $qrStyle?->gradient_color_2 ?? '#000000') }}">
                            <input type="text" id="gradient_color_2" name="gradient_color_2" class="form-control" style="flex: 1;" value="{{ old('gradient_color_2', $qrStyle?->gradient_color_2 ?? '#000000') }}">
                        </div>
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label" for="gradient_type">Gradient Type</label>
                        <select id="gradient_type" name="gradient_type" class="form-control">
                            <option value="linear" {{ old('gradient_type', $qrStyle?->gradient_type) == 'linear' ? 'selected' : '' }}>Linear</option>
                            <option value="radial" {{ old('gradient_type', $qrStyle?->gradient_type) == 'radial' ? 'selected' : '' }}>Radial</option>
                        </select>
                    </div>
                </div>

                <!-- Center Logo -->
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" for="logo">Center Logo (Optional)</label>
                    <p style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 0; margin-bottom: 8px;">For best scan reliability, use a square logo with a solid background.</p>
                    
                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        @if($qrStyle && $qrStyle->logo_url)
                            <div id="current_logo_container" style="text-align: center;">
                                <img src="{{ $qrStyle->logo_url }}" alt="Current Logo" style="width: 64px; height: 64px; object-fit: contain; border: 1px solid var(--border); border-radius: 8px; background: white;">
                                <div style="margin-top: 8px;">
                                    <input type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                    <label for="remove_logo" style="font-size: 0.8rem; color: var(--danger); cursor: pointer;">Remove</label>
                                </div>
                            </div>
                        @endif
                        
                        <div style="flex: 1;">
                            <input type="file" id="logo" name="logo" class="form-control" accept="image/png, image/jpeg, image/webp" onchange="validateLogoSize(this)">
                            <div id="logo_error" style="color: var(--danger); font-size: 0.875rem; margin-top: 4px; display: none;"></div>
                            @error('logo') <div style="color: var(--danger); font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div style="margin-top: 32px; border-top: 1px solid var(--border); padding-top: 24px;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; height: 48px; font-size: 1rem;">Save QR Settings</button>
                </div>
            </form>
        </div>

        <!-- Right Column: Sticky Live Preview -->
        <div style="position: sticky; top: 32px;">
            <div class="card" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                <h3 style="margin-top: 0; margin-bottom: 8px;">Live Preview</h3>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 24px;">Scan to test your menu link</p>
                
                <div id="qr-canvas" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid var(--border); margin-bottom: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); min-width: 250px; min-height: 250px; display: flex; align-items: center; justify-content: center;">
                    <!-- QR code will be rendered here -->
                    <div id="qr-loading" style="color: var(--text-secondary);">Loading Preview...</div>
                </div>
                
                <div style="width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <button type="button" id="btn-download-png" class="btn btn-secondary" style="font-size: 0.875rem; height: 40px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                        <i data-lucide="download" style="width: 16px;"></i> PNG
                    </button>
                    <button type="button" id="btn-download-svg" class="btn btn-secondary" style="font-size: 0.875rem; height: 40px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                        <i data-lucide="download" style="width: 16px;"></i> SVG
                    </button>
                </div>
            </div>
            <div style="margin-top: 16px; font-size: 0.8rem; color: var(--text-secondary); text-align: center; word-break: break-all;">
                Target URL: <br>
                <a href="{{ env('FRONTEND_URL', 'http://localhost:5174') }}/menu/{{ $restaurant->slug }}" target="_blank" style="color: var(--primary);">
                    {{ env('FRONTEND_URL', 'http://localhost:5174') }}/menu/{{ $restaurant->slug }}
                </a>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 900px) {
            .qr-layout {
                grid-template-columns: 1fr !important;
            }
            .qr-layout > div:last-child {
                position: static !important;
            }
        }
    </style>

    <!-- Load qr-code-styling library -->
    <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof QRCodeStyling !== 'function') {
                document.getElementById('qr-loading').innerText = 'Failed to load QR generator. Please check your internet connection.';
                return;
            }
            
            const targetUrl = "{{ env('FRONTEND_URL', 'http://localhost:5174') }}/menu/{{ $restaurant->slug }}";
            let currentLogoUrl = "{{ $qrStyle?->logo_url ?? '' }}";
            
            // Initialize QR Code
            const qrCode = new QRCodeStyling({
                width: 300,
                height: 300,
                data: targetUrl,
                margin: 0,
                image: currentLogoUrl || null,
                dotsOptions: {
                    type: document.getElementById('dot_style').value,
                    color: document.getElementById('dot_color').value
                },
                backgroundOptions: {
                    color: document.getElementById('background_color').value
                },
                cornersSquareOptions: {
                    type: document.getElementById('corner_square_style').value,
                    color: document.getElementById('dot_color').value
                },
                cornersDotOptions: {
                    type: document.getElementById('corner_dot_style').value,
                    color: document.getElementById('dot_color').value
                },
                imageOptions: {
                    crossOrigin: "anonymous",
                    margin: 10,
                    imageSize: 0.4
                }
            });

            // Initial render
            document.getElementById('qr-loading').style.display = 'none';
            qrCode.append(document.getElementById("qr-canvas"));
            
            // Gradient visibility logic
            const gradientCheckbox = document.getElementById('gradient_enabled');
            const gradientOptions = document.getElementById('gradient_options');
            
            function toggleGradient() {
                gradientOptions.style.display = gradientCheckbox.checked ? 'grid' : 'none';
            }
            
            gradientCheckbox.addEventListener('change', () => {
                toggleGradient();
                updateQRCode();
            });
            toggleGradient();

            // Link color inputs with text inputs
            function linkColorInputs(pickerId, textId) {
                const picker = document.getElementById(pickerId);
                const text = document.getElementById(textId);
                
                picker.addEventListener('input', () => {
                    text.value = picker.value;
                    updateQRCode();
                });
                
                text.addEventListener('input', () => {
                    if (/^#[0-9A-Fa-f]{6}$/.test(text.value) || /^#[0-9A-Fa-f]{3}$/.test(text.value)) {
                        picker.value = text.value;
                        updateQRCode();
                    }
                });
            }

            linkColorInputs('dot_color_picker', 'dot_color');
            linkColorInputs('background_color_picker', 'background_color');
            linkColorInputs('gradient_color_1_picker', 'gradient_color_1');
            linkColorInputs('gradient_color_2_picker', 'gradient_color_2');

            // Attach listeners to all selects
            document.querySelectorAll('select').forEach(el => {
                el.addEventListener('change', updateQRCode);
            });

            // Logo Upload Preview
            const logoInput = document.getElementById('logo');
            const removeLogoCheck = document.getElementById('remove_logo');
            
            if (removeLogoCheck) {
                removeLogoCheck.addEventListener('change', () => {
                    if (removeLogoCheck.checked) {
                        currentLogoUrl = '';
                        logoInput.value = '';
                        updateQRCode();
                    } else {
                        currentLogoUrl = "{{ $qrStyle?->logo_url ?? '' }}";
                        updateQRCode();
                    }
                });
            }

            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    const err = document.getElementById('logo_error');
                    err.innerText = 'Logo file size exceeds 2MB.';
                    err.style.display = 'block';
                    logoInput.value = '';
                    return;
                } else {
                    document.getElementById('logo_error').style.display = 'none';
                }

                if (removeLogoCheck) removeLogoCheck.checked = false;

                const reader = new FileReader();
                reader.onload = function(e) {
                    currentLogoUrl = e.target.result;
                    updateQRCode();
                };
                reader.readAsDataURL(file);
            });

            // Master update function
            function updateQRCode() {
                const isGradient = gradientCheckbox.checked;
                const dotColor = document.getElementById('dot_color').value;
                const gradColor1 = document.getElementById('gradient_color_1').value;
                const gradColor2 = document.getElementById('gradient_color_2').value;
                const gradType = document.getElementById('gradient_type').value;

                let dotsConfig = {
                    type: document.getElementById('dot_style').value,
                };

                if (isGradient) {
                    dotsConfig.gradient = {
                        type: gradType,
                        colorStops: [
                            { offset: 0, color: gradColor1 },
                            { offset: 1, color: gradColor2 }
                        ]
                    };
                } else {
                    dotsConfig.color = dotColor;
                }

                qrCode.update({
                    image: currentLogoUrl || null,
                    dotsOptions: dotsConfig,
                    backgroundOptions: {
                        color: document.getElementById('background_color').value
                    },
                    cornersSquareOptions: {
                        type: document.getElementById('corner_square_style').value,
                        color: dotColor
                    },
                    cornersDotOptions: {
                        type: document.getElementById('corner_dot_style').value,
                        color: dotColor
                    }
                });
            }

            // Downloads
            document.getElementById('btn-download-png').addEventListener('click', () => {
                qrCode.download({ name: "{{ $restaurant->slug }}-qr", extension: "png" });
            });
            document.getElementById('btn-download-svg').addEventListener('click', () => {
                qrCode.download({ name: "{{ $restaurant->slug }}-qr", extension: "svg" });
            });
        });
        
        window.validateLogoSize = function(input) {
            // Already handled in event listener above.
        };
    </script>
@endsection
