<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest {
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
                        'name' => [Rule::requiredIf(!auth()->user()), 'bail', 'string', 'max:100', 'min:3'],
                        'email' => [Rule::requiredIf(!auth()->user()), 'bail', 'email:rfc', 'max:150', 'string', 'unique:users,email'],
                        'password' => [Rule::requiredIf(!auth()->user()), 'max:127', Password::min(8)->letters()->mixedCase()->numbers()],
                        'phone_number' => 'required|string|max:15',
                        'institution_id' => 'required|exists:institutions,id',
                        'address' => [Rule::requiredIf(!auth()->user()), 'bail', 'min:3', 'max:255', 'string'],
                        'city' => [Rule::requiredIf(!auth()->user()), 'bail', 'min:3', 'max:50', 'string'],
                        'state_id' => [Rule::requiredIf(!auth()->user()), 'bail', 'exists:states,id'],
                        'country_id' => [Rule::requiredIf(!auth()->user()), 'bail', 'exists:countries,id'],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'sometimes|string|max:40|min:5',
                        'address' => 'bail|sometimes|string|max:255|min:3',
                        'phone_number' => 'sometimes|string|min:11|max:15',
                        'address' => 'bail|sometimes|string|max:255|min:3',
                        'city' => 'bail|sometimes|string|max:255|min:3',
                        'state_id' => 'bail|sometimes|exists:states,id',
                        'country_id' => 'bail|sometimes|exists:countries,id',
                        'password' => ['required_without:role', 'nullable', 'max:127', Password::min(8)->letters()->mixedCase()->numbers()],
                    ];
                }
            default:
                break;
        }
    }
}
