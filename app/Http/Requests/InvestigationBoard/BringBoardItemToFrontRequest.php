<?php

namespace App\Http\Requests\InvestigationBoard;

use Illuminate\Foundation\Http\FormRequest;

class BringBoardItemToFrontRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}