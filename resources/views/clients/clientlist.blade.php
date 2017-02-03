@layout('layouts.master')

@section('content')
        <!--<form id="list">-->
<div class="col-md-12">
    <div class="block bg-light-ltr">
        <div class="content controls bg-light-rtl">
            <div class="form-row ">
                <!--commanbar start-->
                <div class="col-md-5" style="padding-top:5px; float:left;">
                    <div class="input-group commands">
                        <a href="{{URL::to(__('route.'.$page.'_new'))}}" title="{{__('common.commandbar_add')}}"
                           class="widget-icon widget-icon-circle">
                            <span class="icon-plus-sign" style="font-size: 20px;"></span>
                        </a>
                        <!--excel sample file download-->
                        <a href='<?php echo Client::getSampleXmlUrl(); ?>' download='SampleClientExcel.xls'
                           title="{{__('common.commandbar_excel_download')}}" class="widget-icon widget-icon-circle">
                            <span class="icon-my-download" style="font-size: 20px;"></span>
                        </a>

                        <!--excel file upload commandbar_excel_add-->
                        <input type="file" name="File" class="btn btn-mini hidden" id="File" style="opacity:0;"/>
                        <a id='FileButton' for='File' href="javascript:void(0)"
                           title="{{__('common.commandbar_excel_upload')}}" class="widget-icon widget-icon-circle">
                            <span class="icon-my-upload" style="font-size: 20px;"></span>
                        </a>
                        <script>
                            cCommon.fileUploadInit(
                                    '/clients/excelupload',
                                    function (response) {
                                        cNotification.success(response.responseMsg);
                                        window.location = '/' + currentLanguage + '/' + route["clients"];
                                    }
                            );
                        </script>

                    </div>
                </div>
                <div class="col-md-4" style="float:right; max-width:300px;">
                    {{ Form::open($route, 'GET') }}
                    {{ Form::hidden('page', '1') }}
                    {{ Form::hidden('sort', Input::get('sort', $pk)) }}
                    {{ Form::hidden('sort_dir', Input::get('sort_dir', 'DESC')) }}
                    {{ Form::hidden('applicationID', Input::get('applicationID', '0')) }}
                    <div class="input-group">
                        <div class="input-group-addon"><span class="icon-search"></span></div>
                        <input class="form-control" name="search" value="{{ Input::get('search', '') }}" type="text">
                        <input type="submit" class="btn hidden" value="{{ __('common.commandbar_search') }}"/>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%"
                           class="table table_main table-bordered table-striped table-hover">
                        <?php
                        $appQS = ((int)Input::get('ApplicationID', 0) > 0 ? '&ApplicationID=' . Input::get('ApplicationID', 0) : '');
                        $searchQS = '&search=' . $search;
                        $sortDirection = '&sort_dir=' . ($sort_dir == 'DESC' ? 'ASC' : 'DESC');
                        $classUp = array('class' => 'sort_up');
                        $classDown = array('class' => 'sort_down');
                        ?>
                        <thead>
                        <tr>
                            <?php for ($i = 1; $i < count($fields); $i++): ?>
                            <th scope="col">
                                <?php $attributes = ($sort == $fields[$i][2]) ? ($sort_dir == 'ASC' ? $classUp : $classDown) : array(); ?>
                                <?php $sortQS = '&sort=' . $fields[$i][2]; ?>
                                <?php echo HTML::link($route . '?page=1' . $appQS . $searchQS . $sortQS . $sortDirection, $fields[$i][1], $attributes); ?>
                            </th>
                            <?php endfor; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($rows)): ?>
                        <?php foreach ($rows->results as $row): ?>
                        <?php /* @var $row Client */ ?>
                        <tr class="{{ HTML::oddeven($page) }}">
                            <td><?php echo HTML::link($route . '/' . $row->ClientID, $row->Username); ?> </td>
                            <td><?php echo HTML::link($route . '/' . $row->ClientID, $row->Name); ?> </td>
                            <td><?php echo HTML::link($route . '/' . $row->ClientID, $row->Surname); ?> </td>
                            <td><?php echo HTML::link($route . '/' . $row->ClientID, $row->Email); ?> </td>
                            <td><?php echo HTML::link($route . '/' . $row->ClientID, $row->Application->Name); ?> </td>
                            <td><?php echo HTML::link($route . '/' . $row->ClientID, Common::dateRead($row->LastLoginDate, 'd.m.Y')); ?> </td>
                            <td><?php echo HTML::link($route . '/' . $row->ClientID, $row->ClientID); ?> </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td class="select">&nbsp;</td>
                            <td colspan="{{ count($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
                        </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- end tabular_content-->
            <div class="select">
                @if((int)Input::get('customerID', 0) > 0)
                    {{ $rows->appends(array('customerID' => Input::get('customerID', 0), 'search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
                @else
                    {{ $rows->appends(array('search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
                @endif
            </div>
            <script type="text/javascript">
                $(function () {
                    $("div.pagination ul").addClass("pagination");
                });
            </script>
            <!-- end select-->
        </div>
    </div>
</div>
<!--</form>-->
@endsection