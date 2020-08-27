<?php

namespace Laraditz\Xenopay\Services;

use Laraditz\Xenopay\Exceptions\GeneralHttpException;
use Laraditz\Xenopay\Models\XenopayPayment;

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
        $full_payload = ['Bill' => $payload];

        $response = $this->action(__FUNCTION__)
            ->withPayload($full_payload)
            ->post();

        if (!$response->isSuccess()) {
            return $response;
        }

        if (!$response->data()) {
            return $response;
        }

        $response_data = $response->data();

        try {
            $payment = XenopayPayment::updateOrCreate(
                [
                    'tx_id' => $response_data['id'],
                ],
                [
                    'ref_no' => $payload['ref_no'],
                    'currency_code' => $response_data['currency_code'],
                    'amount' => $payload['amount'],
                    'description' => $payload['description'],
                    'username' => $response_data['username'],
                    'email' => $response_data['email'],
                    'contact' => $payload['contact'],
                    'remark' => $payload['remark'] ?? null,
                    'redirect_url' => $response_data['url'],
                ]
            );
        } catch (\Exception $e) {
            throw new GeneralHttpException($e->getMessage());
        }

        if (!$payment) {
            throw new GeneralHttpException('Error saving payment request.');
        }

        return $response;
    }

    public function view($id)
    {
        return $this->action(__FUNCTION__)
            ->placeholder(['id' => $id])
            ->get();
    }
}
