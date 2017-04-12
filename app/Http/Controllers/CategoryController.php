<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Models\Application;
use App\Models\Category;
use Auth;
use Common;
use DateTime;
use DB;
use eProcessTypes;
use eStatus;
use eUserTypes;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoryController extends Controller {

    public function index(Request $request, MyResponse $myResponse)
    {
        $appID = $request->get('appID', 0);
        $contentID = $request->get('contentID', 0);
        $type = $request->get('type', '');

        $application = Application::find($appID);
        if (!$application)
        {
            return $myResponse->error(trans('error.something_went_wrong'));
        }
        if (!$application->checkUserAccess())
        {
            return $myResponse->error(trans('error.unauthorized_user_attempt'));
        }
        $data = [
            'page'      => 'categories',
            'rows'      => $application->Categories,
            'contentID' => $contentID,
        ];
        if ($type == 'options')
        {
            return view('pages.categoryoptionlist', $data);
        }

        return view('pages.categorylist', $data);
    }

    public function save(Request $request, MyResponse $myResponse)
    {
        $currentUser = Auth::user();

        $id = $request->get('CategoryCategoryID', '0');
        $applicationID = (int)$request->get('CategoryApplicationID', '0');
        $chk = Common::CheckApplicationOwnership($applicationID);
        $rules = [
            'CategoryApplicationID' => 'required|integer|min:1',
            'CategoryName'          => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails() || !$chk)
        {
            return $myResponse->error(trans('common.detailpage_validation'));
        }

        if ($id == 0)
        {
            $s = new Category();
        } else
        {
            $chk = Common::CheckCategoryOwnershipWithApplication($applicationID, $id);
            if (!$chk)
            {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
            }
            $s = Category::find($id);
        }
        //$s->ApplicationID = (int)$request->get('CategoryApplicationID');
        $s->ApplicationID = $applicationID;
        $s->Name = $request->get('CategoryName');
        if ($id == 0)
        {
            $s->StatusID = eStatus::Active;
            $s->CreatorUserID = $currentUser->UserID;
            $s->DateCreated = new DateTime();
        }
        $s->ProcessUserID = $currentUser->UserID;
        $s->ProcessDate = new DateTime();
        if ($id == 0)
        {
            $s->ProcessTypeID = eProcessTypes::Insert;
        } else
        {
            $s->ProcessTypeID = eProcessTypes::Update;
        }
        $s->save();

        return $myResponse->success();
    }

    public function delete(Request $request, MyResponse $myResponse)
    {
        $currentUser = Auth::user();

        $id = $request->get('CategoryID', '0');

        $chk = Common::CheckCategoryOwnership($id);
        if (!$chk)
        {
            $myResponse->error(trans('common.detailpage_validation'));
        }

        $s = Category::find($id);
        if ($s)
        {
            $s->StatusID = eStatus::Deleted;
            $s->ProcessUserID = $currentUser->UserID;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Update;
            $s->save();
        }

        return $myResponse->success();
    }

}
