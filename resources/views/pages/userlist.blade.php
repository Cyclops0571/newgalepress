@extends('layouts.master')

@section('content')
    <!--<form id="list">-->
    <div class="col-md-12">
        <div class="block bg-light-ltr" >
            <div class="content controls bg-light-rtl">
                <div class="form-row ">
                    <div class="col-md-12">         
                        {{ $commandbar }}
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">  
                        <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[1][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[1][1], ($sort == $fields[1][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[2][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[2][1], ($sort == $fields[2][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[3][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[3][1], ($sort == $fields[3][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[4][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[4][1], ($sort == $fields[4][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[5][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[5][1], ($sort == $fields[5][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                </tr>
                            </thead>
                            <tfoot class="hidden">
                                <tr>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[1][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[1][1], ($sort == $fields[1][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[2][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[2][1], ($sort == $fields[2][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[3][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[3][1], ($sort == $fields[3][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[4][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[4][1], ($sort == $fields[4][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ HTML::link($route.'?page=1'.((int)Input::get('customerID', 0) > 0 ? '&customerID='.Input::get('customerID', 0) : '').'&search='.$search.'&sort='.$fields[5][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[5][1], ($sort == $fields[5][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($rows->results as $row)
                                <tr class="{{ HTML::oddeven($page) }}">
                                    <td>{{ HTML::link($route.'/'.$row->UserID, $row->UserTypeName) }}</td>
                                    <td>{{ HTML::link($route.'/'.$row->UserID, $row->FirstName) }}</td>
                                    <td>{{ HTML::link($route.'/'.$row->UserID, $row->LastName) }}</td>
                                    <td>{{ HTML::link($route.'/'.$row->UserID, $row->Email) }}</td>
                                    <td>{{ HTML::link($route.'/'.$row->UserID, $row->UserID) }}</td>
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
                    @if((int)Input::get('customerID', 0) > 0)
                        {{ $rows->appends(array('customerID' => Input::get('customerID', 0), 'search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
                    @else
                        {{ $rows->appends(array('search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }} 
                    @endif
                </div>
                <script type="text/javascript">
                    $(function() {
                        $("div.pagination ul").addClass("pagination");
                    });
                </script>
                <!-- end select-->
            </div>
        </div>
    </div>
    <!--</form>-->
@endsection