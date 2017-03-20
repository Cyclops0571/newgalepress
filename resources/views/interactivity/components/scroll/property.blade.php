<!-- SCROLLER -->
<?php
$content = '';
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'content') $content = $prop->Value;
	}
}
?>
<div id="prop-{id}" class="component scroll hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.scroll_name') }}<small> - {{ __('interactivity.scroll_componentid') }}{id}</small></h3>
        <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    <!-- end component-header -->
    <div class="settings">
        <div class="component-panel">
            <h5 title="{{ __('interactivity.scroll_type_tooltip') }}" class="tooltip">{{ __('interactivity.scroll_type') }} <i class="icon-info-sign"></i></h5>
            @include('interactivity.components.import')
            <textarea id="comp-{id}-content" name="comp-{id}-content" class="hide">{{ $content }}</textarea>
            <a href="#" class="btn expand edit">{{ __('interactivity.scroll_modify') }} <i class="icon-edit"></i></a>
        </div>
        <!--  end component-panel --> 
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings -->
    <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end SCROLLER --> 