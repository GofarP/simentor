<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowupInstructionScoreRequest extends FormRequest
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
            'followup_instruction_id'=>'required',
            'score'=>'required',
            'comment'=>'required'
        ];
    }

    public function messages()
    {
        return[
             'followup_instruction_id.required'=>'Silahkan pilih tindak lanjut instruksi',
             'score.required'=>'Silahkan Masukkan Nilai',
             'comment.required'=>'Comment Dibutuhkan',
        ];
    }
}
