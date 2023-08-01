<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacultyFormRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'institution_id' => 'bail|required|exists:institutions,id',
                        'name' => ['required', 'string', Rule::unique('faculties')->where('institution_id', $this->institution_id)],
                        'goal' => 'bail|sometimes|string|max:300|min:3|',
                        'description' => 'bail|sometimes|string|max:300|min:3|',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'institution_id' => 'sometimes|exists:institutions,id',
                        'name' => 'bail|sometimes|string|max:200|min:3|unique:institutions,name',
                        'goal' => 'bail|sometimes|string|max:300|min:3|',
                        'description' => 'bail|sometimes|string|max:300|min:3|',
                        'is_active' => 'bail|sometimes|boolean'
                    ];
                }
            default:
                break;
        }
    }
}
