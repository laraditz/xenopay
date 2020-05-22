<?php

namespace Laraditz\Xenopay\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService
{
    public function login(array $payload)
    {
        $this->validate($payload, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $this->action(__FUNCTION__)
            ->withPayload($payload)
            ->post();
    }
}
