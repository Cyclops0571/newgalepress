@extends('layouts.master')

@section('content')
  <!--<form id="list">-->
  <div class="col-md-12">
    <div class="block bg-light-ltr">
      <div class="content controls bg-light-rtl">
        <div class="form-row ">
          <div class="col-md-12">
            @include('sections.commandbar')
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12">
            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                    <?php foreach ($fields as $field): ?>
                    <?php $sortClass = $sort == $field[2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array(); ?>
                    <?php
                    /** @var App\Models\Application[] $rows */
                    $linkParameters = [

                        'page'       => 1,
                        'customerID' => request('customerID', 0) ? request('customerID', 0) : '',
                        'search'     => $search,
                        'sort'       => $field[2],
                        'sort_dir'   => ($sort_dir == 'DESC' ? 'ASC' : 'DESC')]; ?>
                  <th scope="col"> {!! Html::link(route('applications', $linkParameters), $field[1], $sortClass) !!}</th>
                    <?php endforeach; ?>

                </tr>
              </thead>
              <tbody>
                @forelse($rows as $row)
                  <tr class="{{ Common::htmlOddEven($page) }}">
                    <td>{!! Html::link(route('contents_list', ['applicationID' => $row->ApplicationID]), $row->ContentCount, array('class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')) !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), $row->CustomerName) !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), $row->Name)  !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), $row->ApplicationStatusName) !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), $row->PackageName) !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), $row->Blocked) !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), $row->Status) !!}</td>
                    <td>{!! Common::getFormattedData($row->Trail, $row->Trail) !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), Common::dateRead($row->ExpirationDate, 'd.m.Y')) !!}</td>
                    <td>{!! Html::link(route('applications_show', [$row->ApplicationID]), $row->ApplicationID) !!}</td>
                    <td>{!!  Common::getFormattedData($row->IsExpired, $row->IsExpired)  !!}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="{{ count($fields) }}">{{ __('common.list_norecord') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <!-- end tabular_content-->
        @if(count($rows))
          <div class="select">
            @if((int)request('customerID', 0) > 0)
              {{ $rows->appends(array('customerID' => request('customerID', 0), 'search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
            @else
              {{ $rows->appends(array('search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
            @endif
          </div>
        @endif
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