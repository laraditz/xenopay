<?php

namespace Laraditz\Xenopay\Models;

use Illuminate\Database\Eloquent\Model;

class XenopayPayment extends Model
{
    protected $fillable = [
        'tx_id', 'ref_no', 'currency_code', 'amount', 'description', 'payment_id', 'username', 'email', 'contact', 'remark', 'status', 'status_description', 'redirect_url'
    ];
}
