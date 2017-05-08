<?php

namespace App\Http\Controllers;

use App\Library\AjaxResponse;
use App\Library\ContentHelper;
use App\Library\MyResponse;
use App\Library\Uploader;
use App\Library\UploadHandler;
use App\Models\Application;
use App\Models\Category;
use App\Models\Content;
use App\Models\ContentCategory;
use App\Models\ContentCoverImageFile;
use App\Models\ContentFile;
use App\Models\GroupCode;
use App\User;
use Auth;
use Common;
use Cookie;
use DateTime;
use DB;
use eProcessTypes;
use eRemoveFromMobile;
use eRequestType;
use eStatus;
use eUserTypes;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Interactivity;
use Log;
use Redirect;
use Response;
use URL;
use Validator;
use View;

class ContentController extends Controller {

    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailCaption = '';
    public $fields;
    private $defaultSort = "OrderNo";

    public function __construct()
    {
        $this->page = 'contents';
        $this->route = __('route.' . $this->page);
        $this->table = 'Content';
        $this->pk = 'ContentID';
        $this->caption = __('common.contents_caption');
        $this->detailCaption = __('common.contents_caption_detail');


    }


    private function setFields(User $user)
    {
        $this->fields = [];
        if ($user->UserTypeID == eUserTypes::Customer)
        {
            $this->fields[] = [__('common.contents_list_content_name'), 'Name'];
            $this->fields[] = [__('common.contents_list_contents_detail'), 'Detail'];
            $this->fields[] = [__('common.contents_list_contents_monthlyName'), 'Order'];
            $this->fields[] = [__('common.contents_list_content_category'), 'CategoryName'];
            $this->fields[] = [__('common.contents_list_content_publishdate'), 'PublishDate'];
            $this->fields[] = [__('common.contents_list_content_unpublishdate'), 'UnpublishDate'];
            $this->fields[] = [__('common.contents_list_content_bloke'), 'Blocked'];
            $this->fields[] = [__('common.contents_list_status'), 'Status'];
            $this->fields[] = [__('common.contents_list_content_id'), 'ContentID'];
        } else if ($user->UserTypeID == eUserTypes::Manager)
        {
            $this->fields = [];
            $this->fields[] = [__('common.contents_list_customer'), 'CustomerName'];
            $this->fields[] = [__('common.contents_list_application'), 'ApplicationName'];
            $this->fields[] = [__('common.contents_list_content_name'), 'Name'];
            $this->fields[] = [__('common.contents_list_content_bloke'), 'Blocked'];
            $this->fields[] = [__('common.contents_list_status'), 'Status'];
            $this->fields[] = [__('common.contents_list_content_id'), 'ContentID'];
        }

    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $this->setFields($user);
        $applicationID = $request->get('applicationID', 0);
        $search = $request->get('search', '');
        $sort = $request->get('sort', $this->defaultSort);
        $sort_dir = $request->get('sort_dir', 'DESC');

        if (!Common::CheckApplicationOwnership($applicationID))
        {
            return Redirect::to(route('home'));
        }


        $rows = Content::contentList($request);
        $categorySet = Category::where('ApplicationID', '=', $applicationID)->where("statusID", "=", eStatus::Active)->get();
        $application = Application::find($applicationID);
        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'pk'            => $this->pk,
            'fields'        => $this->fields,
            'search'        => $search,
            'sort'          => $sort,
            'sort_dir'      => $sort_dir,
            'rows'          => $rows,
            'categorySet'   => $categorySet,
            'application'   => $application,
            'currentPageNo' => $request->get('page', 0),
        ];

        if ($request->get('option', 0) == 1)
        {
            return view('pages.contentoptionlist', $data);
        }

        $applicationID = $request->get('applicationID', 0);
        if ($user->UserTypeID == eUserTypes::Customer)
        {
            $appCount = DB::table('Application')
                ->where('CustomerID', '=', Auth::user()->CustomerID)
                ->where('ApplicationID', '=', $applicationID)
                ->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
                ->count();

            if ($appCount == 0)
            {

                $app = Application::find($applicationID);
                if (!$app)
                {
                    return Redirect::to(route('home'));
                }

                $data = array_merge($data, ['appName' => $app->Name]);

                return View::make('pages.expiredpage', $data);
            }
        }

        return $html = View::make('pages.contentlist', $data);
    }

    public function request(Request $request)
    {
        //"http://www.galepress.com/tr/icerikler/talep?W=%s&H=%s&RequestTypeID=%s&ContentID=%s";
        $RequestTypeID = (int)$request->get('RequestTypeID', 0);
        $ContentID = (int)$request->get('ContentID', 0);
        $Password = $request->get('Password', '');
        $Width = (int)$request->get('W', 0);
        $Height = (int)$request->get('H', 0);


        //http://localhost/tr/icerikler/talep?RequestTypeID=203&ApplicationID=1&ContentID=1187&Password=
        try
        {
            if ($RequestTypeID == eRequestType::PDF_FILE)
            {
                //get file
                $oCustomerID = 0;
                $oApplicationID = 0;
                $oContentID = 0;
                $oContentFileID = 0;
                $oContentFilePath = '';
                $oContentFileName = '';
                Common::getContentDetail($ContentID, $Password, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentFilePath, $oContentFileName);
                Common::download($RequestTypeID, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, 0, $oContentFilePath, $oContentFileName);//todo: break this function to small pieces
            } else
            {
                //get image
                Common::downloadImage($ContentID, $RequestTypeID, $Width, $Height);//todo: break this function to small pieces
            }
        } catch (Exception $e)
        {
            return Response::make($this->xmlResponse($e), 200, ['content-type' => 'text/xml']);
        }

        return abort(404);
    }

    public function newly(Request $request)
    {
        $this->route = __('route.' . $this->page) . '?applicationID=' . $request->get('applicationID', '0');

        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'detailCaption' => $this->detailCaption,
            'content'       => new Content(),
            'showCropPage'  => 0,
        ];
        $applicationID = $request->get('applicationID', '0');
        $app = Application::find($applicationID);
        if (!$app)
        {
            return Redirect::to(__('route.home'));
        } else if ($app->ExpirationDate < date('Y-m-d'))
        {
            $data['appName'] = $app->Name;

            return View::make('pages.expiredpage', $data);
        }

        $data['app'] = $app;
        $data['categories'] = $app->Categories;
        $data['groupCodes'] = GroupCode::getGroupCodesWithName('Currencies');
        $data['authMaxPDF'] = Common::AuthMaxPDF($app->ApplicationID);
        $data['authInteractivity'] = (1 == (int)$app->Package->Interactive);


        return View::make('pages.' . Str::lower($this->table) . 'detail', $data);
    }

    public function show(Request $request, Content $content)
    {
        $currentUser = Auth::user();
        $showCropPage = $request->cookie(SHOW_IMAGE_CROP, 0);
        Cookie::make(SHOW_IMAGE_CROP, 0);
        if (((int)$currentUser->UserTypeID == eUserTypes::Manager))
        {
            $contentList = DB::table('Content')
                // ->where('ApplicationID', '=', $row->ApplicationID)
                ->where('ContentID', '<>', $content->ContentID)
                // ->where('StatusID', '=', eStatus::Active)
                ->get(['ContentID', 'Name', 'ApplicationID']);
        } else
        {
            //musteriler icin interactive oge kopyalamayi kapatiyorum.
            //            $contentList = DB::table('Content')
            //                ->where('ApplicationID', '=', $row->ApplicationID)
            //                ->where('ContentID', '<>', $id)
            //                ->where('StatusID', '=', eStatus::Active)
            //                ->get(array('ContentID', 'Name', 'ApplicationID'));
            $contentList = [];
        }
        if ($content)
        {
            if (Common::CheckContentOwnership($content->ContentID))
            {
                $this->route = __('route.' . $this->page) . '?applicationID=' . $content->ApplicationID;

                $data = [
                    'page'          => $this->page,
                    'route'         => $this->route,
                    'caption'       => $this->caption,
                    'detailCaption' => $this->detailCaption,
                    'content'       => $content,
                    'app'           => $content->Application,
                    'categories'    => $content->Application->Categories,
                    'groupCodes'    => GroupCode::getGroupCodesWithName('Currencies'),
                    'showCropPage'  => $showCropPage,
                    'contentList'   => $contentList,
                ];

                $app = Application::find($content->ApplicationID);
                $data['authMaxPDF'] = Common::AuthMaxPDF($app->ApplicationID);
                $data['authInteractivity'] = (1 == (int)$app->Package->Interactive);

                if (((int)$currentUser->UserTypeID == eUserTypes::Customer))
                {
                    if ($content->Application->ExpirationDate < date('Y-m-d'))
                    {
                        return View::make('pages.expiredpage', $data);
                    }
                }

                return View::make('pages.' . Str::lower($this->table) . 'detail', $data);
            } else
            {
                return Redirect::to($this->route);
            }
        } else
        {
            return Redirect::to($this->route);
        }
    }

    public function save(Request $request, MyResponse $myResponse)
    {
        set_time_limit(3000);
        $currentUser = Auth::user();
        $id = (int)$request->get($this->pk, '0');
        $applicationID = (int)$request->get('ApplicationID', '0');
        $chk = Common::CheckApplicationOwnership($applicationID);
        $rules = [
            'ApplicationID' => 'required|integer|min:1',
            'Name'          => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if (!$v->passes() || !$chk)
        {
            return $myResponse->error(__('common.detailpage_validation'));
        }

        if (!Common::AuthMaxPDF($applicationID))
        {
            return $myResponse->error(__('error.auth_max_pdf'));

        }

        $content = Content::find($id);
        $selectedCategories = $request->get('chkCategoryID', []);

        if (!$content)
        {
            $maxID = Content::where('ApplicationID', '=', $applicationID)->max('OrderNo');
            $content = new Content();
            $content->OrderNo = $maxID + 1;
        } else if (!Common::CheckContentOwnership($id))
        {
            return $myResponse->error("Unauthorized user attempt");
        }


        $content->ApplicationID = $applicationID;
        $content->Name = $request->get('Name');
        $content->Detail = $request->get('Detail');
        $content->MonthlyName = $request->get('MonthlyName');
        $content->PublishDate = date('Y-m-d', strtotime($request->get('PublishDate', date('Y-m-d'))));
        $content->IsUnpublishActive = (int)$request->get('IsUnpublishActive');
        $content->UnpublishDate = date('Y-m-d', strtotime($request->get('UnpublishDate', date('Y-m-d'))));
        $content->IsProtected = (int)$request->get('IsProtected');
        $content->IsBuyable = (int)$request->get('IsBuyable');
        $content->CurrencyID = (int)$request->get('CurrencyID');
        $content->Orientation = (int)$request->get('Orientation');
        $content->setPassword($request->get('Password'));
        $content->setMaster((int)$request->get('IsMaster'));
        $content->AutoDownload = (int)$request->get('AutoDownload');
        $content->TopicStatus = $request->get('topicStatus', 0) === "on";
        $content->Status = (int)$request->get('Status');
        if ($content->Status == eStatus::Active)
        {
            $content->RemoveFromMobile = eRemoveFromMobile::Passive;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Manager)
        {
            $content->Approval = (int)$request->get('Approval');
            $content->Blocked = (int)$request->get('Blocked');
        }

        $content->save();
        $content->Category()->sync($selectedCategories);
        $content->Topic()->sync($request->get('topicIds', []));

        $contentFile = $content->processPdf();
        if ($contentFile)
        {
            $content->processImage($contentFile, (int)$request->get('hdnCoverImageFileSelected', 0), $request->get('hdnCoverImageFileName'));
            ContentFile::createPdfPages($contentFile);
            $content->callIndexingService($contentFile);
        }

        return $myResponse->success(['contentID' => $content->ContentID]);
    }

    public function copy(MyResponse $myResponse, $id, $new)
    {
        try
        {
            // return Redirect::to(__('route.home'));
            $sourceContentID = $id;
            $contentFileControl = null;
            $newContentID = $new;

            $content = Content::find($sourceContentID);

            if ($new == "new")
            {

                $c = new Content();
                $c->ApplicationID = $content->ApplicationID;
                $c->Name = $content->Name;
                $c->Detail = $content->Detail;
                $c->MonthlyName = $content->MonthlyName;
                $c->PublishDate = $content->PublishDate;
                $c->IsUnpublishActive = $content->IsUnpublishActive;
                $c->UnpublishDate = $content->UnpublishDate;
                $c->IsProtected = $content->IsProtected;
                $c->Password = $content->Password;
                $c->IsBuyable = $content->IsBuyable;
                $c->CurrencyID = $content->CurrencyID;
                $c->IsMaster = 2;
                $c->Orientation = $content->Orientation;
                $c->AutoDownload = $content->AutoDownload;
                $c->Approval = $content->Approval;
                $c->Blocked = $content->Blocked;
                $c->Status = $content->Status;
                $c->Version = $content->Version;
                $c->PdfVersion = $content->PdfVersion;
                $c->CoverImageVersion = $content->CoverImageVersion;
                $c->TotalFileSize = $content->TotalFileSize;
                $c->StatusID = eStatus::Active;
                $c->CreatorUserID = $content->CreatorUserID;
                $c->DateCreated = new DateTime();
                $c->ProcessUserID = $content->ProcessUserID;
                $c->ProcessDate = new DateTime();
                $c->ProcessTypeID = eProcessTypes::Insert;
                $c->OrderNo = $content->OrderNo;
                $c->save();
                $newContentID = $c->ContentID;

                $c->Category()->sync($content->Category->pluck(Content::$key));


                /* yeni icerigin kopyalanmasi(new) */
                $c = Content::find($newContentID);
                $customerID = Application::find($c->ApplicationID)->CustomerID;
                $contentFile = DB::table('ContentFile')
                    ->where('ContentID', '=', $sourceContentID)
                    ->first();


                $targetFilePath = 'public/' . $contentFile->FilePath . '/' . $contentFile->FileName;

                $destinationFolder = 'public/files/customer_' . $customerID . '/application_' . $c->ApplicationID . '/content_' . $c->ContentID;

                File::makeDirectory($destinationFolder, 0777, true);
                File::copy($targetFilePath, $destinationFolder . '/' . $contentFile->FileName);
                // Log::info($targetFilePath."|||".$destinationFolder.'/'.$contentFile->FileName);

                $cf = new ContentFile();
                $cf->ContentID = $c->ContentID;
                $cf->DateAdded = $contentFile->DateAdded;
                $cf->FilePath = 'files/customer_' . $customerID . '/application_' . $c->ApplicationID . '/content_' . $c->ContentID;
                $cf->FileName = $contentFile->FileName;
                $cf->FileSize = $contentFile->FileSize;
                $cf->Transferred = $contentFile->Transferred;
                $cf->Interactivity = Interactivity::ProcessAvailable;
                $cf->HasCreated = 0;
                //$cf->InteractiveFilePath = 'files/customer_' . $customerID . '/application_' . $c->ApplicationID . '/content_' . $c->ContentID;
                $cf->InteractiveFileName = $contentFile->InteractiveFileName;
                $cf->InteractiveFileSize = $contentFile->InteractiveFileSize;
                $cf->Included = $contentFile->Included;
                $cf->StatusID = $contentFile->StatusID;
                $cf->CreatorUserID = $contentFile->CreatorUserID;
                $cf->DateCreated = new DateTime();
                $cf->ProcessUserID = $content->ProcessUserID;
                $cf->ProcessDate = new DateTime();
                $cf->ProcessTypeID = eProcessTypes::Insert;
                $cf->save();

                $contentCoverImageFile = DB::table('ContentCoverImageFile')
                    ->where('ContentFileID', '=', $contentFile->ContentFileID)
                    ->first();


                $ccif = new ContentCoverImageFile();
                $ccif->ContentFileID = $cf->ContentFileID;
                $ccif->DateAdded = $contentCoverImageFile->DateAdded;
                $ccif->FilePath = $contentCoverImageFile->FilePath;
                $ccif->SourceFileName = $contentCoverImageFile->SourceFileName;
                $ccif->FileName = $contentCoverImageFile->FileName;
                $ccif->FileName2 = $contentCoverImageFile->FileName2;
                $ccif->FileSize = $contentCoverImageFile->FileSize;
                $ccif->StatusID = $contentCoverImageFile->StatusID;
                $ccif->CreatorUserID = $contentCoverImageFile->CreatorUserID;
                $ccif->DateCreated = new DateTime();
                $ccif->ProcessUserID = $contentCoverImageFile->ProcessUserID;
                $ccif->ProcessDate = new DateTime();
                $ccif->ProcessTypeID = eProcessTypes::Insert;
                $ccif->save();


                $files = glob('public/' . $contentFile->FilePath . '/*.{jpg}', GLOB_BRACE);
                foreach ($files as $file)
                {
                    // echo nl2br($targetFilePath."\n");
                    File::copy('public/' . $contentFile->FilePath . '/' . basename($file), $destinationFolder . '/' . basename($file));
                }

                ContentHelper::copyContent($destinationFolder, $sourceContentID, $c->ContentID, $cf->ContentFileID);
            }

            $contentFileControl = DB::table('ContentFile')
                ->where('ContentID', '=', $newContentID)
                ->orderBy('ContentFileID', 'DESC')
                ->first();

            $contentFilePageControl = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', $contentFileControl->ContentFileID)
                ->get();

            if (sizeof($contentFilePageControl) == 0)
            {
                //Page are not created yet

                //todo:571571 Controller::call ???
                //Controller::call('interactivity@show', [$contentFileControl->ContentFileID]);
                ContentHelper::copyContent("null", $sourceContentID, $newContentID, $contentFileControl->ContentFileID);
            } elseif ($new != "new")
            {
                //Pages has already created
                ContentHelper::copyContent("null", $sourceContentID, $newContentID, $contentFileControl->ContentFileID);
            }
        } catch (Exception $e)
        {
            Log::info($e->getMessage());

            return $myResponse->error($e->getMessage());
        }

        return $myResponse->success();
    }


    public function delete(Request $request, MyResponse $myResponse)
    {
        $id = (int)$request->get($this->pk, '0');
        $chk = Common::CheckContentOwnership($id);
        if (!$chk)
        {
            return $myResponse->error(__('common.detailpage_validation'));
        }

        try
        {
            DB::transaction(function () use ($id)
            {
                $s = Content::find($id);
                if ($s)
                {
                    $s->StatusID = eStatus::Deleted;
                    $s->ProcessUserID = Auth::user()->UserID;
                    $s->ProcessDate = new DateTime();
                    $s->ProcessTypeID = eProcessTypes::Update;
                    $s->save();
                }
            });

            return $myResponse->success();
        } catch (Exception $e)
        {
            return $myResponse->error($e->getMessage());
        }
    }

    public function uploadfile(Request $request)
    {

        ob_start();
        $element = $request->get('element');
        $options = [
            'upload_dir'        => public_path('files/temp/'),
            'upload_url'        => URL::to('/') . '/files/temp/',
            'param_name'        => $element,
            'accept_file_types' => '/\.(pdf)$/i',
        ];
        $upload_handler = new UploadHandler($options);
        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();

        $json = get_object_vars(json_decode($ob));
        $arr = $json[$element];
        $obj = $arr[0];
        $tempFile = $obj->name;
        $ret = Uploader::ContentsUploadFile($tempFile);

        return Response::json($ret);
    }

    public function uploadCoverImage(Request $request)
    {
        ob_start();

        $element = $request->get('element');

        $options = [
            'upload_dir'        => public_path('files/temp/'),
            'upload_url'        => url('/files/temp/'),
            'param_name'        => $element,
            'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i',
        ];
        $upload_handler = new UploadHandler($options);
        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();

        $json = get_object_vars(json_decode($ob));
        $arr = $json[$element];
        $obj = $arr[0];
        $tempFile = $obj->name;
        //var_dump($obj->name);
        Uploader::CmykControl($tempFile);

        return Response::json(["fileName" => $tempFile]);
    }


    public function order(Request $request, MyResponse $myResponse, Application $myApplication)
    {
        $chk = $myApplication->checkUserAccess();
        if (!$chk)
        {
            return $myResponse->error(__('common.detailpage_validation'));
        }
        $maxID = $myApplication->Contents->max('OrderNo');
        $contentIDDescSet = $request->get("contentIDSet", []);
        $i = $maxID + 1;
        $contentIDSet = array_reverse($contentIDDescSet);
        foreach ($contentIDSet as $contentID)
        {
            /** @var Content $content */
            if ($content = $myApplication->Contents->keyBy('ContentID')->find($contentID))
            {
                $content->OrderNo = $i++;
                $content->save(['updateAppVersion' => false]);
            }
        }

        $myApplication->incrementAppVersion();

        return $myResponse->success();
    }

    /**
     * Contenti yayindan kaldirip mobilden de kaldirilma flagini 1 yapar
     * @param MyResponse $myResponse
     * @param int $contentID
     * @return string
     */
    public function remove_from_mobile(MyResponse $myResponse, $contentID)
    {
        $chk = Common::CheckContentOwnership($contentID);
        if (!$chk)
        {
            return $myResponse->error(__('common.detailpage_validation'));
        }

        try
        {
            DB::transaction(function () use ($contentID)
            {
                $s = Content::find($contentID);
                if ($s)
                {
                    $s->Status = eStatus::Passive;
                    $s->RemoveFromMobile = eRemoveFromMobile::Active;
                    $s->save();
                }
            });

            return $myResponse->success();
        } catch (Exception $e)
        {
            return $myResponse->error($e->getMessage());
        }
    }

    public function refresh_identifier(Request $request, MyResponse $myResponse)
    {
        $rules = [
            "ContentID" => "required|numeric|min:1",
        ];
        $v = Validator::make($request->all(), $rules);
        if (!$v->passes())
        {
            return $myResponse->error($v->errors->first());

            //	    AjaxResponse::error($v->errors->first());
        }

        $content = Content::find($request->get("ContentID"));
        $subscriptionIdentifier = $content->getIdentifier(true);
        $content->save();

        return $myResponse->success("&SubscriptionIdentifier=" . $subscriptionIdentifier);
    }

    public function interactivityStatus(Request $request)
    {
        set_time_limit(0);
        $rules = [
            "contentFileID" => "required|numeric|min:1",
        ];
        $v = Validator::make($request->all(), $rules);
        if (!$v->passes())
        {
            return AjaxResponse::error($v->errors->first());
        }
        $contentFileID = $request->get("contentFileID");
        for ($i = 0; $i < 240; $i++)
        {
            $contentFile = ContentFile::find($contentFileID);
            dd($contentFile);

            if ($contentFile && $contentFile->HasCreated)
            {
                return AjaxResponse::success();
            }
            sleep(1);
        }

        return AjaxResponse::error(trans('error.interactivity_error'));
    }

    /**
     * @param $e
     * @return string
     */
    protected function xmlResponse(Exception $e)
    {
        $r = '';
        $r .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $r .= "<Response>\n";
        $r .= "<Error code=\"" . $e->getCode() . "\">" . Common::xmlEscape($e->getMessage()) . "</Error>\n";
        $r .= "</Response>\n";

        return $r;
    }
}
