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
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[1][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[1][1], ($sort == $fields[1][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[2][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[2][1], ($sort == $fields[2][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[3][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[3][1], ($sort == $fields[3][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[4][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[4][1], ($sort == $fields[4][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[5][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[5][1], ($sort == $fields[5][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[6][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[6][1], ($sort == $fields[6][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[7][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[7][1], ($sort == $fields[7][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[8][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[8][1], ($sort == $fields[8][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[9][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[9][1], ($sort == $fields[9][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[10][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[10][1], ($sort == $fields[10][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[11][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[11][1], ($sort == $fields[11][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                </tr>
                            </thead>
                            <tfoot class="hidden">
                                <tr>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[1][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[1][1], ($sort == $fields[1][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[2][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[2][1], ($sort == $fields[2][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[3][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[3][1], ($sort == $fields[3][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[4][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[4][1], ($sort == $fields[4][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[5][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[5][1], ($sort == $fields[5][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[6][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[6][1], ($sort == $fields[6][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[7][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[7][1], ($sort == $fields[7][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[8][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[8][1], ($sort == $fields[8][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[9][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[9][1], ($sort == $fields[9][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[10][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[10][1], ($sort == $fields[10][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                    <th scope="col">{{ Html::link($route.'?page=1'.((int)request('customerID', 0) > 0 ? '&customerID='.request('customerID', 0) : '').'&search='.$search.'&sort='.$fields[11][2].'&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC'), $fields[11][1], ($sort == $fields[11][2] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array())) }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($rows->results as $row)
                                <tr class="{{ Html::oddeven($page) }}">
                                    <td>{{ Html::link(__('route.contents').'?applicationID='.$row->ApplicationID, $row->ContentCount, array('class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only')) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, $row->CustomerName) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, $row->Name) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, $row->ApplicationStatusName) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, $row->PackageName) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, $row->Blocked) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, $row->Status) }}</td>
                                    <td>{{ Common::getFormattedData($row->Trail, $row->Trail) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, Common::dateRead($row->ExpirationDate, 'd.m.Y')) }}</td>
                                    <td>{{ Html::link($route.'/'.$row->ApplicationID, $row->ApplicationID) }}</td>
                                    <td>{{ Common::getFormattedData($row->IsExpired, $row->IsExpired) }}</td>
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