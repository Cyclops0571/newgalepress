<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Models\Application;
use App\Models\Tab;
use eStatus;
use Illuminate\Http\Request;
use Subscription;
use Validator;

class ApplicationSettingController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param Application $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {


        $this->detailCaption = __('common.application_settings_caption_detail');
        $tabs = $application->Tabs();
        for ($i = 0; $i < TAB_COUNT; $i++) {
            if (!isset($tabs[$i])) {
                $tabs[] = new Tab();
            }
        }

        $galepressTabs = Tab::getGalepresTabs();
        $data = array(
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->detailCaption,
            'application' => $application,
            'tabs' => $tabs,
            'galepressTabs' => $galepressTabs
        );
        return view('pages.applicationsetting', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param MyResponse $myResponse
     * @return \Illuminate\Http\Response|string
     */
    public function update(Request $request, MyResponse $myResponse)
    {
        $rules = array(
            "ThemeForegroundColor" => 'regex:/^#[A-Fa-f0-9]{6}$/'
        );

        $v = Validator::make($request->all(), $rules);
        if (!$v->passes()) {
            $errMsg = $v->errors()->first();

            return $myResponse->error($errMsg);
        }

        $application = Application::find((int)$request->get("ApplicationID", 0));
        if (!$application || !$application->CheckOwnership()) {
            return $myResponse->error(__('error.unauthorized_user_attempt'));
        }

        $application->ThemeBackground = (int)$request->get("ThemeBackground", 1);
        $application->ThemeForegroundColor = $request->get("ThemeForegroundColor");
        $application->TabActive = (int)$request->get("TabActive", 0);
        $application->ShowDashboard = (int)$request->get('ShowDashboard', 0);
        $application->ConfirmationMessage = $request->get("ConfirmationMessage", '');

        $tabs = $application->Tabs();
        for ($i = 0; $i < TAB_COUNT; $i++) {
            if (!isset($tabs[$i])) {
                $tabs[] = new Tab();
            }
            $j = $i + 1;
            $tabs[$i]->ApplicationID = $application->ApplicationID;
            $tabs[$i]->TabTitle = $request->get("TabTitle_" . $j, 'Başlık ' . $j);
            $tabs[$i]->Url = $request->get("Url_" . $j, '');
            $tabs[$i]->InhouseUrl = $request->get("InhouseUrl_" . $j, '');
            $tabs[$i]->IconUrl = $request->get("hiddenSelectedIcon_" . $j, '/img/app-icons/1.png');
            $tabs[$i]->Status = (int)$request->get("TabStatus_" . $j, 0);
            $tabs[$i]->StatusID = eStatus::Active;
            $tabs[$i]->save();
        }

        if ($application->InAppPurchaseActive) {
            $application->IOSHexPasswordForSubscription = $request->get('IOSHexPasswordForSubscription', '');
            foreach (Subscription::types() as $key => $subscription) {
                $application->subscriptionStatus($key, $request->get("SubscriptionStatus_" . $key));
            }
        }

        if ($application->isClean()) {
            $application->incrementAppVersion();
        } else {
            $application->save();
        }

        return $myResponse->success();
    }
}
