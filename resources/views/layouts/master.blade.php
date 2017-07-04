@extends('layouts.html')

@section('head')
  @parent
@endsection

@section('body')
  <body class="bg-img-num1">
    <div class="container content-list">
      <div class="row">
        <div class="loader-big hidden"></div>
        @include('sections.header')
      </div>
      <div class="row">
        <div class="page-container">
          <div class="page-sidebar">
            @include('sections.sidebar')
          </div>
          <div class="page-content">
            @yield('content')
          </div>
          @include('sections.support')
        </div>
      </div>
      <div class="row">
        <br>
      </div>
    </div>

    <div class="statusbar hidden" id="myNotification">
      <div class="statusbar-icon" style="margin-left:41%"><span></span></div>
      <div class="statusbar-text">
        <span class="text"></span>
        <span class="detail"></span>
      </div>
      <div class="statusbar-close icon-remove" onclick="cNotification.hide()"></div>
    </div>

    <div class="modal in" id="modalChangeLanguage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="false" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalClose()">×
            </button>
            <h4 class="modal-title">{{ __('common.site_lang_settings') }}</h4>
          </div>
          <div class="modal-body clearfix">
            <div class="controls">
              <div class="form-row">
                <div class="col-md-12">
                    <?php foreach(config('application.languages') as $lang): ?>
                    <?php if($lang != 'tr'):?>
                  <div class="checkbox">
                    <label>
                      <div class="radio">
					    <span
                  id="radio_<?php echo $lang; ?>" <?php echo app()->getLocale() === $lang ? 'class="checked"' : ''; ?> >
						<input type="radio" class="hidden" onclick='LanguageActive(<?php echo json_encode($lang); ?>);'>
					    </span>
                      </div>
                      <img src="/img/flags/<?php echo $lang;?>_icon.png"/>
                    </label>
                  </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal in" id="modalPushNotification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="false" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">{{ __('common.pushnotify_caption') }}</h4>
          </div>
          <div class="modal-body clearfix">
            <div class="controls">
              <form method="post" id="formPushNotification" action="{{route('applications_push', request('applicationID', '0'))}}">
                {{csrf_field()}}
                <div class="content controls">
                  <div class="form-row">
                    <div class="col-md-12">
                      <textarea class="form-control textbox required" cols="100" rows="5" name="NotificationText"
                                placeholder="{{ __('common.pushnotify_detail') }}"></textarea>
                    </div>
                  </div>
                  <div class="form-row">
                    <input class="btn my-btn-send pull-right col-md-3" style="margin-right:9px;" type="button"
                           onclick="cApplication.pushNotification();" value="{{ __('common.pushnotify_send') }}">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(\Route::getCurrentRoute()->getName() == 'maps_list')
      @include('sections.mapslist')
    @endif
    @include('sections.sessionmodal')
  </body>

@endsection