<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CriteriaValuesRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'criteria_id' => 'required|exists:criteria,id',
    //         'weight' => 'required|numeric|min:0|max:1',
    //     ];
    // }
    // public function messages(): array
    // {
    //     return [
    //         'criteria_id.required' => 'Criteria id is required',
    //         'criteria_id.exists' => 'Criteria id not found',
    //         'weight.required' => 'Weight is required',
    //         'weight.numeric' => 'Weight must be numeric',
    //         'weight.min' => 'Weight must be greater than or equal to 0',
    //         'weight.max' => 'Weight must be less than or equal to 1',
    //     ];
    // }
    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'code' => 422,
    //         'message' => 'Check your validation',
    //         'errors' => $validator->errors()
    //     ], 422));
    // }
}
