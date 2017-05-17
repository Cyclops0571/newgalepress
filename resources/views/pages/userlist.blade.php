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
            <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%"
                   class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  @foreach($fields as $field)

                        <?php
                        $link = route('users', [
                            'page'       => 1,
                            'customerID' => request('customerID', 0),
                            'search'     => $search,
                            'sort'       => $field[1],
                            'sort_dir'   => $sort_dir == 'DESC' ? 'ASC' : 'DESC',

                        ]);?>
                    <th scope="col">{{ Html::link($link, $field[0], ($sort == $field[1] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @forelse($rows as $row)
                  <tr class="{{ Common::htmlOddEven($page) }}">
                    <td>{{ Html::link(route('users_show', $row->UserID), $row->UserTypeName) }}</td>
                    <td>{{ Html::link(route('users_show', $row->UserID), $row->FirstName) }}</td>
                    <td>{{ Html::link(route('users_show', $row->UserID), $row->LastName) }}</td>
                    <td>{{ Html::link(route('users_show', $row->UserID), $row->Email) }}</td>
                    <td>{{ Html::link(route('users_show', $row->UserID), $row->UserID) }}</td>
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