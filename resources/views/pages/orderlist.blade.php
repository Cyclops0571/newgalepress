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
                  @foreach($fields as $field)
                        <?php
                        $parameters = [
                            'page'     => 1,
                            'search'   => $search,
                            'sort'     => $field[2],
                            'sort_dir' => ($sort_dir == 'DESC' ? 'ASC' : 'DESC')
                        ]
                        ?>
                    <th scope="col">{{ Html::link(route('orders', $parameters), $fields[0][1], ($sort == $field[2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @forelse($rows as $row)
                  <tr class="{{ Common::htmlOddEven($page) }}">
                      <?php /*<td>{{ Html::link(route('orders_show', $row->OrderID), Common::dateRead($row->ExpirationDate, 'd.m.Y')) }}</td>*/ ?>
                    <td>{{ Html::link(route('orders_show', $row->OrderID), $row->OrderNo) }}</td>
                    <td>{{ Html::link(route('orders_show', $row->OrderID), $row->Name) }}</td>
                    <td>{{ Html::link(route('orders_show', $row->OrderID), $row->Website) }}</td>
                    <td>{{ Html::link(route('orders_show', $row->OrderID), $row->Email) }}</td>
                    <td>{{ Html::link(route('orders_show', $row->OrderID), $row->OrderID) }}</td>
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
          {{ $rows->appends(array('search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
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