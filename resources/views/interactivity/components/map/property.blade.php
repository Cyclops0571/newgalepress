<!-- MAP  -->
<?php
$type = 1;
$lat = '';
$lon = '';
$zoom = 0.09;
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'type') $type = (int)$prop->Value;
		if($prop->Name == 'lat') $lat = $prop->Value;
		if($prop->Name == 'lon') $lon = $prop->Value;
		if($prop->Name == 'zoom') $zoom = (float)$prop->Value;
	}
}
?>
<div id="prop-{id}" class="component map hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.map_name') }}<small> - {{ __('interactivity.map_componentid') }}{id}</small></h3>
        <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    <!-- end component-header -->
    <div class="settings">
        <div class="component-panel">
            <h5 title="{{ __('interactivity.map_type_tooltip') }}" class="tooltip">{{ __('interactivity.map_type') }} <i class="icon-info-sign"></i></h5>
            <div class="radiogroup">
                <div class="radio {{ ($type == 1 ? 'checked ' : '') }}js-radio" optionvalue="1">{{ __('interactivity.map_option1') }}</div>
                <div class="radio {{ ($type == 2 ? 'checked ' : '') }}js-radio" optionvalue="2">{{ __('interactivity.map_option2') }}</div>
                <div class="radio {{ ($type == 3 ? 'checked ' : '') }}js-radio" optionvalue="3">{{ __('interactivity.map_option3') }}</div>
                <input type="hidden" name="comp-{id}-type" id="comp-{id}-type" value="{{ $type }}" />
            </div>
            <div class="text dark">
                <label for="comp-{id}-lat">{{ __('interactivity.map_lat') }}</label>
                <input type="text" name="comp-{id}-lat" id="comp-{id}-lat" placeholder="54.93986" value="{{ $lat }}">
            </div>
            <div class="text dark">
                <label for="comp-{id}-lon">{{ __('interactivity.map_lon') }}</label>
                <input type="text" name="comp-{id}-lon" id="comp-{id}-lon" placeholder="-123.8100" value="{{ $lon }}">
            </div>
            <div class="text dark">
                <label for="comp-{id}-zoom">{{ __('interactivity.map_zoom') }}</label>
                <select class="select js-select" name="comp-{id}-zoom" id="comp-{id}-zoom">
                    @for ($i = 1; $i <= 90; $i++)
                        @if($i % 5 == 0)
                        <option value="{{ $i / 1000 }}"{{ ($zoom == ($i / 1000) ? ' selected="selected"' : '') }}>{{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </div>
        </div>
        <!-- end component-panel --> 
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings -->
    <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end map --> 