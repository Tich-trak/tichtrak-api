<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class NotificationFormRequest extends FormRequest {
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
                        'title' => ['required', 'string', Rule::unique('notifications')->where('institution_id', $this->institution_id)],
                        'summary' => 'bail|sometimes|string|max:200|min:3|',
                        'body' => 'bail|required|string|max:1000|min:3|',
                        'external_link' => 'bail|sometimes|url',
                        //TODO this should be file upload
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title' => 'bail|sometimes|string|max:200|min:3|unique:notifications,title',
                        'summary' => 'bail|sometimes|string|max:200|min:3|',
                        'body' => 'bail|sometimes|string|max:1000|min:3|',
                        'external_link' => 'bail|sometimes|url',
                    ];
                }
            default:
                break;
        }
    }
}
