<?php

namespace App\Http\Controllers;

use App\Library\AjaxResponse;
use App\Models\Application;
use App\Models\Banner;
use Auth;
use eStatus;
use eUserTypes;
use Illuminate\Http\Request;
use Uploader;
use UploadHandler;
use URL;

class BannerController extends Controller
{
    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailCaption = '';
    public $fields;

    public function __construct()
    {
        parent::__construct();
        $this->page = 'banners';
        $this->route = __('route.' . $this->page);
        $this->table = 'Banner';
        $this->pk = 'BannerID';
        $this->caption = __('common.applications_caption');
        $this->detailCaption = __('common.banners_caption_detail');
        $this->fields = array();
        $this->fields[] = __('common.image') . ' (1480x640)';
        $this->fields[] = __('common.banner_list_customer');
        $this->fields[] = __('common.banner_list_application');
        $this->fields[] = __('common.banner_form_target_url');
        //	$this->fields[] = __('common.banner_form_target_content');
        $this->fields[] = __('common.banner_description');
        $this->fields[] = __('common.banners_list_status');
        $this->fields[] = __('common.banner_list_banner_id');
        $this->fields[] = __('common.detailpage_delete');

        if (Auth::user()->UserTypeID == eUserTypes::Customer) {
            $this->fields = array();
            $this->fields[] = __('common.image') . ' (1480x640)';
            $this->fields[] = __('common.banner_form_target_url');
            //	    $this->fields[] = __('common.banner_form_target_content');
            $this->fields[] = __('common.banner_description');
            $this->fields[] = __('common.banners_list_status');
            $this->fields[] = __('common.banner_list_banner_id');
            $this->fields[] = __('common.detailpage_delete');
        }
    }

    public function get_index(Request $request)
    {
        $applicationID = (int)$request->get('applicationID', 0);
        $application = Application::find($applicationID);
        if (!$application || !$application->CheckOwnership()) {
            return Redirect::to(__('route.home'));
        }

        $rows = Banner::getAppBanner($applicationID);
        $data = array();
        $data['route'] = $this->route;
        $data['caption'] = __('common.application_settings_caption_detail');
        $data['route'] = str_replace('(:num)', $application->ApplicationID, __('route.applications_usersettings'));
        $data['detailCaption'] = $this->detailCaption;
        $data['pk'] = $this->pk;
        $data['page'] = $this->page;
        $data['fields'] = $this->fields;
        $data['rows'] = $rows;
        $data['application'] = $application;
        return $html = view('pages.' . Str::lower($this->table) . 'list', $data)
            ->nest('filterbar', 'sections.filterbar', $data)
            ->nest('commandbar', 'sections.commandbar', $data);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function get_delete(Request $request)
    {
        $banner = Banner::find((int)$request->get('id'));
        if (!$banner) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
        $application = Application::find($banner->ApplicationID);
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $banner->StatusID = eStatus::Deleted;
        $banner->save();
        return "success=" . base64_encode("true");
    }

    public function post_order(Request $request, $applicationID)
    {
        $application = Application::find($applicationID);
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
        $bannerIDSet = $request->get("bannerIDSet");
        $bannerCount = count($bannerIDSet);
        for ($i = 0; $i < $bannerCount; $i++) {
            $banner = Banner::find($bannerIDSet[$i]);
            $banner->OrderNo = $bannerCount - $i;
            $banner->save();
        }

        return "success=" . base64_encode("true");
    }

    public function post_save(Request $request)
    {
        $application = Application::find($request->get("applicationID"));
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        if ($request->has("newBanner")) {
            //set a default dummy banner
            /* @var $maxOrderedBanner Banner */
            $maxOrderedBanner = Banner::where("ApplicationID", "=", $application->ApplicationID)->orderBy("OrderNo", "DESC")->first();
            $order = 1;
            if ($maxOrderedBanner) {
                $order = $maxOrderedBanner->OrderNo + 1;
            }

            $banner = new Banner();
            $banner->ApplicationID = $application->ApplicationID;
            $banner->OrderNo = $order;
            $banner->Status = eStatus::Passive;
            $banner->save();
        } else {
            $banner = Banner::find((int)$request->get("pk"));
            if (!$banner) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
            }
            if ($request->has("TargetContent")) {
                $banner->TargetContent = (int)$request->get("TargetContent");
            }

            if ($request->has("TargetUrl")) {
                if (!$request->get("TargetUrl", "")) {
                    $banner->TargetUrl = "";
                } else if (preg_match('/^https?:\/\/.+$/', $request->get("TargetUrl", ""))) {
                    $banner->TargetUrl = $request->get("TargetUrl");
                } else {
                    $banner->TargetUrl = "http://" . $request->get("TargetUrl");
                }
            }

            if ($request->has("Status")) {
                $banner->Status = (int)$request->get('Status');
            }

            if ($request->has("name")) {
                $name = $request->get("name");
                $value = $request->get("value", "");
                if ($name == "TargetUrl") {
                    if (!$value) {
                        $banner->TargetUrl = "";
                    } else if (preg_match('/^https?:\/\/.+$/', $value)) {
                        $banner->TargetUrl = $value;
                    } else {
                        $banner->TargetUrl = "http://" . $value;
                    }
                } else if ($name == "Description") {
                    $banner->Description = $value;
                }
            }
            $banner->save();
        }

        return "success=" . base64_encode("true")
            . "&BannerID=" . base64_encode($banner->BannerID)
            . "&BannerImagePath=" . base64_encode($banner->getImagePath())
            . "&ActiveText=" . base64_encode((string)__('common.active'))
            . "&PassiveText=" . base64_encode((string)__('common.passive'));
    }

    public function post_save_banner_setting(Request $request)
    {
        $application = Application::find($request->get("applicationID"));
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $rules = array(
            "BannerActive" => 'in:on',
            "BannerAutoplay" => 'in:on',
            "BannerCustomerActive" => 'in:1',
            "BannerIntervalTime" => 'integer|min:1',
            "BannerTransitionRate" => 'integer|min:1',
            "BannerColor" => 'match:/^#[A-Fa-f0-9]{6}$/',
        );
        if ((int)$request->get("BannerCustomerActive")) {
            $rules["BannerCustomerUrl"] = 'required|min:2';
        }

        $ruleNames = array(
            "BannerActive" => __('common.contents_status'),
            "BannerAutoplay" => __('common.banners_autoplay'),
            "BannerCustomerActive" => __("common.banner_use_costomer_banner"),
            "BannerIntervalTime" => __('common.banners_autoplay_interval'),
            "BannerTransitionRate" => __('common.banners_autoplay_speed'),
            "BannerCustomerUrl" => __("common.banner_use_costomer_banner"),
            "BannerColor" => __("common.banners_pager_color"),
        );


        $v = Laravel\Validator::make($request->all(), $rules);
        if (!$v->passes()) {
            $errMsg = $v->errors->first();
            foreach ($ruleNames as $inputName => $ruleName) {
                $errMsg = str_replace($inputName, $ruleName, $errMsg);
            }
            //	    return "success=" . base64_encode("false") . "&errmsg=" . $errMsg;
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($errMsg);
        }

        if ($request->get("BannerCustomerUrl") == '' || $request->get("BannerCustomerUrl") == 'http://') {
            $application->BannerCustomerUrl = '';
        } else if (preg_match('/^https?:\/\/.+$/', $request->get("BannerCustomerUrl"))) {
            $application->BannerCustomerUrl = $request->get("BannerCustomerUrl");
        } else {
            $application->BannerCustomerUrl = "http://" . $request->get("BannerCustomerUrl");
        }

        $application->BannerActive = $request->get("BannerActive", "off") == "on" ? 1 : 0;
        $application->BannerAutoplay = $request->get("BannerAutoplay", "off") == "on" ? 1 : 0;
        $application->BannerRandom = $request->get("BannerRandom", "off") == "on" ? 1 : 0;
        $application->BannerCustomerActive = (int)$request->get("BannerCustomerActive");
        $application->BannerIntervalTime = (int)$request->get("BannerIntervalTime", 0);
        $application->BannerTransitionRate = (int)$request->get("BannerTransitionRate", 0);
        $application->BannerColor = $request->get('BannerColor');
        $application->BannerSlideAnimation = $request->get('BannerSlideAnimation');
        $application->save();
        return "success=" . base64_encode("true");
    }

    public function post_imageupload(Request $request)
    {
        ob_start();


        $rules = array(
            'element' => 'required',
            'bannerID' => 'required',
        );

        $v = Validator::make($request->all(), $rules);
        if (!$v->passes()) {
            return AjaxResponse::error($v->errors->first());
        }

        $element = $request->get('element');
        $banner = Banner::find($request->get('bannerID'));
        if (!$banner) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $options = array(
            'upload_dir' => public_path('files/temp/'),
            'upload_url' => URL::to('/files/temp/'),
            'param_name' => $element,
            'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!$request->ajax()) {
            return AjaxResponse::error(__('common.detailpage_validation'));
        }

        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();

        $json = get_object_vars(json_decode($ob));
        $arr = $json[$element];
        $obj = $arr[0];
        $tempFile = $obj->name;

        Uploader::CmykControl($tempFile);
        $banner->processImage($tempFile);
        return ["fileName" => $banner->ImagePublicPath];
    }

    public function get_service_view($applicationID)
    {
        $application = Application::find($applicationID);
        $bannerSet = Banner::getAppBanner($applicationID, FALSE);
        if (!$application || !$bannerSet) {
            return "";
        }

        if ($application->BannerRandom) {
            shuffle($bannerSet);
        }

        $data = array();
        $data['caption'] = $this->caption;
        $data['detailCaption'] = $this->detailCaption;
        $data["application"] = $application;
        $data['bannerSet'] = $bannerSet;
        //            $application->BannerRandom ? shuffle($bannerSet) : $bannerSet;
        return view("service.banner_service", $data);
    }

}
