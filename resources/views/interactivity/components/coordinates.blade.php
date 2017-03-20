<?php
$x = 0;
$y = 0;
$w = 0;
$h = 0;
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'x') $x = (int)$prop->Value;
		if($prop->Name == 'y') $y = (int)$prop->Value;
		if($prop->Name == 'w') $w = (int)$prop->Value;
		if($prop->Name == 'h') $h = (int)$prop->Value;
	}
}
?>
<div class="coordinates">
    <a href="#" class="expand">{{ __('interactivity.coordinates') }} <i class="icon-"></i></a>
    <div class="component-panel">
        <div class="text dark">
            <label for="comp-{id}-x">{{ __('interactivity.coordinates_x') }}</label>
            <input type="text" name="comp-{id}-x" class="x" value="{{ $x }}">
        </div>
        <div class="text dark">
            <label for="comp-{id}-y">{{ __('interactivity.coordinates_y') }}</label>
            <input type="text" name="comp-{id}-y" class="y" value="{{ $y }}">
        </div>
        <div class="text dark">
            <label for="comp-{id}-w">{{ __('interactivity.coordinates_w') }}</label>
            <input type="text" name="comp-{id}-w" class="w" value="{{ $w }}">
        </div>
        <div class="text dark">
            <label for="comp-{id}-h">{{ __('interactivity.coordinates_h') }}</label>
            <input type="text" name="comp-{id}-h" class="h" value="{{ $h }}">
        </div>
    </div>
</div>
<!-- end coordinates -->