<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Order
 *
 * @property int $OrderID
 * @property int $ApplicationID
 * @property string $OrderNo
 * @property string $Name
 * @property string $Description
 * @property string $Keywords
 * @property string $Product
 * @property int $Qty
 * @property string $Website
 * @property string $Email
 * @property string $Facebook
 * @property string $Twitter
 * @property string $Pdf
 * @property string $Image1024x1024
 * @property string $Image640x960
 * @property string $Image640x1136
 * @property string $Image1536x2048
 * @property string $Image2048x1536
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereImage1024x1024($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereImage1536x2048($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereImage2048x1536($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereImage640x1136($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereImage640x960($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereKeywords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePdf($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereQty($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereWebsite($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    public $timestamps = false;
    protected $table = 'Order';
    protected $primaryKey = 'OrderID';

    public static function orderList($applicationID = 0, $search = '', $sort = 'OrderID', $sortDirectory = 'desc' ) {

        $sql = '' .
            'SELECT ' .
            'o.ApplicationID, ' .
            'o.OrderNo, ' .
            'o.Name, ' .
            'o.Description, ' .
            'o.Keywords, ' .
            'o.Website, ' .
            'o.Email, ' .
            'o.OrderID ' .
            'FROM `Order` AS o ' .
            'WHERE o.StatusID=1';

        return DB::table(DB::raw('(' . $sql . ') t'))
            ->where(function (Builder $query) use ($applicationID, $search)
            {
                if ($applicationID > 0)
                {
                    $query->where('ApplicationID', '=', $applicationID);
                }

                if (strlen(trim($search)) > 0)
                {
                    $query->where('ApplicationID', 'LIKE', '%' . $search . '%');
                    $query->orWhere('OrderNo', 'LIKE', '%' . $search . '%');
                    $query->orWhere('Name', 'LIKE', '%' . $search . '%');
                    $query->orWhere('Description', 'LIKE', '%' . $search . '%');
                    $query->orWhere('Keywords', 'LIKE', '%' . $search . '%');
                    $query->orWhere('OrderID', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy($sort, $sortDirectory)->paginate(config('custom.rowcount'));
    }
}
