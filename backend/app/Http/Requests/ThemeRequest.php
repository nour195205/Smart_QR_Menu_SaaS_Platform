<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'primary_color'    => ['required', 'string', 'max:20', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color'  => ['required', 'string', 'max:20', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'background_color' => ['required', 'string', 'max:20', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text_color'       => ['required', 'string', 'max:20', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'font_family'      => ['required', 'string', 'max:100'],
            'card_style'       => ['required', 'in:rounded,flat,shadow'],
            'dark_mode'        => ['boolean'],
            'layout_style'     => ['required', 'in:grid,list'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('dark_mode')) {
            $this->merge([
                'dark_mode' => filter_var($this->dark_mode, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
