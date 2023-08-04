<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentFormRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return false;
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
                        'faculty_id' => 'bail|required|exists:faculties,id',
                        'name' => ['required', 'string', Rule::unique('departments')->where('faculty_id', $this->faculty_id)],
                        'goal' => 'bail|sometimes|string|max:300|min:3|',
                        'description' => 'bail|sometimes|string|max:300|min:3|',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'faculty_id' => 'bail|sometimes|exists:faculties,id',
                        'name' => 'bail|sometimes|string|max:200|min:3|unique:departments,name',
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
