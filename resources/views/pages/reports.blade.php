@extends('layouts.master')

@section('content')
    <div class="col-md-12">
        <div class="block bg-light-ltr">
            <div class="header">
                <h2>{{ __('common.reports_filter') }}</h2>
            </div>
            <div class="content controls reportSubtitle">
                <div class="form-row">
                    <input type="hidden" id="report" name="report" value="{{ $report }}" />
                    <div class="col-md-3">{{ __('common.reports_date') }}</div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-calendar"></span></div>
                            <input type="text" id="start-date" class="datepicker form-control"
                                   value="<?php echo Common::dateRead(date("d.m.Y", strtotime("- 1 Year")), 'd.m.Y'); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-calendar"></span></div>
                            <input type="text" id="end-date" class="datepicker form-control"
                                   value="<?php echo Common::dateRead(date("d.m.Y", strtotime("+1 Day")), 'd.m.Y'); ?>"/>
                        </div>
                    </div>
                </div> 
                <div class="form-row">
                    @if((int)Auth::user()->UserTypeID == eUserTypes::Manager)
                    <div class="col-md-3">{{ __('common.reports_customer') }}</div>
                    <div class="col-md-3">
                        <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ddlCustomer" name="ddlCustomer" onChange="cCustomer.CustomerOnChange($(this));">
                            <option value="0">{{ __('common.reports_select_customer') }}</option>
                        </select>
                    </div>
                    @else
                    <input type="hidden" id="ddlCustomer" name="ddlCustomer" value="{{ Auth::user()->CustomerID }}">
                     @endif
                </div> 
                <div class="form-row{{ ($report == "101" || $report == "1101" ? ' hidden' : '') }}">
                    <div class="col-md-3">{{ __('common.reports_application') }}</div>
                    <div class="col-md-3">
                        <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ddlApplication" name="ddlApplication" onChange="cApplication.ApplicationOnChange($(this));"{{ ($report == "101" || $report == "1101" ? ' disabled="disabled"' : '') }}>
                            <option value="0">{{ __('common.reports_select_application') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row{{ ($report == "101" || $report == "201" || $report == "1101" || $report == "1201" ? ' hidden' : '') }}">
                    <div class="col-md-3">{{ __('common.reports_content') }}</div>
                    <div class="col-md-3">
                        <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ddlContent" name="ddlContent" onChange="cContent.ContentOnChange($(this));"{{ ($report == "101" || $report == "201" || $report == "1101" || $report == "1201" ? ' disabled="disabled"' : '') }}>
                            <option value="0">{{ __('common.reports_select_content') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row{{ ($report == "101" || $report == "201" || $report == "301" || $report == "302" ? ' hidden' : '') }}">
                    <div class="col-md-3">{{ __('common.reports_location') }}</div>
                    <div class="col-md-3">
                        <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ddlCountry" name="ddlCountry" onChange="cReport.CountryOnChange($(this));"{{ ($report == "101" || $report == "201" || $report == "301" || $report == "302" ? ' disabled="disabled"' : '') }}>
                            <option value="">{{ __('common.reports_select_country') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ddlCity" name="ddlCity" onChange="cReport.CityOnChange($(this));"{{ ($report == "101" || $report == "201" || $report == "301" || $report == "302" ? ' disabled="disabled"' : '') }}>
                            <option value="">{{ __('common.reports_select_city') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ddlDistrict" name="ddlDistrict"{{ ($report == "101" || $report == "201" || $report == "301" || $report == "302" ? ' disabled="disabled"' : '') }}>
                            <option value="">{{ __('common.reports_select_district') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">             
                    <div class="col-md-offset-3 col-md-2">  
                        <input class="btn btn-mini" type="button" onClick="cReport.refreshReport();" value="{{ __('common.reports_refresh') }}">
                    </div>
                    <div class="col-md-3">
                        <input class="btn btn-mini" type="button" onClick="cReport.downloadAsExcel();" value="{{ __('common.reports_excel') }}">
                    </div>
                    <div class="col-md-3{{ ($report == "101" || $report == "201" || $report == "301" || $report == "302" || $report == "1001" || $report == "1302" ? ' hidden' : '') }}">
                        <input class="btn btn-mini" type="button" onClick="cReport.viewOnMap();" value="{{ __('common.reports_viewonmap') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="block bg-light-rtl data-placeholder">
            <div class="content controls">
                <div class="form-row">
                    <script type="text/javascript">
                    <!--
                    $(function(){							
                        <?php 
                        if((int)Auth::user()->UserTypeID == eUserTypes::Manager) {
                            echo 'cCustomer.loadCustomerOptionList();';
                            echo 'cReport.loadCountryOptionList();';
                        }
                        else {
                            echo 'cApplication.loadApplicationOptionList();';
                            echo 'cReport.loadCountryOptionList();';
                        }
                        ?>
                        cReport.refreshReport();
                    });
                    // -->
                    </script>
                    <div class="col-md-3 header"> 
                        <h2>&nbsp;&nbsp;{{ $reportName }}</h2>
                    </div>
        			<div class="form-row">
                        <iframe style="overflow:hidden; border-color:transparent; width:100%; height:100%; {{ ($report == "302" ? 'min-height:710px;' : '')}}"></iframe>
        			</div>
                </div>
            </div>
        </div>
    </div>
@endsection