<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
                        'name' => 'bail|required|string|max:100|min:3',
                        'email' => 'required|string|email:rfc,dns|max:150|unique:users,email',
                        'address' => 'bail|sometimes|string|max:255|min:3',
                        'password' => ['required_without:role', 'nullable', 'max:127', Password::min(8)->letters()->mixedCase()->numbers()],
                        'phone_number' => 'sometimes|string|min:11|max:15',
                        'userType' => 'required_without:role|integer|in:1,2',
                        'role' => [
                            Rule::requiredIf(auth()->user() && auth()->user()->hasRole(RoleEnum::SuperAdmin), new Enum(RoleEnum::class, false)),
                        ],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'uuid' => 'required|exists:users,uuid',
                        'name' => 'sometimes|string|max:40|min:5',
                        'address' => 'bail|sometimes|string|max:255|min:3',
                        'city' => 'bail|sometimes|string|max:255|min:3',
                        'state_id' => 'bail|sometimes|exists:states,id',
                        'country_id' => 'bail|sometimes|exists:countries,id',
                        'phone_number' => 'sometimes|string|min:11|max:15'
                    ];
                }
            default:
                break;
        }
    }
}
