<?php

namespace App\Library;

class IyzicoThreeDResponse {

    public $status;
    public $paymentId;
    public $conversationData;
    public $conversationId;
    public $mdStatus;

    public function __construct($result)
    {
        $this->status = $result['status'];
        $this->paymentId = (int)$result['paymentId'];
        $this->conversationData = $result['conversationData'];
        $this->conversationId = (int)$result['conversationId'];
        $this->mdStatus = $result['mdStatus'];
    }

}