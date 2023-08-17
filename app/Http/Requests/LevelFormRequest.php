<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LevelFormRequest extends FormRequest {
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
                        'name' => ['required', 'string', Rule::unique('levels')->where('institution_id', $this->institution_id)],
                        'code' => ['sometimes', 'integer', Rule::unique('levels')->where('institution_id', $this->institution_id)],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'bail|sometimes|string|max:300|min:3|',
                        'code' => 'bail|sometimes|integer',
                    ];
                }
            default:
                break;
        }
    }
}
