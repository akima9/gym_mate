<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoardRequest extends FormRequest
{
    protected $redirectRoute = 'boards.create';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'trainingDate' => ['required', 'date'],
            'trainingStartTime' => ['required', 'date_format:H:i'],
            'trainingEndTime' => ['required', 'date_format:H:i', 'after:trainingStartTime'],
            'trainingParts' => ['required'],
        ];
    }
}
