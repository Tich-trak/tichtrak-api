<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PollFormRequest extends FormRequest {
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
                    return [];
                }
            case 'PUT':
            case 'PATCH': {
                    return [];
                }
            default:
                break;
        }
    }
}
