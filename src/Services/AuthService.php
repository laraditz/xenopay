<?php

namespace Laraditz\Xenopay\Services;

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
