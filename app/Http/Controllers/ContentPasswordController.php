<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Models\ContentPassword;
use App\Models\Customer;
use Auth;
use Common;
use DateTime;
use DB;
use eProcessTypes;
use eStatus;
use eUserTypes;
use Hash;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Mockery\Exception;
use Validator;

/**
 * Used  for content page requests
 * Class ContentPasswordController
 * @package App\Http\Controllers
 */
class ContentPasswordController extends Controller
{
    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';

    /**
     * ContentPasswords_Controller constructor.
     */
    public function __construct() {
        $this->page = 'contentpasswords';
        $this->route = __('route.' . $this->page);
        $this->table = 'ContentPassword';
        $this->pk = 'ContentPasswordID';
    }

    public function index(Request $request) {
        $user = Auth::user();

        $contentID = (int) $request->get('contentID', 0);

        $rows = ContentPassword::where('ContentID', $contentID)
            ->orderBy('Name', 'ASC')
            ->get();

        if (Auth::user()->UserTypeID == eUserTypes::Customer) {
            //get only customers passwords
            //Todo: Add CustomerID to ContentPassword
            $rows = DB::table('Customer AS c')
                ->join('Application AS a', function(JoinClause $join) {
                    $join->on('a.CustomerID', 'c.CustomerID');
                })
                ->join('Content AS cn', function(JoinClause $join) use ($contentID) {
                    $join->on('cn.ApplicationID', 'a.ApplicationID');
                })
                ->join('ContentPassword AS cp', function(JoinClause $join) {
                    $join->on('cp.ContentID', 'cn.ContentID');
                })
                ->where('c.CustomerID', $user->CustomerID)
                ->where('cn.ContentID', $contentID)
                ->where('c.StatusID', eStatus::Active)
                ->where('cp.StatusID', eStatus::Active)
                ->where('cn.StatusID', eStatus::Active)
                ->where('a.StatusID', eStatus::Active)
                ->orderBy('cp.Name', 'ASC')
                ->get(['cp.*']);
        }

        $data = array(
            'page' => $this->page,
            'route' => $this->route,
            'pk' => $this->pk,
            'rows' => $rows,
            'contentID' => $contentID
        );
        $type = $request->get('type', '');
        if ($type == "qty") {
            $qty = 0;
            foreach ($rows as $row) {
                $qty = $qty + (int) $row->Qty;
            }
            return $qty;
        }
        return view('pages.contentpasswordlist', $data);

    }

    public function save(Request $request, MyResponse $myResponse) {
        $currentUser = Auth::user();

        $rules = array(
            'ContentPasswordID' => 'required|integer',
            'ContentPasswordContentID' => 'required|integer',
            'ContentPasswordName' => 'required',
            'ContentPasswordPassword' => 'required',
            'ContentPasswordQty' => 'required|integer|min:1'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return $myResponse->error(trans('common.detailpage_validation'));
        }

        $id = $request->get('ContentPasswordID', '0');
        $contentID = $request->get('ContentPasswordContentID', '0');

        $chk = Common::CheckContentOwnership($contentID);
        if (!$chk) {
            return $myResponse->error(trans('common.detailpage_validation'));
        }

        if ($id == 0) {
            $s = new ContentPassword();
        } else {
            $chk = Common::CheckContentPasswordOwnership($id);
            if (!$chk) {
                return $myResponse->error(trans('common.detailpage_validation'));
            }
            $s = ContentPassword::find($id);
        }
        //$s->ApplicationID = (int)$request->get('CategoryApplicationID');

        /** @var  $s ContentPassword */
        $s->ContentID = $contentID;
        $s->Name = $request->get('ContentPasswordName');
        if (strlen(trim($request->get('ContentPasswordPassword'))) > 0) {
            $s->Password = Hash::make($request->get('ContentPasswordPassword'));
        }
        $s->Qty = $request->get('ContentPasswordQty');
        if ($id == 0) {
            $s->StatusID = eStatus::Active;
            $s->CreatorUserID = $currentUser->UserID;
            $s->DateCreated = new DateTime();
        }
        $s->ProcessUserID = $currentUser->UserID;
        $s->ProcessDate = new DateTime();
        if ($id == 0) {
            $s->ProcessTypeID = eProcessTypes::Insert;
        } else {
            $s->ProcessTypeID = eProcessTypes::Update;
        }
        $s->save();
        return $myResponse->success();
    }

    public function delete(Request $request, MyResponse $myResponse) {
        $currentUser = Auth::user();

        $id = (int) $request->get($this->pk, '0');

        $chk = Common::CheckContentPasswordOwnership($id);
        if (!$chk) {
            return $myResponse->error(trans('common.detailpage_validation'));
        }

        $s = ContentPassword::find($id);
        if ($s) {
            $s->StatusID = eStatus::Deleted;
            $s->ProcessUserID = $currentUser->UserID;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Update;
            $s->save();
        }
        return $myResponse->success();
    }
}
