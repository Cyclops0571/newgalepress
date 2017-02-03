<!-- VIDEO -->
<?php
$option = 1;
$filename = '';
$fileSelected = 0;
$fileSize = '';
$url = '';
$x1 = 0;
$y1 = 0;
$x2 = 100;
$y2 = 100;
$duration = 1000;
$effect = 'linear';
$rotation = 0;
$rotationspeed = 1000;
$rotationeffect = 'linear';
$reverse= 0;
$loop= 0;
$unvisibleStart=0;
$animedelay = 0;
$animeinterval = 0;

if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'option') $option = (int)$prop->Value;
		if($prop->Name == 'filename')
		{
			$filename = path('public').$prop->Value;
			if(File::exists($filename) && is_file($filename)) {
				$fileSelected = 1;
                $fileAbsoluteSize = File::size($filename);
                if ($fileAbsoluteSize > 1024 * 1024) {
                    $fileSize = round($fileAbsoluteSize / (1024 * 1024), 1) . " MB";
                } else if ($fileAbsoluteSize > 1024) {
                    $fileSize = round($fileAbsoluteSize / 1024, 1) . " KB";
                } else if ($fileAbsoluteSize > 0) {
                    $fileSize = $fileAbsoluteSize . " Bytes";
                } else {
                    $fileSize = "0 Bytes";
                }

				$fname = File::name($filename);
				$fext = File::extension($filename);
				$filename = $fname.'.'.$fext;
			}
			else {
				$filename = '';
			}
		}
		if($prop->Name == 'url') $url = $prop->Value;
		if($prop->Name == 'x1') $x1 = (int)$prop->Value;
		if($prop->Name == 'y1') $y1 = (int)$prop->Value;
		if($prop->Name == 'x2') $x2 = (int)$prop->Value;
		if($prop->Name == 'y2') $y2 = (int)$prop->Value;
		if($prop->Name == 'duration') $duration = (int)$prop->Value;
		if($prop->Name == 'effect') $effect = $prop->Value;
		if($prop->Name == 'rotation') $rotation = (int)$prop->Value;
		if($prop->Name == 'rotationspeed') $rotationspeed = (int)$prop->Value;
		if($prop->Name == 'rotationeffect') $rotationeffect = $prop->Value;
		if($prop->Name == 'reverse') $reverse = (int)$prop->Value;
		if($prop->Name == 'loop') $loop = (int)$prop->Value;
		if($prop->Name == 'unvisibleStart') $unvisibleStart = (int)$prop->Value;
		if($prop->Name == 'animedelay') $animedelay = (int)$prop->Value;
		if($prop->Name == 'animeinterval') $animeinterval = (int)$prop->Value;

	}
}
?>
<div id="prop-{id}" class="component animation hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.animation_name') }}<small> - {{ __('interactivity.animation_componentid') }}{id}</small></h3>
        <a href="javascript:void(0);" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    
    <div class="upload{{ ($fileSelected != 0 ? ' hide' : '') }}">
    
        <div class="radiogroup">
            <div class="radio {{ ($option == 1 ? 'checked ' : '') }}js-radio" optionvalue="1">{{ __('interactivity.animation_upload_option1') }}</div>
            <div class="radio {{ ($option == 2 ? 'checked ' : '') }}js-radio" optionvalue="2">{{ __('interactivity.animation_upload_option2') }}</div>
            <input type="hidden" name="comp-{id}-option" id="comp-{id}-option" value="{{ $option }}" />
        </div>
        <!-- end radiogroup-->
        
        <div class="local{{ ($option == 2 ? ' hide' : '') }}">
        	<input type="file" name="comp-{id}-file" id="comp-{id}-file" class="hiddenFileHeight hidden" />
            <input type="hidden" name="comp-{id}-fileselected" id="comp-{id}-fileselected" value="{{ $fileSelected }}" />
			<input type="hidden" name="comp-{id}-filename" id="comp-{id}-filename" class="required" value="{{ $filename }}" />
	        <a class="btn expand uploadfile">{{ __('interactivity.animation_upload_text') }} <i class="icon-upload"></i></a>
        </div>
        
    	<div class="web{{ ($option == 1 ? ' hide' : '') }}">
            <div class="text dark inline-primary">
                <input type="text" name="comp-{id}-url" id="comp-{id}-url" placeholder="http://www.google.com/123.jpg" class="prefix" value="{{ $url }}">
            </div>
            <div class="inline-secondary">
                <a href="javascript:void(0);" class="btn btn-primary postfix"><i class="icon-upload-alt"></i></a>
            </div>
            <span class="success hide"><i class="icon-ok-sign"></i>{{ __('interactivity.animation_url_success') }}</span>
            <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.animation_url_fail') }}</span>
        </div>
        
        <div class="progress hide">
        	<a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
            <label for="scale"></label>
            <div class="scrollbox dot">
                <div class="scale" style="width: 0%"></div>
            </div>
        </div>
        <!-- end progress --> 
        <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.animation_upload_error') }}</span>
        <span class="error max-size hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.file_upload_error_max_size') }}</span>
    </div>
    <!-- end upload -->
    
    <div class="settings">
    	
        <div class="properties component-panel{{ ($fileSelected == 0 ? ' hide' : '') }}">
            <div class="file-header">
                <h4>{{ Str::limit($filename, 26) }}</h4>
                <span>{{ $fileSize }}</span>
                <a href="javascript:void(0);" class="delete" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
            </div>

            <div class="coordinates">
			    <div class="component-panel">
			        <div class="text dark">
			            <label for="comp-{id}-x1">{{ __('interactivity.animation_coordinates_x1') }}</label>
			            <input type="text" name="comp-{id}-x1" class="x1" value="{{ $x1 }}">
			        </div>
			        <div class="text dark">
			            <label for="comp-{id}-y1">{{ __('interactivity.animation_coordinates_y1') }}</label>
			            <input type="text" name="comp-{id}-y1" class="y1" value="{{ $y1 }}">
			        </div>
			        <div class="text dark">
			            <label for="comp-{id}-x2">{{ __('interactivity.animation_coordinates_x2') }}</label>
			            <input type="text" name="comp-{id}-x2" class="x2" value="{{ $x2 }}">
			        </div>
			        <div class="text dark">
			            <label for="comp-{id}-y2">{{ __('interactivity.animation_coordinates_y2') }}</label>
			            <input type="text" name="comp-{id}-y2" class="y2" value="{{ $y2 }}">
			        </div>
			    </div>
			</div>

    		<div class="text dark">
				<label for="comp-{id}-duration">{{ __('interactivity.animation_duration') }}</label>
				<input name="comp-{id}-duration" id="comp-{id}-duration" type="text" value="{{ $duration }}">
			</div>

            <?php
            $effects = __("interactivity.animation_effects")->get();
            ?>
            <div class="text dark">
				<label for="comp-{id}-effect" id="label_fade_effect">{{ __('interactivity.animation_effect') }}</label>
	        	<select class="select js-select selectedEffects" name="comp-{id}-effect" id="comp-{id}-effect" no="{id}">
	        		@foreach($effects as $key => $val)
					<option value="{{ $key }}"{{ ($effect == $key ? ' selected="selected"' : '') }}>{{ $val }}</option>
	        		@endforeach
				</select>
			</div>

			<div class="text dark">
				<label for="comp-{id}-rotation">{{ __('interactivity.animation_rotation') }}</label>
				<input name="comp-{id}-rotation" id="comp-{id}-rotation" type="text" value="{{ $rotation }}">
			</div>

			<div class="text dark">
				<label for="comp-{id}-rotationspeed">{{ __('interactivity.animation_rotationspeed') }}</label>
				<input name="comp-{id}-rotationspeed" id="comp-{id}-rotationspeed" type="text" value="{{ $rotationspeed }}">
			</div>

			<div class="text dark">
				<label for="comp-{id}-rotationeffect">{{ __('interactivity.animation_rotationeffect') }}</label>
	        	<select class="select js-select" name="comp-{id}-rotationeffect" id="comp-{id}-rotationeffect">
	        		@foreach($effects as $key => $val)
		        		@if($key !== 'fade')
						<option value="{{ $key }}"{{ ($rotationeffect == $key ? ' selected="selected"' : '') }}>{{ $val }}</option>
						@endif
	        		@endforeach
				</select>
			</div>

			<div class="text dark">
				<label for="comp-{id}-animedelay">{{ __('interactivity.animation_delay') }}</label>
				<input name="comp-{id}-animedelay" id="comp-{id}-animedelay" type="text" value="{{ $animedelay }}">
			</div>

			<div class="text dark">
				<label for="comp-{id}-animeinterval">{{ __('interactivity.animation_interval') }}</label>
				<input name="comp-{id}-animeinterval" id="comp-{id}-animeinterval" type="text" value="{{$animeinterval}}">
			</div>

            <div class="checkbox js-checkbox{{ ($reverse == 1 ? ' checked' : '') }}">{{ __('interactivity.animation_reverse') }}<input type="hidden" name="comp-{id}-reverse" value="{{ $reverse }}" /></div>
            <div class="checkbox js-checkbox{{ ($loop == 1 ? ' checked' : '') }}">{{ __('interactivity.animation_repeat') }}<input type="hidden" name="comp-{id}-loop" value="{{ $loop }}" /></div>
            <div id="comp-{id}-animefade" class="checkbox js-checkbox{{ ($unvisibleStart == 1 || $effect == 'fade' ? ' checked' : ' hide') }}" no="{{$unvisibleStart}}">{{ __('interactivity.animation_hidden_start') }}<input type="hidden" name="comp-{id}-unvisibleStart" value="{{ $unvisibleStart }}" /></div>

            @include('interactivity.components.import')

        </div>
        <!-- end component-panel -->
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings -->
    <a href="javascript:void(0);" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end video -->