<!-- SLIDESHOW -->
<?php
use Illuminate\Support\Str;$files = '';
$fileSelected = 0;
$transparent = 0;
$bgcolor = '#151515';
$autoplay = 0;
if(isset($Properties))
{
	$index = 0;
	foreach($Properties as $prop)
	{
        switch ($prop->Name) {
            case 'filename':
                $index += 1;

                $filename = public_path($prop->Value);
                if (File::exists($filename) && is_file($filename)) {
                    $fname = File::name($filename);
                    $fext = File::extension($filename);
                    $filename = $fname . '.' . $fext;
                } else {
                    $filename = '';
                }

                if (mb_strlen($filename) > 0) {
                    $fileSelected = 1;
                    $files .= '<li>' . ($index > 9 ? "" . $index : "0" . $index) . ' - ' . Str::limit_exact($filename, 20) .
                            '<input type="hidden" name="comp-{id}-filename[]" class="required" value="' . $filename . '" />' .
                            '<a href="#" class="delete">' .
                            '<i class="icon-remove"></i>' .
                            '</a>' .
                            '</li>';
                }
                break;
            case 'transparent':
                $transparent = (int)$prop->Value;
                break;
            case 'bgcolor':
                $bgcolor = $prop->Value;
                break;
            case 'autoplay':
                $autoplay = $prop->Value;
                break;
        }
	}
}
?>
<div id="prop-{id}" class="component slideshow hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.slideshow_name') }}<small> - {{ __('interactivity.slideshow_componentid') }}{id}</small></h3>
        <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    <!-- end component-header -->
    <div class="settings">
        <div class="component-panel">
            <h5 title="{{ __('interactivity.slideshow_playerpreferences_tooltip') }}" class="tooltip">{{ __('interactivity.slideshow_playerpreferences') }} <i class="icon-info-sign"></i></h5>

            <div class="checkbox js-checkbox{{ ($autoplay == 1 ? ' checked' : '') }}">
                {{ __('interactivity.video_autoplay') }}<input type="hidden" name="comp-{id}-autoplay"
                                                               value="{{ $autoplay }}"/>
            </div>
            @include('interactivity.components.import')
            @include('interactivity.components.modal')
            <div class="checkbox js-checkbox{{ ($transparent == 1 ? ' checked' : '') }}">{{ __('interactivity.slideshow_transparent') }}<input type="hidden" name="comp-{id}-transparent" value="{{ $transparent }}" /></div>
            <div class="text dark {{ ($transparent == 1 ? ' hide' : '') }}">
                <label for="comp-{id}-bgcolor">{{ __('interactivity.slideshow_background') }}</label>
                <input name="comp-{id}-bgcolor" type="text" value="{{ $bgcolor }}" />
            </div>
            <h5 title="{{ __('interactivity.slideshow_type_tooltip') }}" class="tooltip">{{ __('interactivity.slideshow_type') }} <i class="icon-info-sign"></i></h5>
            <div class="drop-area">
                <p>{{ __('interactivity.slideshow_note') }} <a href="#">{{ __('interactivity.slideshow_click') }}</a></p>
            </div>
            <!-- end drop-area -->
            
            <div class="fromfile">
                <input type="file" name="comp-{id}-file" id="comp-{id}-file" class="hiddenFileHeight hidden" multiple="multiple" />
                <input type="hidden" name="comp-{id}-fileselected" id="comp-{id}-fileselected" value="{{ $fileSelected }}" />    

                <div class="progress hide">
                    <a href="#">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                    <label for="scale"></label>
                    <div class="scrollbox dot">
                        <div class="scale" style="width: 0%"></div>
                    </div>
                </div>
                <!-- end progress -->
            </div>
            
            <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.slideshow_error') }}</span>
            
            <ul class="file-rack">{{ $files }}</ul>
        </div>
        <!-- end component-panel -->
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings --> 
    <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end slideshow -->

