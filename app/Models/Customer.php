<?php

namespace App\Models;

use DB;
use eStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $Application
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillTaxNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBillTaxOffice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCustomerName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCustomerNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereTotalFileSize($value)
 * @mixin \Eloquent
 */
class Customer extends Model {


    public $timestamps = false;
    protected $table = 'Customer';
    protected $primaryKey = 'CustomerID';

    public static function CustomerFileSize()
    {
        $command = 'du -ha ' . public_path('files/') . ' --max-depth=1| sort -hr';
        $folderStructure = shell_exec($command);
        $folders = explode(PHP_EOL, $folderStructure);
        $folderSizes = [];
        foreach ($folders as $folder)
        {
            $list = explode("\t", $folder);
            if (count($list) == 2)
            {
                if (strpos($list[1], "customer_"))
                {
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
        return self::where('CustomerID', $CustomerID)
            ->where('StatusID', $Active)
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasMany
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

    public static function customerList($search = '', $sort = 'CustomerID', $sortDirection = 'DESC')
    {
        $sql = '' .
            'SELECT ' .
            '(SELECT COUNT(*) FROM `Application` WHERE CustomerID=c.CustomerID AND StatusID=1) AS ApplicationCount, ' .
            '(SELECT COUNT(*) FROM `User` WHERE CustomerID=c.CustomerID AND StatusID=1) AS UserCount, ' .
            'c.CustomerNo, ' .
            'c.CustomerName, ' .
            'c.Phone1, ' .
            'c.Email, ' .
            'c.CustomerID ' .
            'FROM `Customer` AS c ' .
            'WHERE c.StatusID=1';

        return DB::table(DB::raw('(' . $sql . ') t'))
            ->where(function (Builder $query) use ($search)
            {
                if (strlen(trim($search)) > 0)
                {
                    $query->where('ApplicationCount', 'LIKE', '%' . $search . '%');
                    $query->orWhere('UserCount', 'LIKE', '%' . $search . '%');
                    $query->orWhere('CustomerNo', 'LIKE', '%' . $search . '%');
                    $query->orWhere('CustomerName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('Phone1', 'LIKE', '%' . $search . '%');
                    $query->orWhere('Email', 'LIKE', '%' . $search . '%');
                    $query->orWhere('CustomerID', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy($sort, $sortDirection)->paginate(config('custom.rowcount'));
    }
}
