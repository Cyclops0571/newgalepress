<!-- LINK  -->
<?php
$type = 1;
$page = 1;
$url = '';
$mail = '';
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'type') $type = (int)$prop->Value;
		if($prop->Name == 'page') $page = (int)$prop->Value;
		if($prop->Name == 'url') $url = $prop->Value;
        if ($prop->Name == 'mail') $mail = $prop->Value;
	}
}
?>
<div id="prop-{id}" class="component link hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.link_name') }}<small> - {{ __('interactivity.link_componentid') }}{id}</small></h3>
        <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    <!-- end component-header -->
    <div class="settings">
        <div class="component-panel">
            <h5 title="{{ __('interactivity.link_type_tooltip') }}" class="tooltip">{{ __('interactivity.link_type') }} <i class="icon-info-sign"></i></h5>
            <div class="radiogroup">
                <div class="radio {{ ($type == 1 ? 'checked ' : '') }}js-radio" optionvalue="1">{{ __('interactivity.link_option1') }}</div>
                <div class="radio {{ ($type == 2 ? 'checked ' : '') }}js-radio" optionvalue="2">{{ __('interactivity.link_option2') }}</div>
                <div class="radio {{ ($type == 3 ? 'checked ' : '') }}js-radio"
                     optionvalue="3">{{ __('interactivity.link_option3') }}</div>
                <input type="hidden" name="comp-{id}-type" id="comp-{id}-type" value="{{ $type }}" />
            </div>
            <div class="topage{{ ($type != 1 ? ' hide' : '') }}">
                <div class="inline">
                    <label for="comp-{id}-page">{{ __('interactivity.link_page') }}</label>
                    <select class="select js-select" name="comp-{id}-page" id="comp-{id}-page">
                        @for ($i = 1; $i <= $PageCount; $i++)
	                        <option value="{{ $i }}"{{ ($page == $i ? ' selected="selected"' : '') }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="tourl{{ ($type != 2 ? ' hide' : '') }}">
                <div class="text dark inline-primary">
                    <input type="text" name="comp-{id}-url" id="comp-{id}-url" placeholder="http://www.google.com" class="prefix" value="{{ $url }}">
                </div>
                <div class="inline-secondary"><a href="#" class="to-url btn btn-primary postfix"><i
                                class="icon-ok"></i></a></div>
                <span class="to-url success hide"><i
                            class="icon-ok-sign"></i>{{ __('interactivity.link_success') }}</span>
                <span class="to-url error hide"><i
                            class="icon-exclamation-sign"></i>{{ __('interactivity.link_error') }}</span>
            </div>
            <div class="tomail{{ ($type != 3 ? ' hide' : '') }}">
                <div class="text dark inline-primary">
                    <input type="text" name="comp-{id}-mail" id="comp-{id}-mail" placeholder="email@example.com"
                           class="prefix" value="{{ $mail }}">
                </div>
                <div class="inline-secondary"><a href="#" class="to-mail btn btn-primary postfix"><i
                                class="icon-ok"></i></a></div>
                <span class="to-mail success hide"><i
                            class="icon-ok-sign"></i>{{ __('interactivity.link_success') }}</span>
                <span class="to-mail error hide"><i
                            class="icon-exclamation-sign"></i>{{ __('interactivity.link_error') }}</span>
            </div>
        </div>
        <!-- end component-panel -->
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings --> 
    <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end link -->