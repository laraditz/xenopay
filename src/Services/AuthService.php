<?php

namespace Laraditz\Xenopay\Services;

class AuthService extends BaseService
{
    public function login(array $payload = [])
    {
        // if payload not passed, check from config
        if (!$payload) {
            $config_email = config('xenopay.email');
            $config_password = config('xenopay.password');

            if ($config_email && $config_password) {
                $payload = [
                    'email' => $config_email,
                    'password' => $config_password,
                ];
            }
        }

        $this->validate($payload, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $this->action(__FUNCTION__)
            ->withPayload($payload)
            ->post();
    }
}
