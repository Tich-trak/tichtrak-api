<?php

namespace App\Http\Requests;

use App\Enums\InstitutionTypeEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class InstitutionFormRequest extends FormRequest {
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
                        'name' => 'bail|required|string|max:200|min:3|unique:institutions,name',
                        'alias' => 'bail|sometimes|string|max:200|min:2|unique:institutions,alias',
                        'email' => 'required|string|email:rfc,dns|max:150|unique:institutions,email',
                        'po_box' => 'bail|required|integer|max_digits:6',
                        'type' => ['bail', 'required', 'alpha', new Enum(InstitutionTypeEnum::class, false)],
                        'address' => 'bail|required|string',
                        'city' => 'bail|required|string',
                        'state_id' => 'bail|required|exists:states,id',
                        'country_id' => 'bail|required|exists:countries,id',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name' => 'bail|sometimes|string|max:200|min:3|unique:institutions,name',
                        'alias' => 'bail|sometimes|string|max:200|min:3|unique:institutions,alias',
                        'email' => 'sometimes|string|email:rfc,dns|max:150|unique:institutions,email',
                        'po_box' => 'bail|sometimes|integer|max:6',
                        'type' => ['bail', 'sometimes', 'alpha', new Enum(InstitutionTypeEnum::class, false)],
                        'address' => 'bail|sometimes|string',
                        'city' => 'bail|sometimes|string',
                        'state_id' => 'bail|sometimes|exists:states,id',
                        'country_id' => 'bail|sometimes|exists:countries,id',
                        'logo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                    ];
                }
            default:
                break;
        }
    }
}