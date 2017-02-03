<!-- IMPORT -->
<?php
$import = 0;

if(isset($Properties))
{
    foreach($Properties as $prop)
    {
        if($prop->Name == 'import') $import = (int)$prop->Value;
    }
}
?>
<div class="checkbox js-checkbox{{ ($import == 1 ? ' checked' : '') }}">{{ __('interactivity.video_import') }}<input type="hidden" name="comp-{id}-import" value="{{ $import }}" /></div>