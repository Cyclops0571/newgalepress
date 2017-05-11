<?php
use App\Models\Application;$title = config('custom.companyname');
$reportLinks = array(101, 201, 301, 302, 1001, 1101, 1201, 1301, 1302);
?>

<div class="page-navigation-panel">
  @if(mb_strlen($title) < 17)
    <div class="name">{{ __('common.welcome') }}, {{ $title }}</div>
  @else
    <div class="name">{{ __('common.welcome') }},<br/> {{ $title }}</div>
  @endif
  <div class="control"><a href="#" class="psn-control"><span class="icon-reorder" style="color:#1681bf;"></span></a>
  </div>
</div>
@if(Auth::user()->UserTypeID == eUserTypes::Customer)
    <?php
    /** @var Application[] $applicationSet */
    $applicationSet = Auth::user()->Customer->Application;
    $reportLinks = array(1001, 1301, 1302);
    $customer = Auth::user()->Customer;
    $title = Auth::user()->FirstName . " " . Auth::user()->LastName;
    $showPaymentLink = false;
    $showInAppPuchaseLink = false;

    foreach ($applicationSet as $app) {
        if ($app->Price > 0) {
            $showPaymentLink = true;
        }
        if ($app->InAppPurchaseActive) {
            $showInAppPuchaseLink = true;
        }
    }
    ?>
    <ul class="page-navigation bg-light">
      <li>
        <a href="{{  route('home') }}"><span class="icon-home"></span>{{ __('common.home') }}</a>
      </li>
      <li>
        @if(count($applicationSet) == 1)
          <a href="{{route('contents_list', ['applicationID' => $applicationSet[0]->ApplicationID])}}" {{$applicationSet[0]->sidebarClass(true)}}>
            <span class="icon-dropbox"></span>{{ $applicationSet[0]->Name }}
          </a>
        @else
          <a href="#"><span class="icon-dropbox"></span>{{ __('common.menu_caption_applications') }}</a>
          <ul id="allApps">
              <?php foreach ($applicationSet as $app): ?>
            <li class="full-width">
                <?php echo Html::link(__('route.contents') . '?applicationID=' . $app->ApplicationID, $app->Name, $app->sidebarClass()); ?>
            </li>
              <?php endforeach; ?>
          </ul>
        @endif
      </li>
      <li>
        <a href="#"><span class="icon-file-text-alt"></span> {{ __('common.menu_caption_reports') }}</a>
        <ul id="allReports">
            @foreach($reportLinks as $reportLink)
                <a href="{{__('route.reports') . '?r=' . $reportLink}}" >{{__('common.menu_report_' . $reportLink)}}</a>
            @endforeach
      </li>
        </ul>
        <li>
        <a href="{{route('common_mydetail_get')}}"><span class="icon-user"></span>{{ __('common.menu_mydetail') }}
        </a>
      </li>
      <li>
        @if(count($applicationSet) == 1)
          <a href="{{route('application_setting', $applicationSet[0]->ApplicationID)}}">
            <span class="icon-cogs"></span>{{__('common.application_settings_caption_detail')}}
          </a>
        @else
          <a href="#"><span class="icon-cogs"></span>{{__('common.application_settings_caption_detail')}}</a>
          <ul id="allSettings">
              <?php foreach ($applicationSet as $app): ?>
            <li style="width:100%;">
                <?php echo Html::link(route('application_setting', $app->ApplicationID)); ?>
            </li>
              <?php endforeach; ?>
          </ul>
        @endif
      </li>
      @if($showInAppPuchaseLink)
        <li>
          <a href="{{route('clients_list')}}">
            <span class="icon-mobile-phone"></span><?php echo __('common.client_list') ?>
          </a>
        </li>
      @endif
      @if($showPaymentLink)
        <li>
          <a href="{{route('payment_shop')}}"><span
                class="icon-credit-card"></span>{{ __('common.application_payment') }}</a>
        </li>
      @endif
      <li>
        <a href="{{__('common.tutorial_link')}}" target="_blank">
          <span class="icon-question-sign"></span> {{__('common.tutorial')}}
        </a>
      </li>
    </ul>
@else
  <ul class="page-navigation bg-light">
    <li>
      <a href="{{route('home')}}"><span class="icon-home"></span>{{ __('common.home') }}</a>
    </li>
    <li>
      <a href="{{route('managements_list')}}"><span
            class="icon-wrench"></span>{{ __('common.management') }}</a>
    </li>
    <li>
      <a href="#"><span class="icon-sitemap"></span> {{ __('common.menu_caption') }}</a>
      <ul>
          <a href="{{__('route.customers')}}" >{{__('common.menu_customers')}}</a>
          <a href="{{__('route.applications')}}" >{{__('common.menu_applications')}}</a>
          <a href="{{__('route.contents')}}" >{{__('common.menu_contents')}}</a>
          <a href="{{__('route.orders')}}" >{{__('common.menu_orders')}}</a>
      </ul>
    </li>
    <li>
      <a href="#"><span class="icon-file-text-alt"></span> {{ __('common.menu_caption_reports') }}</a>
      <ul id="allReports">
          @foreach($reportLinks as $reportLink)
              <a href="{{__('route.reports') . '?r=' . $reportLink}}" >{{__('common.menu_report_' . $reportLink)}}</a>
            @endforeach
      </ul>
    </li>
    <li>
      <a href="#"><span class="icon-user"></span>Kullanıcı Ayarları</a>
      <ul>
          <a href="{{__('route.users')}}" >{{__('common.menu_users')}}</a>
          <a href="{{__('route.mydetail')}}" >{{__('common.menu_mydetail')}}</a>
      </ul>
    </li>
    <li>
      <a href="{{route('common_mydetail_get')}}"><span class="icon-user"></span>{{ __('common.menu_mydetail') }}
      </a>
    </li>
  </ul>
@endif



<script type="text/javascript">
    var reportLinks = <?php echo json_encode($reportLinks); ?>;
    var contentsUrl = '<?php echo __('route.contents'); ?>';
    var applicationSettingRoute = '{{route('application_setting', '::num::')}}';
    var bannersController = "<?php echo __("route.banners"); ?>";
    var mapsController = "<?php echo __("route.maps"); ?>";

    function getURLParameter(url, name) {
        return (RegExp(name + '=' + '(.+?)(&|$)').exec(url) || [, null])[1];
    }

    $(function () {
        var reportUrl = window.location.href;
        var reportUrlParams = reportUrl.split("?");
        for (var i = 0; i < reportLinks.length; i++) {
            if (reportUrlParams[1] === "r=" + reportLinks[i]) {
                $('ul#allReports li:eq(' + i + ') a').attr('class', 'visited');
                $(".page-navigation ul#allReports").prev().trigger('click');
            }
        }
        var applicationSettingRouteExp = applicationSettingRoute.replace("::num::", "\\d+");
        var appID = parseInt($("input[name$='pplicationID']").val());
        if (!(appID > 0)) {
            return;
        }
        if (window.location.href.indexOf(bannersController) > -1 || window.location.href.indexOf(mapsController) > -1 || window.location.href.match(new RegExp(applicationSettingRouteExp, "i"))) {
            $(".page-navigation ul#allSettings li a").each(function (index) {
                var match = $(this).attr('href').match(/\d+/);
                if (match.length > 0 && parseInt(match[0]) === appID) {
                    $(this).attr('class', 'visited');
                    return false;
                }
            });
            $(".page-navigation ul#allSettings").prev().trigger('click');
        } else {
            $(".page-navigation ul#allApps li a").each(function (index) {
                if (parseInt(getURLParameter($(this).attr('href'), 'applicationID')) === appID) {
                    $(this).attr('class', 'visited');
                    return false;
                }
            });
            $(".page-navigation ul#allApps").prev().trigger('click');
        }
    });
</script>