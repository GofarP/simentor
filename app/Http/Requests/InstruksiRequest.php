<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstruksiRequest extends FormRequest
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
        $id = $this->route('instruksi');

        return [
            'penerima_id' => 'required',
            'judul' => 'required|string',
            'deskripsi' => 'required',
            'waktu_mulai' => 'required',
            'batas_waktu' => 'required',
            'lampiran'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',

        ];
    }

    public function messges(): array
    {
        return [
            'penerima_id.required' => 'Silahkan pilih penerima',
            'judul.required' => 'Silahkan pilih judul',
            'deskripsi.required' => 'Silahkan masukkan deskripsi',
            'waktu_mulai.required' => 'Silahkan masukkan waktu mulai',
            'batas_waktu.required' => 'Silahkan masukkan batas waktu',
            'lampiran.file'   => 'Lampiran harus berupa file.',
            'lampiran.mimes'  => 'Lampiran hanya boleh berupa file PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, atau JPEG.',
            'lampiran.max'    => 'Ukuran lampiran maksimal 2 MB.',
        ];
    }
}
