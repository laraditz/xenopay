<?php

namespace Laraditz\Xenopay\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laraditz\Xenopay\XenopayResponse;

class BaseService
{
    /**
     * Base url for api.
     */
    private $base_url;

    /**
     * Define finalize URL and METHOD Request.
     */
    private $url;

    private $method = 'get';

    private $headers = [];

    private $payload = [];

    private $service;

    private $action;

    protected $validator;

    /**
     *  Class Cosntructor.
     */
    public function __construct()
    {
        $this->setBaseUrl(config('xenopay.url'));

        $service_name = strtolower(Str::snake(Str::singular(str_replace('Service', '', (new \ReflectionClass($this))->getShortName()))));
        $this->setService($service_name);

        $this->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json']);
    }

    public function validate($payload, $rules)
    {
        $this->validator = Validator::make($payload, $rules);
    }

    /**
     * Executer for API Call.
     * @return mixed
     */
    protected function execute()
    {
        if ($this->getUrl() === null) {
            $url = $this->getBaseUrl() . config('xenopay.routes.' . $this->getService() . '.' . Str::snake($this->getAction()));
            $this->setUrl($url);
        }

        if ($this->validator && $this->validator->fails()) {
            return new XenopayResponse(Http::fake(function ($request) {
                return Http::response(['status' => false, 'data' => ['message' => 'Invalid data.'], 'errors' => $this->validator->errors()->getMessages()], 422);
            })->get($this->getUrl()));
        }

        try {
            $response = Http::withHeaders($this->getHeaders())->{$this->getMethod()}($this->getUrl(), $this->getPayload());

            return new XenopayResponse($response);
        } catch (Exception $e) {
            return new XenopayResponse(Http::fake(function ($request) use ($e) {
                return Http::response(['status' => false, 'data' => ['message' => $e->getMessage()]], 502);
            })->get($this->getUrl()));
        }
    }

    protected function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
    }

    protected function getBaseUrl()
    {
        return $this->base_url;
    }

    protected function setUrl($url)
    {
        $this->url = $url;
    }

    protected function getUrl()
    {
        return $this->url;
    }

    protected function service($service)
    {
        $this->setService($service);

        return $this;
    }

    protected function setService($service)
    {
        $this->service = $service;
    }

    protected function getService()
    {
        return $this->service;
    }

    protected function action($action)
    {
        $this->setAction($action);

        return $this;
    }

    protected function setAction($action)
    {
        $this->action = $action;
    }

    protected function getAction()
    {
        return $this->action;
    }

    protected function method($method)
    {
        $this->setMethod($method);

        return $this;
    }

    protected function setMethod($method)
    {
        if ($method) {
            $this->method = strtolower($method);
        }
    }

    protected function getMethod()
    {
        return $this->method;
    }

    public function payload($payload)
    {
        $this->setPayload($payload);

        return $this;
    }

    public function withPayload(array $payload)
    {
        return self::tap($this, function ($request) use ($payload) {
            return $this->payload = array_merge_recursive($this->payload, $payload);
        });
    }

    protected function setPayload($payload)
    {
        $this->payload = $payload;
    }

    protected function getPayload()
    {
        return $this->payload;
    }

    public function withHeaders(array $headers)
    {
        return self::tap($this, function ($request) use ($headers) {
            return $this->headers = array_merge_recursive($this->headers, $headers);
        });
    }

    protected function getHeaders()
    {
        return $this->headers;
    }

    protected function tap($value, $callback)
    {
        $callback($value);

        return $value;
    }

    protected function get()
    {
        return $this->execute();
    }

    protected function post()
    {
        $this->setMethod('post');

        return $this->execute();
    }
}
