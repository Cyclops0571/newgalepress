<!-- TOOLTIP --><?php
$option = 1;
$filename = '';
$fileSelected = 0;
$fileSize = '';

$filename2 = '';
$fileSelected2 = 0;
$fileSize2 = '';

$init = 'right';
$boxcolor = '#333399';
$opacity = 100;
$content = '';
$transparent = 0;
$bgcolor = '#fff';
$iconcolor = '#fff';
$boxopacity = 0.8;

$iconwidth = 30;
$iconheight = 30;

if (isset($Properties))
{
    foreach ($Properties as $prop)
    {
        if ($prop->Name == 'init') $init = $prop->Value;
        if ($prop->Name == 'boxcolor') $boxcolor = $prop->Value;
        if ($prop->Name == 'iconcolor') $iconcolor = $prop->Value;
        if ($prop->Name == 'opacity') $opacity = (int)$prop->Value;
        if ($prop->Name == 'content') $content = $prop->Value;
        if ($prop->Name == 'transparent') $transparent = (int)$prop->Value;
        if ($prop->Name == 'bgcolor') $bgcolor = $prop->Value;
        if ($prop->Name == 'iconcolor') $iconcolor = $prop->Value;
        if ($prop->Name == 'iconwidth') $iconwidth = $prop->Value;
        if ($prop->Name == 'iconheight') $iconheight = $prop->Value;
        if ($prop->Name == 'boxopacity') $boxopacity = $prop->Value;
        if ($prop->Name == 'option') $option = (int)$prop->Value;
        if ($prop->Name == 'filename')
        {
            $filename = public_path($prop->Value);
            if (File::exists($filename) && is_file($filename))
            {
                $fileSelected = 1;
                $fileSize = round((File::size($filename) / (1024 * 1024)), 1) . ' MB';
                $fname = File::name($filename);
                $fext = File::extension($filename);
                $filename = $fname . '.' . $fext;
            } else
            {
                $filename = '';
            }
        }
        if ($prop->Name == 'filename2')
        {
            $filename2 = public_path($prop->Value);
            if (File::exists($filename2) && is_file($filename2))
            {
                $fileSelected2 = 1;
                $fileSize2 = round((File::size($filename2) / (1024 * 1024)), 1) . ' MB';
                $fname2 = File::name($filename2);
                $fext2 = File::extension($filename2);
                $filename2 = $fname2 . '.' . $fext2;
            } else
            {
                $filename2 = '';
            }
        }
    }
}
?>
<div id="prop-{id}" class="component tooltip hide" componentid="{id}">
  <input type="hidden" name="compid[]" value="{id}"/>
  <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}"/>
  <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}"/>
  <input type="hidden" name="comp-{id}-process" value="{{ $Process }}"/>
  <div class="component-header">
    <h3><span></span>{{ __('interactivity.tooltip_name') }}
      <small> - {{ __('interactivity.tooltip_componentid') }}{id}</small>
    </h3>
    <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
  </div>
  <!-- end component-header -->

  <div class="upload">

    <div class="radiogroup">
      <div class="radio {{ ($option == 1 ? 'checked ' : '') }}js-radio" optionvalue="1">
        {{ __('interactivity.tooltip_icon_default') }}
      </div>
      <div class="radio {{ ($option == 2 ? 'checked ' : '') }}js-radio" optionvalue="2">
        {{ __('interactivity.tooltip_icon_new') }}
      </div>
      <input type="hidden" name="comp-{id}-option" id="comp-{id}-option" value="{{ $option }}"/>
    </div>

    <div class="icon1{{ ($option == 1 ? ' hide' : '') }}">
      <input type="file" name="comp-{id}-file" id="comp-{id}-file" class="hiddenFileHeight hidden"/>
      <input type="hidden" name="comp-{id}-fileselected" id="comp-{id}-fileselected" value="{{ $fileSelected }}"/>
      <input type="hidden" name="comp-{id}-filename" id="comp-{id}-filename" class="required" value="{{ $filename }}"/>
      <a class="btn expand uploadfile {{ ($fileSelected == 1 ? ' hide' : '') }}">{{ __('interactivity.tooltip_icon1') }}
        <i class="icon-upload"></i></a>
    </div>

    <div class="upload-icon1{{ ($fileSelected == 0 || $option == 1 ? ' hide' : '') }}">
      <div class="progress hide">
        <a href="#">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
        <label for="scale"></label>
        <div class="scrollbox dot">
          <div class="scale" style="width: 0%"></div>
        </div>
      </div>
      <!-- end progress -->
      <a {{ (mb_strlen($filename) > 0 ? 'href="'.$filename.'" ' : '') }} target="_blank"
         class="tooltip-icon1{{ ($fileSelected == 0 ? ' hide' : '') }}">1) {{ str_limit($filename, 17) }}</a>
      <a class="close{{ ($fileSelected == 0 ? ' hide' : '') }}"><i class="icon-remove"></i></a>

      <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.video_poster_error') }}</span>
    </div>

    <div class="icon2{{ ($option == 1 ? ' hide' : '') }}">
      <input type="file" name="comp-{id}-file2" id="comp-{id}-file2" class="hiddenFileHeight hidden"/>
      <input type="hidden" name="comp-{id}-fileselected2" id="comp-{id}-fileselected2" value="{{ $fileSelected2 }}"/>
      <input type="hidden" name="comp-{id}-filename2" id="comp-{id}-filename2" class="required"
             value="{{ $filename2 }}"/>
      <a class="btn expand uploadfile2 {{ ($fileSelected2 == 1 ? ' hide' : '') }}">{{ __('interactivity.tooltip_icon2') }}
        <i class="icon-upload"></i></a>
    </div>

    <div class="upload-icon2{{ ($fileSelected2 == 0 || $option == 1 ? ' hide' : '') }}">
      <div class="progress hide">
        <a href="#">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
        <label for="scale"></label>
        <div class="scrollbox dot">
          <div class="scale" style="width: 0%"></div>
        </div>
      </div>
      <!-- end progress -->
      <a {{ (mb_strlen($filename2) > 0 ? 'href="'.$filename2.'" ' : '') }} target="_blank"
         class="tooltip-icon2{{ ($fileSelected2 == 0 ? ' hide' : '') }}">2) {{ str_limit($filename2, 17) }}</a>
      <a class="close{{ ($fileSelected2 == 0 ? ' hide' : '') }}"><i class="icon-remove"></i></a>

      <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.video_poster_error') }}</span>

      <div class="coordinates">
        <a href="#" class="expand">{{ __('interactivity.tooltip_icon_name') }}<i class="icon-"></i></a>
        <div class="component-panel">
          <div class="text dark">
            <label for="comp-{id}-iconwidth">{{ __('interactivity.coordinates_w') }}</label>
            <input type="text" name="comp-{id}-iconwidth" value="{{$iconwidth}}">
          </div>
          <div class="text dark">
            <label for="comp-{id}-iconheight">{{ __('interactivity.coordinates_h') }}</label>
            <input type="text" name="comp-{id}-iconheight" value="{{$iconheight}}">
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- end upload -->
  <div class="settings">
    <div class="component-panel">
      <h5 title="{{ __('interactivity.tooltip_type_tooltip') }}" class="tooltip">{{ __('interactivity.tooltip_type') }}
        <i class="icon-info-sign"></i></h5>
      <div
          class="checkbox js-checkbox{{ ($transparent == 1 ? ' checked' : '') }}">{{ __('interactivity.slideshow_transparent') }}
        <input type="hidden" name="comp-{id}-transparent" value="{{ $transparent }}"/>
      </div>
      @include('interactivity.components.import')
      <div class="text dark {{ ($transparent == 1 ? ' hide' : '') }}">
        <label for="comp-{id}-bgcolor">{{ __('interactivity.slideshow_background') }}</label>
        <input name="comp-{id}-bgcolor" type="text" value="{{ $bgcolor }}"/>
      </div>
      <div class="text dark">
        <label for="comp-{id}-iconcolor">{{ __('interactivity.tooltip_iconcolor') }}</label>
        <input name="comp-{id}-iconcolor" type="text" value="{{ $iconcolor }}"/>
      </div>
      <div class="text dark">
        <label for="comp-{id}-boxopacity">{{ __('interactivity.tooltip_background_opacity') }} <span
              style="font-size:10px;">(0.1, 0.2, ... , 1)</span></label>
        <input type="text" name="comp-{id}-boxopacity" placeholder="0.85" value="{{ $boxopacity }}">
      </div>
      <div class="text">
        <label for="comp-{id}-init">{{ __('interactivity.tooltip_init') }}</label>
        <select class="select js-select" name="comp-{id}-init" id="comp-{id}-init">
          <option{{ ($init == '' ? ' selected="selected"' : '') }}></option>
          <option
              value="left"{{ ($init == 'left' ? ' selected="selected"' : '') }}>{{ __('interactivity.tooltip_select1') }}</option>
          <option
              value="right"{{ ($init == 'right' ? ' selected="selected"' : '') }}>{{ __('interactivity.tooltip_select2') }}</option>
          <option
              value="top"{{ ($init == 'top' ? ' selected="selected"' : '') }}>{{ __('interactivity.tooltip_select3') }}</option>
          <option
              value="bottom"{{ ($init == 'bottom' ? ' selected="selected"' : '') }}>{{ __('interactivity.tooltip_select4') }}</option>
        </select>
      </div>
      <!-- end inline -->
      <textarea id="comp-{id}-content" name="comp-{id}-content" class="hide">{{ $content }}</textarea>
      <a href="#" class="btn expand edit">
        {{ __('interactivity.tooltip_modify') }} <i class="icon-edit"></i>
      </a>
    </div>
    <!-- end component-panel -->
    @include('interactivity.components.coordinates')
  </div>
  <!--  end settings -->
  <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div><!-- end tooltip -->