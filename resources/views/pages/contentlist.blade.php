@extends('layouts.master')

@section('content')
    <?php
    $currentPageNo = (int)request('page', 0);
    $applicationID = (int)request('applicationID', 0);
    $appLink = $applicationID > 0 ? '&applicationID=' . $applicationID : '';
    $searchLink = '&search=' . $search;
    $sortDirLink = '&sort_dir=' . ($sort_dir == 'DESC' ? 'ASC' : 'DESC');
    ?>
    <script>
        var currentPageNo = <?php echo (int)$currentPageNo; ?>;
        var appID = <?php echo $applicationID ?>;
        $(function () {
            if (appID && currentPageNo < 2) {
                $("#DataTables_Table_1 tbody").sortable({
                    delay: 150,
                    axis: 'y',
                    update: function () {
                        var data = $(this).sortable('serialize');
                        $.ajax({
                            data: data,
                            type: 'POST',
                            url: '/contents/order/' + appID,
                            success: function (res) {
                                cNotification.success();
                                setTimeout(function () {
                                    cNotification.hide();
                                }, 1000);
                            }
                        });
                    }
                });
                $("#DataTables_Table_1 tbody").disableSelection();
            }
        });
    </script>
    <!--<form id="list">-->
    <div class="col-md-12">
      <div class="block bg-light-ltr">
        <div class="content controls bg-light-rtl">
          <div class="form-row ">
              <?php if(Auth::user()->UserTypeID == eUserTypes::Customer): ?>
            @include('sections.commandbar')
              <?php endif; ?>
          </div>
          <div class="form-row">
            <div class="col-md-12">
              @include('content.contentListTable')
            </div>
          </div>
        </div>
        <!-- end tabular_content-->
        <div class="select">
          @if($applicationID > 0)
            {{ $rows->appends(array('applicationID' => $applicationID, 'search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
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
    <!--</form>-->
@endsection

