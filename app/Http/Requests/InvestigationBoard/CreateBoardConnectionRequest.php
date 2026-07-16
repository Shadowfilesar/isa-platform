<?php

namespace App\Http\Requests\InvestigationBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBoardConnectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'board_id' => $this->route('case')?->board?->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'source_board_item_id' => [
                'required',
                'integer',
                Rule::exists('investigation_board_items', 'id')->where(function ($query) {
                    $query->where('investigation_board_id', $this->input('board_id'));
                }),
            ],
            'target_board_item_id' => [
                'required',
                'integer',
                'different:source_board_item_id',
                Rule::exists('investigation_board_items', 'id')->where(function ($query) {
                    $query->where('investigation_board_id', $this->input('board_id'));
                }),
            ],
            'reason' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'confidence_level' => [
                'required',
                'string',
                Rule::in(['LOW', 'MEDIUM', 'HIGH', 'low', 'medium', 'high']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'source_board_item_id.required' => 'A source board item is required.',
            'source_board_item_id.integer' => 'The selected source board item is invalid.',
            'source_board_item_id.exists' => 'The selected source board item does not belong to this board.',
            'target_board_item_id.required' => 'A target board item is required.',
            'target_board_item_id.integer' => 'The selected target board item is invalid.',
            'target_board_item_id.different' => 'The source and target board items must be different.',
            'target_board_item_id.exists' => 'The selected target board item does not belong to this board.',
            'reason.string' => 'The connection reason must be valid text.',
            'reason.max' => 'The connection reason may not be greater than 1000 characters.',
            'confidence_level.required' => 'A confidence level is required.',
            'confidence_level.string' => 'The confidence level is invalid.',
            'confidence_level.in' => 'The confidence level must be LOW, MEDIUM, or HIGH.',
        ];
    }
}