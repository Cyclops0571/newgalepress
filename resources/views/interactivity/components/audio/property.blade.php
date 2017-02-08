<!-- AUDIO -->
<?php
$option = 1;
$filename = '';
$fileSelected = 0;
$fileSize = '0 MB';
$url = '';
$videoinit = '';
$hidecontrols = 0;
$restartwhenfinished = 0;
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'option') $option = (int)$prop->Value;
		if($prop->Name == 'filename')
		{
			$filename = public_path($prop->Value);
			if(File::exists($filename) && is_file($filename)) {
				$fileSelected = 1;
				$fileSize = round((File::size($filename) / (1024 * 1024)), 1).' MB';
				$fname = File::name($filename);
				$fext = File::extension($filename);
				$filename = $fname.'.'.$fext;
			}
			else {
				$filename = '';
			}
		}
		if($prop->Name == 'url') $url = $prop->Value;
		if($prop->Name == 'videoinit') $videoinit = $prop->Value;
		if($prop->Name == 'hidecontrols') $hidecontrols = (int)$prop->Value;
		if($prop->Name == 'restartwhenfinished') $restartwhenfinished = (int)$prop->Value;
	}
}
?>
<div id="prop-{id}" class="component audio hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.audio_name') }}<small> - {{ __('interactivity.audio_componentid') }}{id}</small></h3>
        <a href="javascript:void(0);" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    
    <div class="upload">

        <!-- <div class="radiogroup">
            <div class="radio {{ ($option == 1 ? 'checked ' : '') }}js-radio" optionvalue="1">{{ __('interactivity.audio_upload_option1') }}</div>
            <div class="radio {{ ($option == 2 ? 'checked ' : '') }}js-radio" optionvalue="2">{{ __('interactivity.audio_upload_option2') }}</div>
            <input type="hidden" name="comp-{id}-option" id="comp-{id}-option" value="{{ $option }}" />
        </div> -->
        <!-- end radiogroup-->
        <input type="hidden" name="comp-{id}-option" id="comp-{id}-option" value="1"/>
        <?php $option = 1; ?>
        <div class="local{{ ($fileSelected == 1 || $option == 2 ? ' hide' : '') }}">
        	<input type="file" name="comp-{id}-file" id="comp-{id}-file" class="hiddenFileHeight hidden" />
            <input type="hidden" name="comp-{id}-fileselected" id="comp-{id}-fileselected" value="{{ $fileSelected }}" />
			<input type="hidden" name="comp-{id}-filename" id="comp-{id}-filename" class="required" value="{{ $filename }}" />
	        <a class="btn expand uploadfile">{{ __('interactivity.audio_upload_text') }} <i class="icon-upload"></i></a>
        </div>

        <!--<div class="web{{ ($option == 1 ? ' hide' : '') }}">
            <div class="text dark inline-primary">
                <input type="text" name="comp-{id}-url" id="comp-{id}-url" placeholder="http://www.galepress.com/test.mp3" class="prefix" value="{{ $url }}">
            </div>
            <div class="inline-secondary">
                <a href="javascript:void(0);" class="btn btn-primary postfix"><i class="icon-upload-alt"></i></a>
            </div>
            <span class="success hide"><i class="icon-ok-sign"></i>{{ __('interactivity.audio_url_success') }}</span>
            <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.audio_url_fail') }}</span>
        </div> -->
        
        <div class="progress hide">
        	<a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
            <label for="scale"></label>
            <div class="scrollbox dot">
                <div class="scale" style="width: 0%"></div>
            </div>
        </div>
        <!-- end progress --> 
        
        <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.audio_upload_error') }}</span>
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
            <select class="select js-select" name="comp-{id}-videoinit" id="comp-{id}-videoinit">
                <option value="onstart"{{ ($videoinit == 'onstart' ? ' selected="selected"' : '') }}>{{ __('interactivity.audio_select1') }}</option>
                <option value="onload"{{ ($videoinit == 'onload' ? ' selected="selected"' : '') }}>{{ __('interactivity.audio_select2') }}</option>
            </select>
            <!--<h5 title="{{ __('interactivity.audio_playerpreferences_tooltip') }}" class="tooltip">{{ __('interactivity.audio_playerpreferences') }} <i class="icon-info-sign"></i></h5>-->
            <!--<div class="checkbox js-checkbox{{ ($hidecontrols == 1 ? ' checked' : '') }}">{{ __('interactivity.audio_hidecontrols') }}<input type="hidden" name="comp-{id}-hidecontrols" value="{{ $hidecontrols }}" /></div>-->
            <!--<div class="checkbox js-checkbox{{ ($restartwhenfinished == 1 ? ' checked' : '') }}">{{ __('interactivity.audio_restartwhenfinished') }}<input type="hidden" name="comp-{id}-restartwhenfinished" value="{{ $restartwhenfinished }}" /></div>-->
            @include('interactivity.components.import')
        </div>
        <!-- end component-panel -->
        @include('interactivity.components.coordinates_trigger')
    </div>
    <!-- end settings -->
    <a href="javascript:void(0);" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end video --> 