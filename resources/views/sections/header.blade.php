<?php
/*
$title = Config::get('custom.companyname');

if((int)Auth::user()->UserTypeID == eUserTypes::Customer)
{
    $customer = Auth::user()->Customer;
    
    $title = $customer->CustomerName;
}
?>
<div id="header">
    <div id="logo">
        <h1>{{ HTML::link(__('route.home'), __('common.home')) }}</h1>
    </div>
    <!-- end logo-->
    <div id="site_info">
        <h3>{{ $title }}</h3>
    </div>
    <!-- end site_info-->
    <div id="date">
        @if((int)Auth::user()->UserTypeID == eUserTypes::Customer)
            <?php
            $applicationID = (int)Input::get('applicationID', 0);
            
            if(Common::CheckApplicationOwnership($applicationID))
            {
                $s = Application::where('ApplicationID', '=', $applicationID)
                    ->where('CustomerID', '=', $customer->CustomerID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();
                
                if($s)
                {   
                    $applicationName = $s->Name;
                    $applicationExpirationDate = Common::dateRead($s->ExpirationDate, 'd.m.Y');
                    $applicationStatusName = $s->ApplicationStatus();
                    $applicationStatusName = (strlen(trim($applicationStatusName)) == 0 ? __('common.header_upload') : $applicationStatusName);
                    
                    echo '<span>'.__('common.header_application').'<strong>'.$applicationName.'</strong></span>';
                    echo '<span>'.__('common.header_enddate').'<em>'.$applicationExpirationDate.'</em></span>';
                    echo '<span>'.__('common.header_status').'<em>'.$applicationStatusName.'</em></span>';
                }
            }
            ?>
        @endif

        {{-- HTML::link_to_language('tr', 'Turkish version') --}}
        {{-- HTML::link_to_language('en', 'English version') --}}

    </div>
    <!-- end date-->
</div>
<!-- end header-->
*/
?>
<div id="header-background"></div>
<nav class="navbar brb" role="navigation">
    <div class="col-md-2">
        <a href="{{URL::to(__('route.home'))}}" style="line-height:55px; float:left;"><img src="/img/myLogo4.png"/></a>
    </div>

    <?php
    /*
    <a href="/tr">TR</a>
    <a href="/en">EN</a>

    <input type="radio" value="tr" name="lang-tr" onclick="document.location='/tr'">
    <label for="lang-tr">TR</label>

    <br>

    <input type="radio" value="en" name="lang-en" onclick="document.location='/en'">
    <label for="lang-en">EN</label>
    */
    ?>

    <div id='cssmenu' style="float:right;">
        <ul>
            <!--
            <li class='active' id="tr"><a href='index.html'></a></li>
            <li id="en"><a href='#'></a></li>
            -->
            <?php if(count(Config::get('application.languages')) > 1): ?>
            <li id="lang-settings"><a href="#modalChangeLanguage" onclick="modalOpen()"></a></li>
            <?php endif; ?>
            <li class='last' id="logout"><a href="{{URL::to(__('route.logout'))}}"></a></li>
        </ul>
    </div>
</nav>
@if(isset($caption))
    <div class="myBreadCrumb">
        {{ $filterbar }}
    </div>
@endif
