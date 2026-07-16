<?php

namespace App\Http\Requests\InvestigationBoard;

use Illuminate\Foundation\Http\FormRequest;

class MoveBoardItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position_x' => [
                'required',
                'numeric',
                'min:0',
                'max:10000',
            ],
            'position_y' => [
                'required',
                'numeric',
                'min:0',
                'max:10000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'position_x.required' => 'The X position is required.',
            'position_x.numeric' => 'The X position must be a valid number.',
            'position_x.min' => 'The X position must be at least 0.',
            'position_x.max' => 'The X position may not be greater than 10000.',
            'position_y.required' => 'The Y position is required.',
            'position_y.numeric' => 'The Y position must be a valid number.',
            'position_y.min' => 'The Y position must be at least 0.',
            'position_y.max' => 'The Y position may not be greater than 10000.',
        ];
    }
}