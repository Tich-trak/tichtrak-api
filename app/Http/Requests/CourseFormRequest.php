<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseFormRequest extends FormRequest {
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
                        'level_id' => 'bail|required|exists:levels,id',
                        'name' => 'bail|required|string|max:300|min:3|',
                        'alias' => 'bail|required|string|max:3|min:3|',
                        'code' => 'bail|required|integer|min_digits:3|max_digits:3',
                        'description' => 'bail|sometimes|string|max:300|min:3|',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'bail|sometimes|string|max:300|min:3|',
                        'code' => 'bail|sometimes|integer|min_digits:100|max_digits:999',
                        'description' => 'bail|sometimes|string|max:300|min:3|',
                    ];
                }
            default:
                break;
        }
    }
}
