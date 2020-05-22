<?php

namespace Laraditz\Xenopay\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService
{
    public function hello()
    {
        echo 'hello';
    }

    public function login(array $payload)
    {
        $this->validate($payload, [
            'email' => 'required|max:255',
            'password' => 'required',
        ]);

        return $this->action(__FUNCTION__)
            ->withPayload($payload)
            ->post();


        /* if ($validator->fails()) {
            // dd($validator->errors());
            // throw (new ValidationException($validator));
            // throw new \ErrorException('Invalid data.');
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json($validator->errors(), 422));
        } */
    }
}
