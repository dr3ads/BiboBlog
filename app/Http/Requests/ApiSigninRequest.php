<?php

namespace BiboBlog\Http\Requests;

use BiboBlog\Http\Requests\Request;

class ApiSigninRequest extends Request
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
            'username' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        $errors = array_merge(['code' => 422, 'data' => $errors]);

        return response()->json($errors);
    }
}
