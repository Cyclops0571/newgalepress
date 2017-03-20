<!-- BOOKMARK -->
<?php
$text = '';
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'text') $text = $prop->Value;
	}
}
?>
<div id="prop-{id}" class="component bookmark hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.bookmark_name') }}<small> - {{ __('interactivity.bookmark_componentid') }}{id}</small></h3>
        <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    <!-- end component-header -->
    <div class="settings">
	    <div class="component-panel">
            <h5 title="{{ __('interactivity.bookmark_type_tooltip') }}" class="tooltip">{{ __('interactivity.bookmark_type') }} <i class="icon-info-sign"></i></h5>
            <div class="text dark">
            	<label for="comp-{id}-text">{{ __('interactivity.bookmark_text') }}</label>
                <input type="text" name="comp-{id}-text" id="comp-{id}-text" value="{{ $text }}">
            </div>
        </div>
        <!-- end component-panel --> 
        @include('interactivity.components.coordinates_trigger')
    </div>
    <!--  end settings -->
    <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end bookmark --> 