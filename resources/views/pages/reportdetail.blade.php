@extends('layouts.html')

@section('head')
  @parent
@endsection

@section('body')
  <body id="report" style="background:transparent;">
    <div class="container">
        <?php
        /*
        <div class="row">
          <div class="col-md-4 reportSubtitle">
             <span>&nbsp;{{ __('common.header_begindate') }} {{ $sd }}</span><br>
             <span>&nbsp;{{ __('common.header_enddate') }} {{ $ed }}</span><br><br>
          </div>
        </div>
        */
        ?>
      <div class="row">
        <div class="col-md-12">
            <?php
            $amounts = array();
            $arrReport302 = '';
            ?>
          <table class="table table-bordered table-striped table-hover">
            <colgroup>
              @foreach($arrFieldCaption as $c)
                <col width="100"/>
              @endforeach
            </colgroup>
            <thead>
              <tr>
                @foreach($arrFieldCaption as $c)
                  <th>{{ $c }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @forelse($rows as $row)
                      <?php $row = get_object_vars($row); ?>
                  <tr>
                  @for($i=0;$i<count($arrFieldName);$i++)
                        <?php
                        if (($arrFieldType[$i] == 'Size' || $arrFieldType[$i] == 'Number') && !in_array($arrFieldName[$i], $amounts))
                        {
                            if (isset($amounts[$arrFieldName[$i]]))
                            {
                                $amounts[$arrFieldName[$i]] = (float)$amounts[$arrFieldName[$i]] + (float)$row[$arrFieldName[$i]];
                            } else
                            {
                                $amounts[$arrFieldName[$i]] = (float)$row[$arrFieldName[$i]];
                            }
                        }
                        ?>
                    <td>{{ Common::getFormattedData($row[$arrFieldName[$i]], $arrFieldType[$i]) }}</td>
                  @endfor
                </tr>
                @if($report == "302")
                        <?php $arrReport302 = $arrReport302 . ", ['" . $row["Device"] . "', " . $row["DownloadCount"] . "]"; ?>
                @endif
              @empty
                <tr>
                  <td colspan="{{ count($arrFieldName) }}">{{ __('common.list_norecord') }}</td>
                </tr>
              @endforelse
              @if(!empty($amounts))
                <tr>
                    <?php
                    echo '<td colspan="' . (count($arrFieldName) - count($amounts)) . '" style="text-align:right;">Toplam: </td>';
                    for ($i = 0; $i < count($arrFieldName); $i++)
                    {
                        if (isset($amounts[$arrFieldName[$i]]))
                        {
                            echo '<td>' . Common::getFormattedData($amounts[$arrFieldName[$i]], $arrFieldType[$i]) . '</td>';
                        }
                    }
                    ?>
                </tr>
              @endif
            </tbody>
          </table>
          {{ $rows->appends(array('sd' => request('sd'), 'ed' => request('ed'), 'customerID' => request('customerID'), 'applicationID' => request('applicationID'), 'contentID' => request('contentID'), 'country' => request('country'), 'city' => request('city'), 'district' => request('district')))->links() }}
          <script type="text/javascript">
              $(function () {
                  $("div.pagination ul").addClass("pagination");
              });
          </script>
        </div>
      </div>
        <?php if($report == "302") { ?>
      <div id="chart_div"
           style="position:absolute; top:0px; left:0px; top:100px; width: 700px; height: 500px; color:#FFF"></div>
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <script type="text/javascript">
          google.load("visualization", "1", {packages: ["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
              var data = google.visualization.arrayToDataTable([["{{ __('common.reports_device') }}", "{{ __('common.reports_usage') }}"]{{ $arrReport302 }}]);
              var options = {
                  title: "{{ __('common.reports_graph') }}",
                  backgroundColor: "transparent",
                  color: ["#fff"],
                  titleTextStyle: {color: '#fff'},
                  pieSliceTextStyle: {color: '#fff'},
                  legend: {
                      textStyle: {color: '#fff'}
                  }
              };
              var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
              chart.draw(data, options);
          }
      </script>
        <?php } ?>
    </div>
  </body>
@endsection