<?php
use App\Models\Application;
?>
<div class="col-md-5 pull-left">
    <div class="col-md-offset-0 input-group commands">
        <?php if ((int)request('customerID', 0) > 0): ?>
        <a href="{{route($page.'_new', ['customerID', request('customerID', 0)])}}"
           title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle">
            <span class="icon-plus"></span>
        </a>
        <?php elseif ((int)request('applicationID', 0) > 0): ?>
        <a href="{{route($page.'_new', ['applicationID', request('applicationID', 0)])}}"
           title="{{__('common.commandbar_add')}}" class="widget-icon widget-icon-circle">
            <span class="icon-plus"></span>
        </a>
        <?php if (isset(Request::route()->action['as']) && Request::route()->action['as'] == 'contents'): ?>
        <a href="#modalPushNotification" title="Push Notification" data-toggle="modal"
           data-target="#modalPushNotification" class="widget-icon widget-icon-circle">
            <span class="icon-bullhorn"></span>
        </a>
        <?php $application = Application::find(request('applicationID', 0)); ?>
        <?php if($application && $application->FlipboardActive): ?>
        <a href="/tr/flipbook/{{request('applicationID', 0)}}" title="Flipbook"
           class="widget-icon widget-icon-circle" target="_blank">
            <span class="icon-book"></span>
        </a>
        <?php endif; ?>
        <?php endif; ?>

        <?php else: ?>
        <a href="{{route($page.'_new')}}" title="{{__('common.commandbar_add')}}"
           class="widget-icon widget-icon-circle">
            <span class="icon-plus"></span>
        </a>
        <?php endif; ?>
    </div>
</div>
<div class="col-md-4 commandbar-search">
    <form method="get" action="{{$route}}" >
      <input type="hidden" name="page" value="1" >
      <input type="hidden" name="sort" value="{{request('sort', $pk)}}" >
      <input type="hidden" name="sort_dir" value="{{request('sort_dir', 'DESC')}}" >
      <input type="hidden" name="applicationID" value="{{request('applicationID', '0')}}" >
    <div class="input-group">
        <div class="input-group-addon"><span class="icon-search"></span></div>
        <input class="form-control" name="search" value="{{ request('search', '') }}" type="text">
        <input type="submit" class="btn hidden" value="{{ __('common.commandbar_search') }}" >
    </div>
    </form>

</div>