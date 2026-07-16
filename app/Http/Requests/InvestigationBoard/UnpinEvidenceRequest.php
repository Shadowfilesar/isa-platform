<?php

namespace App\Http\Requests\InvestigationBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnpinEvidenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        return array_merge($this->all(), [
            'case_file_id' => $this->route('file')?->id ?? $this->route('file'),
            'case_id' => $this->route('case')?->id ?? $this->route('case'),
        ]);
    }

    public function rules(): array
    {
        return [
            'case_file_id' => [
                'required',
                'integer',
                Rule::exists('case_files', 'id')->where(function ($query) {
                    $query->where('case_id', $this->input('case_id'));
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'case_file_id.required' => 'A valid case file is required.',
            'case_file_id.integer' => 'The selected case file is invalid.',
            'case_file_id.exists' => 'The selected case file does not belong to this investigation.',
        ];
    }
}