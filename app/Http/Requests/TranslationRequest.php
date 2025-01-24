<?php

namespace App\Http\Requests;

use App\Enums\TagEnum;
use App\Rules\UniqueLangKey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TranslationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $isStoreMethod = ($this->isMethod('put') || $this->isMethod('patch')) ? false : true;
        
        return [
            'lang'    => 'required|string|max:3',
            'key'     => [
                            'required',
                            'string',
                            'max:255',
                            $isStoreMethod ? new UniqueLangKey : new UniqueLangKey($this->route('translation'))
                        ],

            'value'   => 'required|string|max:255',
            'tags'    => 'required|array',
            'tags.*'  => ['required',new Enum(TagEnum::class),'string','max:50'],
        ];
    }

    /**
     * Customize the error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'lang.required'    => 'The language field is required.',
            'lang.string'      => 'The language field must be a string.',
            'lang.max'         => 'The language field must not exceed 3 characters.',
    
            'key.required'     => 'The key field is required.',
            'key.string'       => 'The key field must be a string.',
            'key.max'          => 'The key field must not exceed 255 characters.',
    
            'value.required'   => 'The value field is required.',
            'value.string'     => 'The value field must be a string.',
            'value.max'        => 'The value field must not exceed 255 characters.',
    
            'tags.required'    => 'The tags field is required.',
            'tags.array'       => 'The tags field must be an array.',
            'tags.*.required'  => 'Each tag is required.',
            'tags.*.string'    => 'Each tag must be a string.',
            'tags.*.max'       => 'Each tag must not exceed 50 characters.',
            'tags.*.enum'      => 'Each tag must be a valid value in the tag enum.',
        ];
    }
}
