@extends('layouts.master')

@section('content')
  <!--<form id="list">-->
  <div class="col-md-12">
    <div class="block bg-light-ltr">
      <div class="content controls bg-light-rtl">
        <div class="form-row ">
          <!--commanbar start-->
          <div class="col-md-5" style="padding-top:5px; float:left;">
            <div class="input-group commands">
              <a href="{{route('clients_new')}}" title="{{__('common.commandbar_add')}}"
                 class="widget-icon widget-icon-circle">
                <span class="icon-plus"></span>
              </a>
              <!--excel sample file download-->
              <a href='{{App\Models\Client::getSampleXmlUrl()}}' download='SampleClientExcel.xls'
                 title="{{__('common.commandbar_excel_download')}}" class="widget-icon widget-icon-circle">
                <span class="icon-cloud-download"></span>
              </a>

              <!--excel file upload commandbar_excel_add-->
              <input type="file" name="File" class="btn btn-mini hidden" id="File" style="opacity:0;"/>
              <a id='FileButton' for='File' href="javascript:void(0)" title="{{__('common.commandbar_excel_upload')}}"
                 class="widget-icon widget-icon-circle">
                <span class="icon-cloud-upload"></span>
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
        <div class="form-row">
          <div class="col-md-12">
            <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%"
                   class="table table_main table-bordered table-striped table-hover">
                <?php
                $appQS = ((int)request('ApplicationID', 0) > 0 ? '&ApplicationID=' . request('ApplicationID', 0) : '');
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
                      {!! "" !!}
                      <?php echo Html::link($route . '?page=1' . $appQS . $searchQS . $sortQS . $sortDirection, $fields[$i][1], $attributes); ?>
                  </th>
                    <?php endfor; ?>
                </tr>
              </thead>
              <tbody>
                @forelse ($rows as $row)
                      <?php /* @var $row App\Models\Client */ ?>
                  <tr class="{{ Common::htmlOddEven('clients') }}">

                    <td>{!! Html::link(route('clients_show', $row->ClientID), $row->Username) !!} </td>
                    <td>{!! Html::link(route('clients_show', $row->ClientID), $row->Name) !!} </td>
                    <td>{!! Html::link(route('clients_show', $row->ClientID), $row->Surname) !!} </td>
                    <td>{!! Html::link(route('clients_show', $row->ClientID), $row->Email) !!} </td>
                    <td>{!! Html::link(route('clients_show', $row->ClientID), $row->Application->Name) !!} </td>
                    <td>{!! Html::link(route('clients_show', $row->ClientID), Common::dateRead($row->LastLoginDate, 'd.m.Y')) !!} </td>
                    <td>{!! Html::link(route('clients_show', $row->ClientID), $row->ClientID) !!} </td>
                  </tr>
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

        <!-- end tabular_content-->
        <div class="select">
          @if((int)request('customerID', 0) > 0)
            {{ $rows->appends(array('customerID' => request('customerID', 0), 'search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
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