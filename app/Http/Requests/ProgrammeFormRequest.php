<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgrammeFormRequest extends FormRequest {
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
                        'department_id' => 'bail|required|exists:departments,id',
                        'name' => ['required', 'string', Rule::unique('programmes')->where('department_id', $this->faculty_id)],
                        'goal' => 'bail|sometimes|string|max:300|min:3|',
                        'description' => 'bail|sometimes|string|max:300|min:3|',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'department_id' => 'bail|sometimes|exists:departments,id',
                        'name' => ['sometimes', 'string', Rule::unique('programmes')->where('department_id', $this->faculty_id)],
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
