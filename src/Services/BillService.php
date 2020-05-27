<?php

namespace Laraditz\Xenopay\Services;

use Illuminate\Validation\ValidationException;

class BillService extends BaseService
{
    public function create(array $payload)
    {
        $this->validate($payload, [
            'ref_no' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'required|string|min:5',
            'contact' => 'required|string',
            'redirect_url' => 'required|url',
            'remark' => 'nullable|string',
        ]);
        $payload = ['Bill' => $payload];

        return $this->action(__FUNCTION__)
            ->withPayload($payload)
            ->post();
    }

    public function view($id)
    {
        return $this->action(__FUNCTION__)
            ->placeholder(['id' => $id])
            ->get();
    }
}
