@extends('layouts.master')

@section('content')
<?php
$appLink = (int)request('applicationID', 0) > 0 ? '&applicationID=' . request('applicationID', 0) : '';
$searchLink = '&search=' . $search;
$sortDirLink = '&sort_dir=' . ($sort_dir == 'DESC' ? 'ASC' : 'DESC');
?>

        <!--<form id="list">-->
<div class="col-md-12">
    <div class="block bg-light-ltr">
        <div class="content controls bg-light-rtl">
            <!-- Commandbar Start-->
            <div class="form-row ">
                <div class="col-md-5" style="padding-top:5px; float:left;">
                    <div class="input-group commands">
                        <a href="{{route($page.'_new', ['applicationID' => request('applicationID', 0) ] )}}"
                           title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle">
                            <span class="icon-map-marker location-icon-map-stacked">
                                <i class="icon-plus location-icon-plus-stacked"></i>
                            </span>
                        </a>
                        <a href="#modalMapsList" data-toggle="modal" data-target="#modalMapsList"
                           title="{{__('common.map_preview')}}"
                           class="widget-icon widget-icon-circle">
                            <span class="icon-map-marker location-icon-triplet-first"></span>
                            <span class="icon-map-marker location-icon-triplet-second"></span>
                            <span class="icon-map-marker location-icon-triplet-third"></span>
                        </a>
                        <a href='<?php echo GoogleMap::getSampleXmlUrl(); ?>' download='SampleMapExcel.xls'
                           title="{{__('common.commandbar_excel_download')}}" class="widget-icon widget-icon-circle">
                            <span class="icon-download" style="font-size: 15px;"></span>
                        </a>

                        <!--excel file upload commandbar_excel_add-->
                        <input type="file" name="File" class="btn btn-mini hidden" id="File" style="opacity:0;"/>
                        <a id='FileButton' for='File' href="javascript:void(0)"
                           title="{{__('common.commandbar_excel_upload')}}" class="widget-icon widget-icon-circle">
                            <span class="icon-upload" style="font-size: 15px;"></span>
                        </a>
                        <script>
                            var ApplicationID = <?php echo request('applicationID', 0); ?>;
                            cCommon.fileUploadInit('/maps/excelupload/' + ApplicationID,
                                    function (response) {
                                        if (response.responseMsg.length) {
                                            cNotification.success(response.responseMsg);
                                        } else {
                                            cNotification.success();
                                        }
                                        window.location = '/' + currentLanguage + '/' + route["maps"] + '?applicationID=' + ApplicationID;
                                    });
                        </script>
                    </div>
                </div>

                <div class="col-md-4 commandbar-search">

                    <form method="get" action="{{$route}}">
                    {{ Form::hidden('page', '1') }}
                    {{ Form::hidden('sort', request('sort', $pk)) }}
                    {{ Form::hidden('sort_dir', request('sort_dir', 'DESC')) }}
                    {{ Form::hidden('applicationID', request('applicationID', '0')) }}
                    <div class="input-group">
                        <div class="input-group-addon"><span class="icon-search"></span></div>
                        <input class="form-control" name="search" value="{{ request('search', '') }}" type="text">
                        <input type="submit" class="btn hidden" value="{{ __('common.commandbar_search') }}"/>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Commandbar End-->
            <div class="form-row">
                <div class="col-md-12">
                    <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%"
                           class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <?php foreach ($fields as $field): ?>
                            <?php $sortLink = '&sort=' . $field[1]; ?>
                            <?php $sort == $field[1] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array(); ?>
                            <th scope="col">{{ Html::link($route.'?page=1'. $appLink  . $searchLink . $sortLink . $sortDirLink, $field[0], $sort) }}</th>
                            <?php endforeach; ?>
                            <th scope="col" class="text-center">{{ __('common.detailpage_delete') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rows->results as $row)
                            @if((int)Auth::user()->UserTypeID == eUserTypes::Manager)
                                <tr class="{{ Common::htmlOddEven($page) }}"
                                    id="googleMapIDSet_<?php echo $row->GoogleMapID?>">
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->CustomerName) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->ApplicationName) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Name) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Latitude) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Longitude) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->GoogleMapID) }}</td>
                                    <td class="text-center">
                                        <a href="#" onclick="cGoogleMap.delete(<?php echo $row->GoogleMapID; ?>)">
                                            <span class="icon-remove-sign"></span>
                                        </a>
                                    </td>
                                </tr>
                            @elseif((int)Auth::user()->UserTypeID == eUserTypes::Customer)
                                <tr class="{{ Common::htmlOddEven($page) }}"
                                    id="googleMapIDSet_<?php echo $row->GoogleMapID?>">
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Name) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Address) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Description) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Latitude) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->Longitude) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->GoogleMapID, $row->GoogleMapID) }}</td>
                                    <td class="text-center">
                                        <a href="#" onclick="cGoogleMap.delete(<?php echo $row->GoogleMapID; ?>)">
                                            <span class="icon-remove-sign"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td class="select">&nbsp;</td>
                                <td colspan="{{ count($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end tabular_content-->
        <script type="text/javascript">
            $(function () {
                $("div.pagination ul").addClass("pagination");
            });
        </script>
        <!-- end select-->
    </div>
</div>
<!--</form>-->
@endsection