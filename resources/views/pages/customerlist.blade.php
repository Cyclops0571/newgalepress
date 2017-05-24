@extends('layouts.master')

@section('content')
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
                    <?php foreach ($fields as $field): ?>
                    <?php $sortClass = $sort == $field[2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array(); ?>
                    <?php
                    /** @var App\Models\Application[] $rows */
                    $linkParameters = [

                        'page'     => 1,
                        'search'   => $search,
                        'sort'     => $field[2],
                        'sort_dir' => ($sort_dir == 'DESC' ? 'ASC' : 'DESC')]; ?>
                  <th scope="col"> {!! Html::link(route('customers', $linkParameters), $field[1], $sortClass) !!}</th>
                    <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                @forelse($rows as $row)
                  <tr class="{{ Common::htmlOddEven($page) }}">
                    <td>{{ Html::link(route('applications', ['customerID' => $row->CustomerID]), $row->ApplicationCount, array('class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')) }}</td>
                    <td>{{ Html::link(route('users', ['customerID' => $row->CustomerID]), $row->UserCount, array('class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')) }}</td>
                    <td>{{ Html::link(route('customers_show', $row->CustomerID), $row->CustomerNo) }}</td>
                    <td>{{ Html::link(route('customers_show', $row->CustomerID), $row->CustomerName) }}</td>
                    <td>{{ Html::link(route('customers_show', $row->CustomerID), $row->Phone1) }}</td>
                    <td>{{ Html::link(route('customers_show', $row->CustomerID), $row->Email) }}</td>
                    <td>{{ Html::link(route('customers_show', $row->CustomerID), $row->CustomerID) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="{{ count($fields)}}">{{ __('common.list_norecord') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <!-- end tabular_content-->
        @if(count($rows))
          <div class="select">
            {{ $rows->appends(array('search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
          </div>
        @endif
        <script type="text/javascript">
            $(function () {
                $("div.pagination ul").addClass("pagination");
            });
        </script>
      </div>
    </div>
  </div>
  <!-- end select-->
  <!--</form>-->
@endsection