<?php

namespace App\Http\Requests\InvestigationBoard;

use Illuminate\Foundation\Http\FormRequest;

class ResizeBoardItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'width' => [
                'nullable',
                'numeric',
                'min:120',
                'max:4000',
                'required_without:height',
            ],
            'height' => [
                'nullable',
                'numeric',
                'min:120',
                'max:4000',
                'required_without:width',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'width.numeric' => 'The width must be a valid number.',
            'width.min' => 'The width must be at least 120.',
            'width.max' => 'The width may not be greater than 4000.',
            'width.required_without' => 'A width or height value is required.',
            'height.numeric' => 'The height must be a valid number.',
            'height.min' => 'The height must be at least 120.',
            'height.max' => 'The height may not be greater than 4000.',
            'height.required_without' => 'A width or height value is required.',
        ];
    }
}