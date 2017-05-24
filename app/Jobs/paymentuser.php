<?php

use App\Mail\ErrorMailler;
use App\Mail\PaymentAdminRemainderMailler;

class PaymentUser_Task {

    public function run()
    {
        try
        {
            $this->getPayment();
        } catch (Exception $e)
        {
            $msg = __('common.task_message', [
                    'task'   => '`BackupDatabase`',
                    'detail' => $e->getMessage(),
                ]
            );
            Mail::to(config('mail.admin_email'))->queue(new ErrorMailler($msg));
        }
    }

    public function getPayment()
    {
        $WarningMailSet = [];
        /** @var PaymentAccount[] $paymentAccounts */
        $paymentAccounts = PaymentAccount::where('StatusID', eStatus::Active)->get();
        foreach ($paymentAccounts as $paymentAccount)
        {
            $payment = new MyPayment();
            $result = $payment->paymentWithToken($paymentAccount);
            sleep(60);
            if (!empty($result))
            {
                $WarningMailSet[] = $result;
            }
        }

        if (!empty($WarningMailSet))
        {
            Mail::to(config('custom.payment_delay_reminder_admin_mail'))->queue(new PaymentAdminRemainderMailler($WarningMailSet));
        }

    }

}
