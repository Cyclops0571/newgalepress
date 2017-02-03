<?php
$trigger_x = 0;
$trigger_y = 0;
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'trigger-x') $trigger_x = (int)$prop->Value;
		if($prop->Name == 'trigger-y') $trigger_y = (int)$prop->Value;
	}
}
?>
<div class="coordinates coordinates-trigger">
    <a href="javascript:void(0);" class="expand">{{ __('interactivity.coordinates_trigger') }} <i class="icon-"></i></a>
    <div class="component-panel">
        <div class="text dark">
            <label for="comp-{id}-trigger-x">{{ __('interactivity.coordinates_x') }}</label>
            <input type="text" name="comp-{id}-trigger-x" class="trigger-x" value="{{ $trigger_x }}">
        </div>
        <div class="text dark">
            <label for="comp-{id}-trigger-y">{{ __('interactivity.coordinates_y') }}</label>
            <input type="text" name="comp-{id}-trigger-y" class="trigger-y" value="{{ $trigger_y }}">
        </div>
    </div>
</div>
<!-- end coordinates -->