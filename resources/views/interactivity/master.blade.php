@extends('interactivity.html')

@section('body-content')
  <!--<form class="dropzone1"></form>-->

  <input type="hidden" id="content-id" value="{{ $ContentID }}"/>

  <a href="#" class="fullTrigger hidden">fullscreen</a>

  <div id="wrapper">

    <div id="modal-editor" class="editor hide">
      <textarea id="editor"></textarea>
      <div class="action">
        <input type="button" value="{{ __('interactivity.cancel') }}" class="btn btn-cancel"
               onclick="cInteractivity.clickCancel();">
        <input type="button" value="{{ __('interactivity.ok') }}" class="btn btn-secondary"
               onclick="cInteractivity.clickOk();">
      </div>
    </div>

    @include('sections.sessionmodal')

    <div class="compression-settings hide">
      <a title="{{ __('interactivity.settings_close') }}" class="close" href="#"
         onclick="cInteractivity.closeSettings();"><i class="icon-remove"></i></a>
      <div class="checkbox js-checkbox tooltip{{ $included == 1 ? " checked" : ""}}"
           title="{{ __('interactivity.settings_description') }}">
        {{ __('interactivity.settings_label') }}
      </div>
      <div class="command">
        <a class="btn expand" href="#" onclick="cInteractivity.saveSettings();"><i
              class="icon-ok"></i>{{ __('interactivity.save') }}</a>
      </div>
    </div>

    <div class="transfer-modal hide">
      <a title="{{ __('interactivity.settings_close') }}" class="close" href="#"
         onclick="cInteractivity.closeTransferModal();"><i class="icon-remove"></i></a>

      <input type="hidden" id="transferComponentID" name="transferComponentID" value="">
      <input type="hidden" id="transferFrom" name="transferFrom" value="">
      <div>
        <p class="all">
          <strong>{{ __('interactivity.page') }} <em></em></strong>
          <span>{{ __('interactivity.transfer_description') }}</span>
        </p>
        <p class="one">
          <strong>{{ __('interactivity.page') }} <em></em></strong> <span
              text="{{ __('interactivity.transfer_description2') }}"></span>
        </p>
        <br>
        <select id="transferTo" name="transferTo" class="select js-select5">
          @foreach($pages as $page)
            <option value="{{ $page->No }}">{{ __('interactivity.page') }} {{ $page->No }}</option>
          @endforeach
        </select>
      </div>

      <div class="command">
        <a class="btn expand" href="#" onclick="cInteractivity.transfer();"><i
              class="icon-ok"></i>{{ __('interactivity.save') }}</a>
      </div>
    </div>

    <div id="modal-mask" class="modal-mask hide"></div>
    <!-- end modal-mask-->

    <div class="container">
      @include('interactivity.header')
      <div class="main">
        <div id="pdf-container">
          <div id="page">
            <div class="landmarks" data-show-at-zoom="0" data-allow-drag="false" data-allow-scale="true"></div>
          </div>
        </div>
        <!-- end pdf-container -->
      </div>
      <!-- end main -->
      @include('interactivity.sidebar')
      @include('interactivity.footer')
    </div>
    <!-- end wrapper -->
  </div>
  <!-- end container -->
@endsection


@section('components')
  @foreach(interactiveComponents() as $component)
      <?php $componentData = ['ComponentID' => $component->ComponentID, 'PageComponentID' => 0, 'Process' => 'new', 'PageCount' => count($pages)] ?>
      <script id="tool-{{ $component->Class }}" type="text/html">
        {!! view('interactivity.components.'.$component->Class.'.tool')->render() !!}
      </script>
      <script id="prop-{{ $component->Class }}" type="text/html">
        {!! view('interactivity.components.'.$component->Class.'.property', $componentData)->render() !!}
      </script>
  @endforeach
@endsection
