<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplicantRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'code' => 'required|numeric',
            'position_id' => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'nama kandidat wajib diisi',

            'code.required' => 'kode kandidat wajib diisi',
            'code.numeric' => 'kode harus berupa angka',

            'position_id.required' => 'posisi anggota harus diisi',


        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => 422,
            'message' => 'Check your validation',
            'errors' => $validator->errors()
        ], 422));
    }
}
