<style type="text/css">
  masterContentRow {
    background: #5D5D5D;
  }
</style>
<table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%"
       class="table table-bordered table-striped table-hover">
  <thead>
  <tr>
    @if($currentPageNo < 2 && (int)Auth::user()->UserTypeID == eUserTypes::Customer)
      <th><?php echo __('common.sort'); ?></th>
    @endif
      <?php foreach ($fields as $field): ?>
      <?php $sortLink = '&sort=' . $field[1]; ?>
      <?php $sort == $field[1] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array(); ?>
        <th scope="col">{!! Html::link($route.'?page=1'. $appLink  . $searchLink . $sortLink . $sortDirLink, $field[0], $sort) !!}</th>
      <?php endforeach; ?>
  </tr>
  </thead>
  <tbody>
  <form id="contentOrderForm">
  @forelse($rows as $row)
      <tr id="contentIDSet_{{$row->ContentID}}" class="{{ Common::htmlOddEven($page) }}" {{Common::getClass($row)}} >
        @if((int)Auth::user()->UserTypeID == eUserTypes::Manager)
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->CustomerName}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->ApplicationName}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->Name}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->Blocked}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->Status}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->ContentID}}</a></td>
        @elseif((int)Auth::user()->UserTypeID == eUserTypes::Customer)
              <?php if ($currentPageNo < 2): ?>
          <td style="cursor:pointer;">
          <span class="icon-resize-vertical list-draggable-icon"
                @if($row->IsMaster==1)style="margin-left:-5px;"@endif>
            @if($row->IsMaster==1)
              <i style="font-size:11px;">(Master)</i>
            @endif
          </span>
          </td>
              <?php endif; ?>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->Name}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->Detail}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->MonthlyName}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->CategoryName}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{Common::dateRead($row->PublishDate, 'd.m.Y')}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{Common::dateRead($row->UnpublishDate, 'd.m.Y')}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->Blocked}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->Status}}</a></td>
          <td><a href="{{$route.'/'.$row->ContentID}}">{{$row->ContentID}}</a></td>
        @endif
      </tr>
    @empty
      <tr>
        <td class="select">&nbsp;</td>
        <td colspan="{{ count($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
      </tr>
    @endforelse
  </form>
  </tbody>
</table>