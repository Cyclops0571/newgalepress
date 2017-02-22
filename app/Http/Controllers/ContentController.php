<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Models\Application;
use App\Models\Category;
use App\Models\Content;
use App\Models\ContentFile;
use App\Models\GroupCode;
use App\User;
use Auth;
use Common;
use Cookie;
use DB;
use eRemoveFromMobile;
use eRequestType;
use eStatus;
use eUserTypes;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Redirect;
use Response;
use Uploader;
use UploadHandler;
use Validator;
use View;

class ContentController extends Controller
{
    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailcaption = '';
    public $fields;
    private $defaultSort = "OrderNo";

    public function __construct()
    {
        $this->page = 'contents';
        $this->route = __('route.' . $this->page);
        $this->table = 'Content';
        $this->pk = 'ContentID';
        $this->caption = __('common.contents_caption');
        $this->detailcaption = __('common.contents_caption_detail');


    }


    private function setFields(User $user)
    {
        $this->fields = array();
        if ($user->UserTypeID == eUserTypes::Customer) {
            $this->fields[] = array(__('common.contents_list_content_name'), 'Name');
            $this->fields[] = array(__('common.contents_list_contents_detail'), 'Detail');
            $this->fields[] = array(__('common.contents_list_contents_monthlyName'), 'Order');
            $this->fields[] = array(__('common.contents_list_content_category'), 'CategoryName');
            $this->fields[] = array(__('common.contents_list_content_publishdate'), 'PublishDate');
            $this->fields[] = array(__('common.contents_list_content_unpublishdate'), 'UnpublishDate');
            $this->fields[] = array(__('common.contents_list_content_bloke'), 'Blocked');
            $this->fields[] = array(__('common.contents_list_status'), 'Status');
            $this->fields[] = array(__('common.contents_list_content_id'), 'ContentID');
        } else if ($user->UserTypeID == eUserTypes::Manager) {
            $this->fields = array();
            $this->fields[] = array(__('common.contents_list_customer'), 'CustomerName');
            $this->fields[] = array(__('common.contents_list_application'), 'ApplicationName');
            $this->fields[] = array(__('common.contents_list_content_name'), 'Name');
            $this->fields[] = array(__('common.contents_list_content_bloke'), 'Blocked');
            $this->fields[] = array(__('common.contents_list_status'), 'Status');
            $this->fields[] = array(__('common.contents_list_content_id'), 'ContentID');
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

        if (!Common::CheckApplicationOwnership($applicationID)) {
            return Redirect::to(route('home'));
        }

        $rows = Content::getContents($request);
        $categorySet = Category::where('ApplicationID', '=', $applicationID)->where("statusID", "=", eStatus::Active)->get();
        $application = Application::find($applicationID);
        $data = array(
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->caption,
            'pk' => $this->pk,
            'fields' => $this->fields,
            'search' => $search,
            'sort' => $sort,
            'sort_dir' => $sort_dir,
            'rows' => $rows,
            'categorySet' => $categorySet,
            'application' => $application
        );

        if (((int)$user->UserTypeID == eUserTypes::Customer)) {
            $appCount = DB::table('Application')
                ->where('CustomerID', '=', Auth::user()->CustomerID)
                ->where('ApplicationID', '=', $applicationID)
                ->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
                ->count();

            if ($appCount == 0) {

                $app = Application::find($applicationID);
                if (!$app) {
                    return Redirect::to(__('route.home'));
                }

                $data = array_merge($data, array('appName' => $app->Name));
                return View::make('pages.expiredpage', $data)
                    ->nest('filterbar', 'sections.filterbar', $data)
                    ->nest('commandbar', 'sections.commandbar', $data);
            }
        }

        return $html = View::make('pages.' . Str::lower($this->table) . 'list', $data)
            ->nest('filterbar', 'sections.filterbar', $data)
            ->nest('commandbar', 'sections.commandbar', $data);
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
        try {
            if ($RequestTypeID == eRequestType::PDF_FILE) {
                //get file
                $oCustomerID = 0;
                $oApplicationID = 0;
                $oContentID = 0;
                $oContentFileID = 0;
                $oContentFilePath = '';
                $oContentFileName = '';
                Common::getContentDetail($ContentID, $Password, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentFilePath, $oContentFileName);
                Common::download($RequestTypeID, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, 0, $oContentFilePath, $oContentFileName);
            } else {
                //get image
                Common::downloadImage($ContentID, $RequestTypeID, $Width, $Height);
            }
        } catch (Exception $e) {
            $r = '';
            $r .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
            $r .= "<Response>\n";
            $r .= "<Error code=\"" . $e->getCode() . "\">" . Common::xmlEscape($e->getMessage()) . "</Error>\n";
            $r .= "</Response>\n";
            return Response::make($r, 200, array('content-type' => 'text/xml'));
        }
    }

    public function newly(Request $request)
    {
        $this->route = __('route.' . $this->page) . '?applicationID=' . $request->get('applicationID', '0');

        $data = array(
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->caption,
            'detailcaption' => $this->detailcaption,
            'content' => new Content(),
            'showCropPage' => 0,
        );
        $applicationID = $request->get('applicationID', '0');
        /** @var Application $app */
        $app = Application::find($applicationID);
        if (!$app) {
            return Redirect::to(__('route.home'));
        } else if ($app->ExpirationDate < date('Y-m-d')) {
            $data['appName'] = $app->Name;
            return View::make('pages.expiredpage', $data)
                ->nest('filterbar', 'sections.filterbar', $data);
        }

        $data['app'] = $app;
        $data['categories'] = $app->Categories();
        $data['groupCodes'] = GroupCode::getGroupCodes();
        return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
            ->nest('filterbar', 'sections.filterbar', $data);
    }

    public function show(Content $content)
    {
        $currentUser = Auth::user();
        $showCropPage = Cookie::get(SHOW_IMAGE_CROP, 0);
        Cookie::make(SHOW_IMAGE_CROP, 0);
        if (((int)$currentUser->UserTypeID == eUserTypes::Manager)) {
            $contentList = DB::table('Content')
                // ->where('ApplicationID', '=', $row->ApplicationID)
                ->where('ContentID', '<>', $content->ContentID)
                // ->where('StatusID', '=', eStatus::Active)
                ->get(array('ContentID', 'Name', 'ApplicationID'));
        } else {
            //musteriler icin interactive oge kopyalamayi kapatiyorum.
//            $contentList = DB::table('Content')
//                ->where('ApplicationID', '=', $row->ApplicationID)
//                ->where('ContentID', '<>', $id)
//                ->where('StatusID', '=', eStatus::Active)
//                ->get(array('ContentID', 'Name', 'ApplicationID'));
            $contentList = array();
        }
        if ($content) {
            if (Common::CheckContentOwnership($content->ContentID)) {
                $this->route = __('route.' . $this->page) . '?applicationID=' . $content->ApplicationID;


                $data = array(
                    'page' => $this->page,
                    'route' => $this->route,
                    'caption' => $this->caption,
                    'detailcaption' => $this->detailcaption,
                    'content' => $content,
                    'app' => $content->Application,
                    'categories' => $content->Application->Categories(),
                    'groupCodes' => GroupCode::getGroupCodes(),
                    'showCropPage' => $showCropPage,
                    'contentList' => $contentList,
                );

                if (((int)$currentUser->UserTypeID == eUserTypes::Customer)) {
                    if ($content->Application->ExpirationDate < date('Y-m-d')) {
                        return View::make('pages.expiredpage', $data);
                    }
                }
                return View::make('pages.' . Str::lower($this->table) . 'detail', $data);
            } else {
                return Redirect::to($this->route);
            }
        } else {
            return Redirect::to($this->route);
        }
    }

    public function temp() {
        $authInteractivity = (1 == (int)$app->Package()->Interactive);
        $authMaxPDF = Common::AuthMaxPDF($app->ApplicationID);

        $applications = Application::where('StatusID', '=', eStatus::Active)
            ->orderBy('Name', 'ASC')
            ->get();

        $categories = Category::where('ApplicationID', '=', $app->ApplicationID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('Name', 'ASC')
            ->get();
        $groupCodes = DB::table('GroupCode AS gc')
            ->join('GroupCodeLanguage AS gcl', function ($join) {
                $join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
                $join->on('gcl.LanguageID', '=', Common::getLocaleId());
            })
            ->where('gc.GroupName', '=', 'Currencies')
            ->where('gc.StatusID', '=', eStatus::Active)
            ->orderBy('gc.DisplayOrder', 'ASC')
            ->orderBy('gcl.DisplayName', 'ASC')
            ->get();


    }

    public function save(Request $request, MyResponse $myResponse)
    {
        set_time_limit(3000);
        $currentUser = Auth::user();
        $id = (int)$request->get($this->pk, '0');
        $applicationID = (int)$request->get('ApplicationID', '0');
        $chk = Common::CheckApplicationOwnership($applicationID);
        $rules = array(
            'ApplicationID' => 'required|integer|min:1',
            'Name' => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->passes() && $chk) {
            if (!Common::AuthMaxPDF($applicationID)) {
                return  $myResponse->error(__('error.auth_max_pdf'));

            }
            try {
                $content = Content::find($id);
                $selectedCategories = $request->get('chkCategoryID', array());

                if (!$content) {
                    $maxID = DB::table("Content")->where("ApplicationID", "=", $applicationID)->max('OrderNo');
                    $content = new Content();
                    $content->OrderNo = $maxID + 1;
                } else if (!Common::CheckContentOwnership($id)) {
                    throw new Exception("Unauthorized user attempt");
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
                if ($content->Status == eStatus::Active) {
                    $content->RemoveFromMobile = eRemoveFromMobile::Passive;
                }

                if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
                    $content->Approval = (int)$request->get('Approval');
                    $content->Blocked = (int)$request->get('Blocked');
                }
                $content->ifModifiedDoNecessarySettings($selectedCategories);
                $content->save();
                $content->setCategory($selectedCategories);
                $content->setTopics($request->get('topicIds', array()));

                $contentID = $content->ContentID;
                $contentFile = $content->processPdf();
                $content->processImage($contentFile, (int)$request->get('hdnCoverImageFileSelected', 0), $request->get('hdnCoverImageFileName'));
                ContentFile::createPdfPages($contentFile);
                $content->callIndexingService($contentFile);
            } catch (Exception $e) {
                return  $myResponse->error($e->getMessage());

            }
            $contentLink = $contentID > 0 ? "&contentID=" . $contentID : ("");
            return  $myResponse->success($contentLink);
        } else {
            return  $myResponse->error(__('common.detailpage_validation'));

        }
    }

    public function copy(MyResponse $myResponse, $id, $new)
    {
        try {
            // return Redirect::to(__('route.home'));
            $sourceContentID = $id;
            $contentFileControl = null;
            $newContentID = $new;

            $content = DB::table('Content')
                ->where('ContentID', '=', $sourceContentID)
                ->first();

            if ($new == "new") {

                $c = new Content();
                $c->ApplicationID = $content->ApplicationID;
                $c->Name = $content->Name;
                $c->Detail = $content->Detail;
                $c->MonthlyName = $content->MonthlyName;
                $c->PublishDate = $content->PublishDate;
                $c->IsUnpublishActive = $content->IsUnpublishActive;
                $c->UnpublishDate = $content->UnpublishDate;
                $c->CategoryID = $content->CategoryID;
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

                $contentCategory = DB::table('ContentCategory')
                    ->where('ContentID', '=', $sourceContentID)
                    ->get();

                foreach ($contentCategory as $cCategory) {
                    $cc = new ContentCategory();
                    $cc->ContentID = $newContentID;
                    $cc->CategoryID = $cCategory->CategoryID;
                    $cc->save();
                }


                /* yeni icerigin kopyalanmasi(new) */
                $c = DB::table('Content')
                    ->where('ContentID', '=', $newContentID)
                    ->first();
                $customerID = Application::find($c->ApplicationID)->CustomerID;
                $contentFile = DB::table('ContentFile')
                    ->where('ContentID', '=', $sourceContentID)
                    ->first();


                $targetFilePath = 'public/' . $contentFile->FilePath . '/' . $contentFile->FileName;

                $destinationFolder = 'public/files/customer_' . $customerID . '/application_' . $c->ApplicationID . '/content_' . $c->ContentID;

                File::makeDirectory($destinationFolder, 777, true);
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
                foreach ($files as $file) {
                    // echo nl2br($targetFilePath."\n");
                    File::copy('public/' . $contentFile->FilePath . '/' . basename($file), $destinationFolder . '/' . basename($file));
                }

                $this->get_copyContent($destinationFolder, $sourceContentID, $c->ContentID, $cf->ContentFileID);
            }

            $contentFileControl = DB::table('ContentFile')
                ->where('ContentID', '=', $newContentID)
                ->orderBy('ContentFileID', 'DESC')
                ->first();

            $contentFilePageControl = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', $contentFileControl->ContentFileID)
                ->get();

            if (sizeof($contentFilePageControl) == 0) {/* sayfalari olusmamis */
                Controller::call('interactivity@show', array($contentFileControl->ContentFileID));
                $this->get_copyContent("null", $sourceContentID, $newContentID, $contentFileControl->ContentFileID);
            } elseif ($new != "new") {/* sayfalari olusmus */
                // Controller::call('interactivity@show', array($contentFileControl->ContentFileID));
                $this->get_copyContent("null", $sourceContentID, $newContentID, $contentFileControl->ContentFileID);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return  $myResponse->error($e->getMessage());
        }
    }

    /**
     * @param $destinationFolder
     * @param $sourceContentID
     * @param $targetContentID
     * @param $targetContentFileID
     * @return string
     */
    public function copyContent($destinationFolder, $sourceContentID, $targetContentID, $targetContentFileID)
    {
        // /***** HEDEF CONTENTIN SAYFALARI OLUSUTURLMUS OLMALI YANI INTERAKTIF TASARLAYICISI ACILMIS OLMALI!!!*****/
        // TAŞINACAK CONTENT'IN FILE ID'SI
        $myResponse = new MyResponse();

        try {
            $contentFile = DB::table('ContentFile')
                ->where('ContentID', '=', $sourceContentID)
                ->orderBy('ContentFileID', 'DESC')
                ->first();

            $contentFilePage = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', $contentFile->ContentFileID)
                ->get();

            if (sizeof($contentFilePage) == 0) {
                return;
            } else {

                $contentFilePageNewCount = DB::table('ContentFilePage')
                    ->where('ContentFileID', '=', $targetContentFileID)//****************
                    ->count();

                $targetApplicationID = DB::table('Content')
                    ->where('ContentID', '=', $targetContentID)//****************
                    ->first();

                $targetCustomerID = DB::table('Application')
                    ->where('ApplicationID', '=', $targetApplicationID->ApplicationID)//****************
                    ->first();

                if ($destinationFolder != "null") { /* kopyalanacak icerigin sayfalari yok ise olusturur */
                    foreach ($contentFilePage as $ocfp) {
                        $ncfp = new ContentFilePage();
                        $ncfp->ContentFileID = (int)$targetContentFileID;
                        $ncfp->No = (int)$ocfp->No;
                        $ncfp->Width = (int)$ocfp->Width;
                        $ncfp->Height = (int)$ocfp->Height;
                        $ncfp->FilePath = (string)'files/customer_' . $targetCustomerID->CustomerID . '/application_' . $targetApplicationID->ApplicationID . '/content_' . $targetContentID . '/file_' . $targetContentFileID;
                        $ncfp->FileName = (string)$ocfp->FileName;
                        $ncfp->FileName2 = (string)$ocfp->FileName2;
                        $ncfp->FileSize = (int)$ocfp->FileSize;
                        $ncfp->StatusID = (int)$ocfp->StatusID;
                        $ncfp->CreatorUserID = (int)$ocfp->CreatorUserID;
                        $ncfp->DateCreated = new DateTime();
                        $ncfp->ProcessUserID = $ocfp->CreatorUserID;
                        $ncfp->ProcessDate = new DateTime();
                        $ncfp->ProcessTypeID = (int)eProcessTypes::Insert;
                        $ncfp->save();
                    }
                    if (!File::exists($destinationFolder . '/file_' . $targetContentFileID)) {
                        File::makeDirectory($destinationFolder . '/file_' . $targetContentFileID);
                    }

                    $files = glob('public/' . $contentFile->FilePath . '/file_' . $contentFile->ContentFileID . '/*.{jpg,pdf}', GLOB_BRACE);
                    foreach ($files as $file) {
                        File::copy('public/' . $contentFile->FilePath . '/file_' . $contentFile->ContentFileID . '/' . basename($file), $destinationFolder . '/file_' . $targetContentFileID . '/' . basename($file));
                    }
                }

                foreach ($contentFilePage as $cfp) {


                    $filePageComponent = DB::table('PageComponent')
                        ->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
                        ->get();

                    if (sizeof($filePageComponent) == 0) {
                        continue;
                    }

                    //HANGI CONTENT'E TASINACAKSA O CONTENT'IN FILE ID'SI
                    $contentFilePageNew = DB::table('ContentFilePage')
                        ->where('ContentFileID', '=', $targetContentFileID)//****************
                        ->where('No', '=', $cfp->No)
                        ->first();

                    // var_dump(isset($contentFilePageNew));
                    if (isset($contentFilePageNew)) {
                        // Log::info("girdiiii");
                        foreach ($filePageComponent as $fpc) {
                            $s = new PageComponent();
                            $s->ContentFilePageID = $contentFilePageNew->ContentFilePageID;
                            $s->ComponentID = $fpc->ComponentID;
                            if ($destinationFolder == "null") {
                                $lastComponentNo = DB::table('PageComponent')
                                    ->where('ContentFilePageID', '=', $contentFilePageNew->ContentFilePageID)
                                    ->orderBy('No', 'DESC')
                                    ->take(1)
                                    ->only('No');
                                if ($lastComponentNo == null) {
                                    $lastComponentNo = 0;
                                }
                                $s->No = $lastComponentNo + 1;
                            } else {
                                $s->No = $fpc->No;
                            }
                            // Log::info(serialize($ids));
                            $s->StatusID = eStatus::Active;
                            $s->DateCreated = new DateTime();
                            $s->ProcessDate = new DateTime();
                            $s->ProcessTypeID = eProcessTypes::Insert;
                            $s->save();

                            $filePageComponentProperty = DB::table('PageComponentProperty')
                                ->where('PageComponentID', '=', $fpc->PageComponentID)
                                ->where('StatusID', '=', eStatus::Active)
                                ->get();

                            foreach ($filePageComponentProperty as $fpcp) {
                                $p = new PageComponentProperty();
                                $p->PageComponentID = $s->PageComponentID;
                                $p->Name = $fpcp->Name;
                                if ($fpcp->Value > $contentFilePageNewCount && $fpcp->Name == "page") {
                                    $p->Value = 1;
                                } elseif ($fpcp->Name == "filename") {
                                    $targetPath = 'files/customer_' . $targetCustomerID->CustomerID . '/application_' . $targetApplicationID->ApplicationID . '/content_' . $targetContentID . '/file_' . $targetContentFileID . '/output/comp_' . $s->PageComponentID;
                                    $targetPathFull = public_path($targetPath);
                                    $p->Value = $targetPath . '/' . basename($fpcp->Value);
                                    if (!File::exists($targetPathFull)) {
                                        File::makeDirectory($targetPathFull, 777, true);
                                    }
                                    $files = glob('public/' . dirname($fpcp->Value) . '/*.{jpg,JPG,png,PNG,tif,TIF,mp3,MP3,m4v,M4V,mp4,MP4,mov,MOV}', GLOB_BRACE);
                                    // Log::info('public/'.dirname($fpcp->Value));
                                    foreach ($files as $file) {
                                        File::copy($file, $targetPathFull . '/' . basename($file));
                                    }
                                } else {
                                    $p->Value = $fpcp->Value;
                                }
                                $p->StatusID = eStatus::Active;
                                $p->DateCreated = new DateTime();
                                $p->ProcessDate = new DateTime();
                                $p->ProcessTypeID = eProcessTypes::Insert;
                                $p->save();
                            }
                        }
                    }
                }
            }

            $targetHasCreated = ContentFile::find($targetContentFileID);
            if ($targetHasCreated) {
                $targetHasCreated->Interactivity = Interactivity::ProcessQueued;
                $targetHasCreated->HasCreated = 0;
                $targetHasCreated->save();
            }

            interactivityQueue::trigger();
            return  $myResponse->success();

        } catch (Exception $e) {
            Log::info($e->getMessage());
            return  $myResponse->error($e->getMessage());
        }
    }

    public function delete(Request $request, MyResponse $myResponse)
    {
        $id = (int)$request->get($this->pk, '0');
        $chk = Common::CheckContentOwnership($id);
        if (!$chk) {
            return  $myResponse->error(__('common.detailpage_validation'));
        }

        try {
            DB::transaction(function () use ($id) {
                $s = Content::find($id);
                if ($s) {
                    $s->StatusID = eStatus::Deleted;
                    $s->ProcessUserID = Auth::user()->UserID;
                    $s->ProcessDate = new DateTime();
                    $s->ProcessTypeID = eProcessTypes::Update;
                    $s->save();
                }
            });
            return  $myResponse->success();
        } catch (Exception $e) {
            return  $myResponse->error($e->getMessage());
        }
    }

    public function uploadfile(Request $request)
    {
        ob_start();
        $element = $request->get('element');
        $options = array(
            'upload_dir' => public_path('files/temp/'),
            'upload_url' => URL::base() . '/files/temp/',
            'param_name' => $element,
            'accept_file_types' => '/\.(pdf)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!request()->ajax()) {
            return;
        }

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

    public function uploadcoverimage(Request $request)
    {
        ob_start();

        $element = $request->get('element');

        $options = array(
            'upload_dir' => public_path('files/temp/'),
            'upload_url' => url('/files/temp/'),
            'param_name' => $element,
            'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!request()->ajax()) {
            return;
        }

        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();

        $json = get_object_vars(json_decode($ob));
        $arr = $json[$element];
        $obj = $arr[0];
        $tempFile = $obj->name;
        //var_dump($obj->name);
        Uploader::CmykControl($tempFile);
        return Response::json(array("fileName" => $tempFile));
    }


    public function order(Request $request, MyResponse $myResponse, $applicationID)
    {
        $chk = Common::CheckApplicationOwnership($applicationID);
        if (!$chk) {
            return  $myResponse->error(__('common.detailpage_validation'));
        }
        $maxID = DB::table("Content")->where("ApplicationID", "=", $applicationID)->max('OrderNo');
        $contentIDDescSet = $request->get("contentIDSet", array());
        $i = $maxID + 1;
        $contentIDSet = array_reverse($contentIDDescSet);
        foreach ($contentIDSet as $contentID) {
            $content = Content::where("ApplicationID", "=", $applicationID)->find($contentID);
            if ($content) {
                $content->OrderNo = $i++;
                $content->save(FALSE);
                //appversionu altte tek bir kere artiracagim icin burada artirmiyorum.
            }
        }

        $application = Application::find($applicationID);
        if ($application) {
            $application->incrementAppVersion();
        }
        return  $myResponse->success();
    }

    /**
     * Contenti yayindan kaldirip mobilden de kaldirilma flagini 1 yapar
     * @param int $contentID
     * @return string
     */
    public function remove_from_mobile(MyResponse $myResponse, $contentID)
    {
        $chk = Common::CheckContentOwnership($contentID);
        if (!$chk) {
            return  $myResponse->error(__('common.detailpage_validation'));
        }

        try {
            DB::transaction(function () use ($contentID) {
                $s = Content::find($contentID);
                if ($s) {
                    $s->Status = eStatus::Passive;
                    $s->RemoveFromMobile = eRemoveFromMobile::Active;
                    $s->save();
                }
            });
            return  $myResponse->success();
        } catch (Exception $e) {
            return  $myResponse->error($e->getMessage());
        }
    }

    public function refresh_identifier(Request $request, MyResponse $myResponse)
    {
        $rules = array(
            "ContentID" => "required|numeric|min:1",
        );
        $v = Validator::make($request->all(), $rules);
        if (!$v->passes()) {
            return  $myResponse->error($v->errors->first());

//	    ajaxResponse::error($v->errors->first());
        }

        $content = Content::find($request->get("ContentID"));
        $subscriptionIdentifier = $content->getIdentifier(TRUE);
        $content->save();
        return  $myResponse->success("&SubscriptionIdentifier=" . $subscriptionIdentifier);
    }

    public function interactivity_status()
    {
        set_time_limit(0);
        $rules = array(
            "contentFileID" => "required|numeric|min:1",
        );
        $v = Validator::make($request->all(), $rules);
        if (!$v->passes()) {
            return ajaxResponse::error($v->errors->first());
        }
        $contentFileID = $request->get("contentFileID");
        for ($i = 0; $i < 240; $i++) {
            $contentFile = ContentFile::find($contentFileID);
            if ($contentFile && $contentFile->HasCreated) {
                return ajaxResponse::success();
            }
            sleep(1);
        }
        return ajaxResponse::error();
    }
}
