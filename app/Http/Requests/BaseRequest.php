<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    protected $isFirstMessage = false;

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        $errors = $validator->errors()->toArray();
        if ($this->isFirstMessage) {
            $errors = array_values($errors)[0][0] ?? array_values($errors)[0];
        }
        throw new HttpResponseException(
            response()->json(
                [
                    'message' => $errors,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }

    public function paginateRules(): array
    {
        return [
            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
    }
}
