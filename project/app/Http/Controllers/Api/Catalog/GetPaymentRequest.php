<?php


namespace App\Http\Controllers\Api\Catalog;
use App\Http\Controllers\Request;


class GetPaymentRequest extends Request
{

    public function getTransactionId() : string
    {
        return $this->get('transaction_id');
    }

    public function getItemId(): int
    {
        return $this->get('item_id');
    }


    public function getSiteId() : string
    {
        return $this->get('site_id');
    }

    public function getAmount() : float
    {
        return $this->get('amount');
    }

    public function getParametersPayment() : array
    {
        return $this->get('parameters');

    }

    public function getSignature(): string
    {
        return $this->get('signature');
    }




}
