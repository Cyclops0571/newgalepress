@extends('layouts.master')

@section('content')
    <div class="container" id="dashboard">
        <div class="row">
            <div class="col-md-9">
                <!--TOTAL DOWNLOAD CHART START-->
                <div class="col-md-12">
                    <div class="block block-drop-shadow">
                        <div class="head bg-default">
                            <h2>{{ __('common.dashboard_title') }}</h2>
                        <span class="hp-info pull-right">
			    <?php echo Common::monthName((int)date('m', strtotime("$date"))) . ' ' . date('Y', strtotime("$date")); ?>
                        </span>

                            <div class="head-panel nm">
                                <div class="left_abs_100 reportSubtitle"
                                     style="margin-top: 70px; text-align:center; font-size: 11px;">
                                    {{ __('common.dashboard_today') }}
                                </div>
                                <div class="left_abs_100" style="margin-top: 20px; text-align:center;">
                                    <div class="knob">
                                        <input id="myKnob" type="text" data-fgColor="#FFFFFF" data-min="0"
                                               data-value="{{ $downloadTodayTotalData }}"
                                               data-max="{{ $downloadTodayTotalData }}" data-width="100"
                                               data-height="100" data-readOnly="true"/>
                                    </div>
                                </div>
                                <br/>

                                <div class="chart" id="dash_chart_1" data="{{ $downloadStatistics }}"
                                     maxdata="{{ $downloadMaxData }}" columns="{{ $columns }}"
                                     labelTitle="{{ __('common.dashboard_title') }}"
                                     style="height: 165px; padding:1px !important; position: static !important;"></div>
                            </div>
                            <div class="head-panel nm">
                                <div class="hp-info pull-left">
                                    <div class="hp-icon">
                                        <span class="icon-download-alt"></span>
                                    </div>
                                    <span class="hp-main" id="myKnobText">&nbsp;{{ $downloadTotalData }}</span>
                                    <span class="hp-sm">&nbsp; {{ __('common.dashboard_weekly_total') }}</span>
                                </div>
                                <div class="hp-info pull-right">
                                    <div class="hp-icon">
                                        <span class="icon-cloud-download"></span>
                                    </div>
                                    <span class="hp-main">&nbsp;{{ $downloadMonthTotalData }}</span>
                                    <span class="hp-sm">&nbsp;{{ Common::monthName((int)date('m')).' '.date('Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--TOTAL DOWNLOAD CHART START-->

                <!--DEVICE USAGE GRAPHIC START-->
                <div class="col-md-7">
                    <div class="block block-drop-shadow">
                        <div class="head bg-dot30">
                            <h2>{{ __('common.reports_graph') }}</h2>

                            <div class="head-panel nm">
                                <div class="chart" id="dash_chart_2" ios='{{ $iosDeviceDownload }}'
                                     android='{{ $androidDeviceDownload }}' columns='{{ $deviceColumns }}'
                                     style="height: 150px;"></div>
                            </div>
                        </div>
                        <div class="head bg-dot30">
                            <div class="head-panel nm">
                                <div class="hp-info pull-left">
                                    <div class="hp-icon">
                                        <span class="icon-globe"></span>
                                    </div>
                                <span class="hp-main">
				    <?php
                                    /*
                                      $devicesTotalDownload = 0;
                                      foreach ($previousMonths as $month) {
                                      $devicesTotalDownload += $month->DownloadCount;
                                      }
                                      echo $devicesTotalDownload;
                                     */
                                    echo (int)$iosTotalDownload + (int)$androidTotalDownload;
                                    ?>
                                </span>
                                    <span class="hp-sm">{{ __('common.dashboard_total') }}</span>
                                </div>
                                <div class="hp-info pull-left">
                                    <div class="hp-icon">
                                        <span class="icon-apple"></span>
                                    </div>
                                    <span class="hp-main" style="margin-left: 35px;">{{ $iosTotalDownload }}</span>
                                    <span class="hp-sm" style="margin-left: 35px;">iOS</span>
                                </div>
                                <div class="hp-info pull-left">
                                    <div class="hp-icon">
                                        <span class="icon-android"></span>
                                    </div>
                                    <span class="hp-main" style="margin-left: 35px;">{{ $androidTotalDownload }}</span>
                                    <span class="hp-sm" style="margin-left: 35px;">Android</span>
                                </div>
                            </div>
                        </div>
                        <div class="head bg-dot30">
                            <h2 style="text-transform:none;">{{ __('common.reports_graph_ratio') }}</h2>

                            <div class="head-panel nm">
                                <div class="progress">
                                    <?php
                                    $iosTotalDownloadPercent = 0;
                                    $androidTotalDownloadPercent = 0;

                                    if ($iosTotalDownload + $androidTotalDownload > 0) {
                                        $iosTotalDownloadPercent = ($iosTotalDownload / ($iosTotalDownload + $androidTotalDownload)) * 100;
                                        $androidTotalDownloadPercent = ($androidTotalDownload / ($iosTotalDownload + $androidTotalDownload)) * 100;
                                    }
                                    ?>
                                    <div class="progress-bar progress-bar-success tip" title="iOS"
                                         style="width: {{$iosTotalDownloadPercent}}%; background:#cecece"><span
                                                style="color:black !important;"><?php echo round($iosTotalDownloadPercent, 2) . "%" ?></span>
                                    </div>
                                    <div class="progress-bar progress-bar-info tip" title="Android"
                                         style="width: {{$androidTotalDownloadPercent}}%; background:#a4c739"><span
                                                style="color:black;"><?php echo round($androidTotalDownloadPercent, 2) . "%" ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--DEVICE USAGE GRAPHIC END-->
                <!--PREVIOUS MONTHS START-->
                <div class="col-md-5">
                    <div class="block block-drop-shadow">
                        <div class="content list">
                            <div class="list-title">{{ __('common.dashboard_previous_months') }}</div>
                            @foreach ($previousMonths as $month)
                                <div class="list-item">
                                    <div class="list-text">
                                        <div class="col-md-10">
                                            <strong>{{ $month->Year }} {{ Common::monthName($month->Month) }}</strong>
                                            <span class="monthlyPer">{{$month->DownloadCount}}
                                                / {{ $previousMonthsMaxData }}</span><span
                                                    class="icon-cloud-download"></span>

                                            <div class="progress progress-small">
                                                <div class="progress-bar progress-bar-info previous-month"
                                                     role="progressbar" aria-valuemin="0"
                                                     aria-value="{{ (int)((int)$month->DownloadCount * 100 / ($previousMonthsMaxData == 0 ? 1 : $previousMonthsMaxData)) }}"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="head-panel nm">
                                                <div class="hp-info monthlyDown tac">
                                                    <span>{{ __('common.dashboard_total') }}</span>
                                                    <span>{{ $month->DownloadCount }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="footer footer-defaut tac hide">
                                <div class="pull-left" style="width: 200px;">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar"></span></div>
                                        <input type="text" class="datepicker form-control" value="10/08/2013"/>

                                        <div class="input-group-btn">
                                            <button class="btn" style="line-height:27px;"><span
                                                        class="icon-search"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <a href="#" id="monthHideBtn"><span id="monthHideIcon"
                                                                        class="icon-chevron-up"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--PREVIOUS MONTHS END-->
                <div class="block block-drop-shadow bg-light-rtl">
                    <!-- Anasayfada sayfanın sağında çıkan filtrelemeyle ilgili açılır kapanır bölüm. -->
                    <div class="site-settings">
                        <div class="site-settings-button"><span class="icon-cog"></span></div>
                        <div class="site-settings-content">
                            <div class="block block-transparent nm filterBlock">
                                <div class="header">
                                    <h2>{{ __('common.dashboard_filter') }}</h2>
                                </div>
                                <div class="content controls reportSubtitle">
                                    <form method="get">
                                        <div class="form-row">
                                            <div class="col-md-4">{{ __('common.dashboard_app') }}</div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><span class="icon-dropbox"></span>
                                                    </div>
                                                    <select class="form-control select2" id="ddlApplication"
                                                            name="ddlApplication"
                                                            onChange="cContent.loadContentOptionList();">
                                                        @foreach ($applications as $application)
                                                            <option value="{{ $application->ApplicationID }}"{{ ($applicationID == (int)$application->ApplicationID ? ' selected="selected"' : '') }}>{{ $application->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4">{{ __('common.dashboard_content') }}</div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><span class="icon-cloud"></span>
                                                    </div>
                                                    <select class="form-control select2" id="ddlContent"
                                                            name="ddlContent">
                                                        <option value=""{{ ($contentID == 0 ? ' selected="selected"' : '') }}>{{ __('common.reports_select_content') }}</option>
                                                        <?php
                                                        $contents = DB::table('Content')
                                                                ->where('ApplicationID', '=', $applicationID)
                                                                ->where('StatusID', '=', eStatus::Active)
                                                                ->order_by('Name', 'ASC')
                                                                ->get();
                                                        ?>
                                                        @foreach($contents as $content)
                                                            <option value="{{ $content->ContentID }}"{{ ($contentID == (int)$content->ContentID ? ' selected="selected"' : '') }}>{{ $content->Name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4">{{ __('common.dashboard_begin_date') }}</div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><span class="icon-calendar"></span>
                                                    </div>
                                                    <input type="text" id="date" name="date"
                                                           class="datepicker form-control"
                                                           value="{{ Common::dateRead($date, 'd.m.Y') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-5" style="float:right;">
                                                <input class="btn btn-mini" type="submit"
                                                       value="{{ __('common.dashboard_refresh') }}">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block bg-light" id="my-info-block">
                    <div class="head">
                        <h2>{{__('common.users_caption_detail')}}</h2>

                        <div class="side pull-right">
                            <ul class="buttons">
                                <li><span class="icon-user" style="color:#1681bf; font-size:16px;"></span></li>
                            </ul>
                        </div>
                        <div class="head-panel nm" style="border-top: 1px solid">
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="icon-user"></span>&nbsp;{{__('common.statistics_user')}}&nbsp;<span
                                        class="reportSubtitle">{{ Auth::user()->Username; }}</span>
                            </div>
                            <?php
                            /* @var $s Sessionn */
                            $s = Auth::user()->Session(1, 1);
                            $lastLoginDate = '';
                            $lastLoginTime = '';
                            if ($s) {
                                $lastLoginDate = Common::dateRead($s->LocalLoginDate, 'd.m.Y');
                                $lastLoginTime = Common::dateRead($s->LocalLoginDate, 'H:i');
                            }
                            ?>
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="icon-calendar"></span>&nbsp;{{__('common.statistics_lastlogin')}}
                                &nbsp;<span class="reportSubtitle">{{ $lastLoginDate }}</span>
                            </div>
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="icon-time"></span>&nbsp;{{__('common.dashboard_lastlogin_time')}}
                                &nbsp;<span class="reportSubtitle">{{ $lastLoginTime }}</span>
                            </div>
                        </div>
                        <div class="block userBlock">
                            <div class="user">
                                <div class="info" style="text-align:center">
                                    <div class="informer informer-three">
                                        <span>{{ $applicationCount; }}</span>
                                        {{ __('common.dashboard_app_count') }}
                                    </div>
                                    <div class="informer informer-four">
                                        <span>{{ $contentCount; }}</span>
                                        {{ __('common.dashboard_content_count') }}
                                    </div>
                                    <span class="icon-dropbox usrBlckIcnDrpbx"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block bg-light" id="my-info-block">
                    <div class="head">
                        <h2>{{__('common.applications_caption_detail')}}</h2>

                        <div class="side pull-right">
                            <ul class="buttons">
                                <li><span class="icon-dropbox" style="color:#1681bf; font-size:16px;"></span></li>
                            </ul>
                        </div>
                        <div class="head-panel nm" style="border-top: 1px solid">
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="icon-dropbox"></span>&nbsp;{{__('common.applications_applicationname')}}
                                &nbsp;<span class="reportSubtitle">{{ $appDetail->Name }}</span>
                            </div>
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="icon-calendar"></span>&nbsp;{{__('common.header_enddate')}}&nbsp;<span
                                        class="reportSubtitle">{{ Common::dateRead($appDetail->ExpirationDate, 'd.m.Y'); }}</span>
                            </div>
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="icon-thumbs-up"></span>&nbsp;{{__('common.header_status')}}&nbsp;<span
                                        class="reportSubtitle">
				<?php
                                    $languageID = (int)Session::get('language_id');
                                    $applicationStatusName = $appDetail->ApplicationStatus($languageID);
                                    $applicationStatusName = (strlen(trim($applicationStatusName)) == 0 ? __('common.header_upload') : $applicationStatusName);
                                    echo $applicationStatusName;
                                    ?>
                            </span>
                            </div>
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left hp-inline" style="text-align:center;">
                                <div style="float:left;" id="startDate"
                                     value="{{ Common::dateRead($appDetail->StartDate, 'Y-m-d'); }}">{{ Common::dateRead($appDetail->StartDate, 'd.m.Y'); }}</div>
                                <div style="float:right;" id="endDate"
                                     value="{{ Common::dateRead($appDetail->ExpirationDate, 'Y-m-d'); }}">{{ Common::dateRead($appDetail->ExpirationDate, 'd.m.Y'); }}</div>
                                <span id="datePerValue"></span>

                                <div class="hp-sm">
                                    <div class="progress progress-small">
                                        <div class="progress-bar progress-bar-danger" id="appProgress"
                                             role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <?php
    $expiringApps = Application::where('CustomerID', '=', $customerID)
            ->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
            ->where('StatusID', '=', 1)
            ->get();

    $currentDate = date("Y-m-d");
    $expiringAppCount = 0;
    ?>
    @foreach($expiringApps as $expApp)
        <?php
        $date1 = new DateTime($expApp->ExpirationDate);
        $date2 = new DateTime($currentDate);
        $diff = $date1->diff($date2);
        ?>
        @if($diff->days<15)
            <?php $expiringAppCount++; ?>
            <div class="modal in " id="popupContact{{ $expiringAppCount }}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; z-index:9999 !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><span
                                        class="icon-warning-sign"></span>&nbsp;&nbsp;&nbsp;{{ __('common.site_system_message') }}
                            </h4>
                        </div>
                        <div class="modal-body clearfix">
                            <div class="modal-body"><?php echo $expApp->getExpireTimeMessage(); ?><span id="dialogText-warning"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <script type="text/javascript">
        $(document).ready(function () {
            for (var i = 1; i <= {{$expiringAppCount}}; i++) {
                $('#popupContact' + i).modal('show');
            }
            ;
        });
    </script>





@endsection