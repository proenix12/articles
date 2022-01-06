<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'article_body' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif',
            'tag_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'title field is required',
            'article_body.required' => 'article_body field is required',
            'file.unique' => 'file field is required',
            'tag_name.required' => 'tag_name field is required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
