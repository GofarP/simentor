<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructionScoreRequest extends FormRequest
{
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
            'instruction_id' => 'required',
            'score' => 'required',
            'comment' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'instruction_id.required' => 'Silahkan pilih instruksi',
            'score.required' => 'Silahkan Masukkan Nilai',
            'comment.required' => 'Comment Dibutuhkan',
        ];
    }
}
