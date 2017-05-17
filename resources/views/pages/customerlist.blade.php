@extends('layouts.master')

@section('content')
    <div class="col-md-12">
        <div class="block bg-light-ltr" >
            <div class="content controls bg-light-rtl">
                <div class="form-row ">
                    <div class="col-md-12">         
                        @include('sections.commandbar')
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">  
                        <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[1][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[1][1], ($sort == $fields[1][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[2][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[2][1], ($sort == $fields[2][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[3][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[3][1], ($sort == $fields[3][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[4][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[4][1], ($sort == $fields[4][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[5][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[5][1], ($sort == $fields[5][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[6][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[6][1], ($sort == $fields[6][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[7][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[7][1], ($sort == $fields[7][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                </tr>
                            </thead>
                            <tfoot class="hidden">
                                <tr>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[1][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[1][1], ($sort == $fields[1][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[2][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[2][1], ($sort == $fields[2][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[3][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[3][1], ($sort == $fields[3][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[4][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[4][1], ($sort == $fields[4][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[5][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[5][1], ($sort == $fields[5][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[6][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[6][1], ($sort == $fields[6][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1&search='.$search.'&sort='.$fields[7][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[7][1], ($sort == $fields[7][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($rows->results as $row)
                                    <tr class="{{ Common::htmlOddEven($page) }}">
                                    <td>{{ Html::link(__('route.applications').'?customerID='.$row->CustomerID, $row->ApplicationCount, array('class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')) }}</td>
                                    <td>{{ Html::link(__('route.users').'?customerID='.$row->CustomerID, $row->UserCount, array('class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->CustomerID, $row->CustomerNo) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->CustomerID, $row->CustomerName) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->CustomerID, $row->Phone1) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->CustomerID, $row->Email) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->CustomerID, $row->CustomerID) }}</td>
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
                    $(function() {
                        $("div.pagination ul").addClass("pagination");
                    });
                </script>
            </div>
        </div>
    </div>
            <!-- end select-->
    <!--</form>-->
@endsection