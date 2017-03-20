<!-- 360 -->
<?php
$files = '';
$transparent = 0;
$bgcolor = '#151515';
if(isset($Properties))
{
	$index = 0;
	
	foreach($Properties as $prop)
	{
		if($prop->Name == 'filename')
		{
			$index += 1;
			
			$filename = public_path($prop->Value);
			if(File::exists($filename) && is_file($filename)) {
				$fname = File::name($filename);
				$fext = File::extension($filename);
				$filename = $fname.'.'.$fext;
			}
			else {
				$filename = '';
			}
			
			if(Str::length($filename) > 0)
			{
				$files .= '<li>'.($index > 9 ? "".$index: "0".$index).' - '.$filename.'<input type="hidden" name="comp-{id}-filename[]" class="required" value="'.$filename.'" /><a href="#" class="delete"><i class="icon-remove"></i></a></li>';
			}
		}
        if($prop->Name == 'transparent') $transparent = (int)$prop->Value;
        if($prop->Name == 'bgcolor') $bgcolor = $prop->Value;
	}
}
$fileSelected = 0;
if(Str::length($files) > 0)
{
	$fileSelected = 1;
}
?>
<div id="prop-{id}" class="component gal360 hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.gal360_name') }}<small> - {{ __('interactivity.gal360_componentid') }}{id}</small></h3>
        <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    <!-- end component-header -->
    <div class="settings">
        <div class="component-panel">
            <h5 title="{{ __('interactivity.gal360_playerpreferences_tooltip') }}" class="tooltip">{{ __('interactivity.gal360_playerpreferences') }} <i class="icon-info-sign"></i></h5>
            @include('interactivity.components.import')
            @include('interactivity.components.modal')
            <div class="checkbox js-checkbox{{ ($transparent == 1 ? ' checked' : '') }}">{{ __('interactivity.slideshow_transparent') }}<input type="hidden" name="comp-{id}-transparent" value="{{ $transparent }}" /></div>
            <div class="text dark {{ ($transparent == 1 ? ' hide' : '') }}">
                <label for="comp-{id}-bgcolor">{{ __('interactivity.slideshow_background') }}</label>
                <input name="comp-{id}-bgcolor" type="text" value="{{ $bgcolor }}" />
            </div>
            <h5 title="{{ __('interactivity.gal360_type_tooltip') }}" class="tooltip">{{ __('interactivity.gal360_type') }} <i class="icon-info-sign"></i></h5>
            <div class="drop-area">
                <p>{{ __('interactivity.gal360_note') }} <a href="#">{{ __('interactivity.gal360_click') }}</a></p>
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
            
            <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.gal360_error') }}</span>
        	
            <ul class="file-rack">{{ $files }}</ul>
        </div>
        <!-- end component-panel -->
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings --> 
    <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end 360 --> 