<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdfMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pdf_file' => ['required', 'file', 'mimes:pdf', 'max:10240'], // 10MB max
        ];
    }
}
