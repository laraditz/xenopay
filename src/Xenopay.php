<?php

namespace Laraditz\Xenopay;

use Illuminate\Support\Str;

class Xenopay
{
    /**
     * Magic method that return services class.
     *
     * @param  string  $method
     * @param  string  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $class_name = Str::studly($method) . 'Service';

        $fully_qualified_name = preg_replace_array('/:[a-z_]+/', [$class_name], 'Laraditz\\Xenopay\\Services\\:class');

        if (class_exists($fully_qualified_name)) {
            return new $fully_qualified_name();
        }
    }
}

class XenopayResponse
{
    use \Illuminate\Support\Traits\Macroable {
        __call as macroCall;
    }

    public function __construct($response)
    {
        $this->http = $response;
        // $this->body = @$response->body() ?? null;
    }

    public function isSuccess(): bool
    {
        if ($this->http->successful()) {
            return $this->http->json()['success'] ?? false;
        }

        return $this->http->successful();
    }

    public function status(): int
    {
        if (@$this->http->json()['data']['status']) {
            return $this->http->json()['data']['status'];
        }

        return $this->http->status();
    }

    public function data()
    {
        return $this->http->json()['data']['content'] ?? null;
    }

    public function errors(): ?array
    {
        $errors = null;

        if (@$this->http->json()['errors']) {
            return $this->http->json()['errors'];
        }

        return $errors;
    }

    public function message(): ?string
    {
        if (@$this->http->json()['data']['message']) {
            return $this->http->json()['data']['message'];
        }

        if ($this->isSuccess()) {
            return 'Success.';
        } else {
            return 'Failed';
        }

        return null;
    }

    public function __call($method, $args)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $args);
        }

        return $this->response->{$method}(...$args);
    }
}
