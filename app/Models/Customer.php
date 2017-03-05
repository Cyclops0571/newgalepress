<?php

namespace App\Models;

use eStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @property int $CustomerID
 * @property string $CustomerNo
 * @property string $CustomerName
 * @property string $Address
 * @property string $City
 * @property string $Country
 * @property string $Phone1
 * @property string $Phone2
 * @property string $Email
 * @property string $BillName
 * @property string $BillAddress
 * @property string $BillTaxOffice
 * @property string $BillTaxNumber
 * @property int $TotalFileSize
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $Applications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCustomerNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCustomerName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillTaxOffice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillTaxNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereTotalFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereProcessTypeID($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $Application
 */
class Customer extends Model
{


    public $timestamps = false;
    protected $table = 'Customer';
    protected $primaryKey = 'CustomerID';

    public static function CustomerFileSize()
    {
        $command = 'du -ha ' . public_path('files/') . ' --max-depth=1| sort -hr';
        $folderStructure = shell_exec($command);
        $folders = explode(PHP_EOL, $folderStructure);
        $folderSizes = array();
        foreach ($folders as $folder) {
            $list = explode("\t", $folder);
            if (count($list) == 2) {
                if (strpos($list[1], "customer_")) {
                    $customerID = str_replace(public_path('files/customer_'), '', $list[1]);
                    $folderSizes[$list[0]] = Customer::query()->find($customerID);
                }
            }
        }

        return $folderSizes;
    }

    /**
     * @param $CustomerID
     * @param $Active
     * @return array|null|\stdClass|Customer
     */
    public static function getCustomerByID($CustomerID, $Active)
    {
        return self::where('CustomerID', '=', $CustomerID)
        ->where('StatusID', '=', $Active)
        ->first();
    }


    /**
     * @param int $statusID
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function Applications($statusID = eStatus::All) {
        return $this->Application()->getQuery()->where('StatusID', '=', $statusID)->get();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Application()
    {
        return $this->hasMany(Application::class, $this->primaryKey);
    }

    /**
     *
     * @return PaymentAccount|\Illuminate\Database\Eloquent\Builder
     */
    public function getLastSelectedPaymentAccount()
    {
        return $this->hasOne(PaymentAccount::class, "CustomerID")->getQuery()->orderBy("selected_at", "DESC")->first();
    }

    /**
     *
     * @return PaymentAccount|\Illuminate\Database\Eloquent\Builder
     */
    public function PaymentAccount()
    {
        return $this->hasOne(PaymentAccount::class, "CustomerID")->getQuery()->first();
    }

}
