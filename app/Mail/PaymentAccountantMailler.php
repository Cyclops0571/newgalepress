<?php

namespace App\Mail;

use App\Models\PaymentAccount;
use App\Models\PaymentTransaction;
use Common;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentAccountantMailler extends Mailable implements ShouldQueue{

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @param PaymentAccount[] $paymentAccounts
     * @return array
     */
    private function getAccountExcelData($paymentAccounts) {
        $accountExcelArray = [];
        if (!empty($paymentAccounts))
        {
            $accountRow = [];
            $accountRow[] = "Sirket Kodu";
            $accountRow[] = "Müşteri No";
            $accountRow[] = "Ünvan1";
            $accountRow[] = "Ünvan2";
            $accountRow[] = "Sokak ve Konut Numarası";
            $accountRow[] = "Şehir";
            $accountRow[] = "Ülke";
            $accountRow[] = "Dil";
            $accountRow[] = "Vergi Daire";
            $accountRow[] = "Vergi No";
            $accountRow[] = "Hesap";
            $accountRow[] = "Bölge"; //plaka kodu
            $accountExcelArray[] = $accountRow;
        }

        foreach ($paymentAccounts as $paymentAccount)
        {
            $city = $paymentAccount->city;

            $accountRow = [];
            $accountRow[] = 1000 + $paymentAccount->PaymentAccountID; //Sirket Kodu
            $accountRow[] = ""; //Müşteri No
            $accountRow[] = $paymentAccount->title; //unvan1
            $accountRow[] = ""; //unvan2
            $accountRow[] = $paymentAccount->address; //Sokak ve Konut Numarası
            $accountRow[] = $city->CityName; //sehir
            $accountRow[] = "Türkiye"; //ulke
            $accountRow[] = "tr"; //dil
            if ($paymentAccount->kurumsal)
            {
                $accountRow[] = $paymentAccount->vergi_dairesi; //bireysel mi
                $accountRow[] = $paymentAccount->vergi_no; //bireysel mi
                $accountRow[] = ""; //bireysel mi
            } else
            {
                $accountRow[] = ""; //bireysel mi
                $accountRow[] = ""; //bireysel mi
                $accountRow[] = $paymentAccount->tckn; //bireysel mi
            }
            $accountRow[] = $city->CityID; //bireysel mi
            $accountExcelArray[] = $accountRow;
        }
        return $accountExcelArray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //yeni cekilmis bir ucret var ise onu verecek
        //yeni acilmis bir account var ise onu verecek

        $paymentAccounts = PaymentAccount::where("mail_send", "!=", 1)
            ->orderBy("PaymentAccountID", "DESC")
            ->get();

        $paymentTransactions = PaymentTransaction::where("mail_send", "!=", 1)
            ->where('paid', '1')
            ->where('amount', '>', 0)
            ->orderBy("PaymentAccountID")
            ->get();

        $accountExcelArray = $this->getAccountExcelData($paymentAccounts);
        $transactionExcelArray = $this->getTransactionExcelData($paymentTransactions);

        if (empty($accountExcelArray) && empty($transactionExcelArray))
        {
            return $this;
        }


        //mail gonder...
        $accountExcelFile = "";
        $transactionExcelFile = "";
        if (!empty($accountExcelArray))
        {
            $accountExcelFileName = date("Y_m_d") . "account.xls";
            $accountExcelFile = storage_path("excel/" . $accountExcelFileName);
            Common::toExcel($accountExcelArray, $accountExcelFile);
        }
        if (!empty($transactionExcelArray))
        {
            $transactionExcelFileName = date("Y_m_d") . "transaction.xls";
            $transactionExcelFile = storage_path("/excel/" . $transactionExcelFileName);
            Common::toExcel($transactionExcelArray, $transactionExcelFile);
        }

        if (!empty($accountExcelFile) || !empty($transactionExcelFile))
        {
            $subject = 'Ödeme Bilgilendirme Maili';
            $mail = $this->view("mail-templates.payment_accountant_mail")
                ->with(['title' => $subject])
                ->subject($subject);
            if (!empty($accountExcelFile))
            {
                $mail->attach($accountExcelFile);
            }

            if (!empty($transactionExcelFile))
            {
                $mail->attach($transactionExcelFile);
            }

            foreach ($paymentAccounts as $paymentAccount)
            {
                /** @var PaymentAccount $paymentAccount */
                $paymentAccount->mail_send = 1;
                $paymentAccount->save();
            }

            foreach ($paymentTransactions as $paymentTransaction)
            {
                $paymentTransaction->mail_send = 1;
                $paymentTransaction->save();
            }
            return $mail;
        }
    }

    /**
     * @param PaymentTransaction[] $paymentTransactions
     * @return array
     */
    private function getTransactionExcelData($paymentTransactions)
    {
        $transactionExcelArray = [];
        if (!empty($paymentTransactions))
        {
            $transactionRow = [];
            $transactionRow[] = "Vergi Numarası - TCKN";
            $transactionRow[] = "Müşteri Ünvanı";
            $transactionRow[] = "Kontrat başlangıç tarihi";
            $transactionRow[] = "Kontrat bitiş tarihi";
            $transactionRow[] = "Aylık kontrat değeri";
            $transactionRow[] = "Para birimi";
            $transactionRow[] = "Fatura Vade";
            $transactionExcelArray[] = $transactionRow;
        }

        foreach ($paymentTransactions as $paymentTransaction)
        {
            $paymentAccount = $paymentTransaction->PaymentAccount;
            if (!$paymentAccount) {
                continue;
            }

            $transactionRow = [];
            if ($paymentAccount->kurumsal)
            {
                $transactionRow[] = $paymentAccount->vergi_no;
            } else
            {
                $transactionRow[] = $paymentAccount->tckn;
            }
            $transactionRow[] = $paymentAccount->title; //unvan
            $transactionRow[] = date("Y-m-d", strtotime($paymentAccount->created_at)); //kontrat baslangic
            $transactionRow[] = date("Y-m-d", strtotime("+12 month " . $paymentAccount->created_at)); //kontrat bitis
            $transactionRow[] = $paymentTransaction->amount; //Aylik Kontrat degeri
            $transactionRow[] = "YTL"; //Para Birimi
            $transactionRow[] = date("Y-m-d"); //Fatura Vade
            $transactionExcelArray[] = $transactionRow;
        }
        return $transactionExcelArray;
    }
}
