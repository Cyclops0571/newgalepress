<style>
    .vertical{
    -webkit-transform:rotate(90deg);
    -moz-transform:rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform:rotate(90deg);
    transform: rotate(90deg);
    white-space:nowrap;
    display:block;
    bottom:0;
    width:20px;
    height:20px;
}
</style>
<?php
//support-settings-button 

//echo Laravel\Lang:: ?>
<?php if(Laravel\Config::get('application.language') != 'de'): ?>
<div class="support-settings">
    <div class="support-settings-button vertical" onclick="location.href='<?php echo route('my_ticket') ?>'">
	<span class="icon-question-sign"></span> 
	<?php echo __('common.support');?>
    </div>
</div>
<?php endif; ?>
