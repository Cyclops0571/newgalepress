<!-- WEBCONTENT -->
<?php
$url = '';
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'url') $url = $prop->Value;
	}
}
?>
<div id="prop-{id}" class="component webcontent hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.webcontent_name') }}<small> - {{ __('interactivity.webcontent_componentid') }}{id}</small></h3>
        <a href="javascript:void(0);" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    <!-- end component-header -->
    <div class="settings">
        <div class="component-panel">
            <h5 title="{{ __('interactivity.webcontent_playerpreferences_tooltip') }}" class="tooltip">{{ __('interactivity.webcontent_playerpreferences') }} <i class="icon-info-sign"></i></h5>
            @include('interactivity.components.modal')
            <h5 title="{{ __('interactivity.webcontent_type_tooltip') }}" class="tooltip">{{ __('interactivity.webcontent_type') }} <i class="icon-info-sign"></i></h5>
            <div class="text dark inline-primary">
                <input type="text" name="comp-{id}-url" id="comp-{id}-url" placeholder="http://www.google.com" class="prefix" value="{{ $url }}">
            </div>
            <div class="inline-secondary"><a href="javascript:void(0);" class="btn btn-primary postfix"><i class="icon-ok"></i></a></div>
            <span class="success hide"><i class="icon-ok-sign"></i>{{ __('interactivity.webcontent_success') }}</span>
            <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.webcontent_error') }}</span>
        </div>
        <!-- end component-panel -->
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings --> 
    <a href="javascript:void(0);" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end webcontent --> 