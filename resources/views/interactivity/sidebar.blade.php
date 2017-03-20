<?php
$components = DB::table('Component')
        ->where('StatusID', '=', eStatus::Active)
        ->orderBy('DisplayOrder', 'ASC')
        ->get();
?>
<div class="sidebar">
    <div id="components">
        <div id="tab-container">
            <ul class="etabs">
                <li class="tab"><a href="#tabs-1">{{ __('interactivity.sidebar_tab1') }} <i class="icon-cog"></i></a>
                </li>
                <li class="tab"><a href="#tabs-2">{{ __('interactivity.sidebar_tab2') }} <i
                                class="icon-sitemap"></i></a></li>
            </ul>
            <div id="tabs-1" class="tab-element">
                <ul class="components">
                    @foreach($components as $component)
                        <li componentid="0" componentname="{{ $component->Class }}">
                            <a href="#"
                               id="comp-{{ $component->Class }}"><span>{{ __('interactivity.'.$component->Class . '_name') }}</span></a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- end tabs-1 -->
            <div id="tabs-2" class="tab-element">
                @include('interactivity.tree')
            </div>
            <!-- end tabs-2 -->
        </div>
        <!-- end tabs -->

        <div class="component-info">
            @foreach($components as $component)
                <div id="info-{{ $component->Class }}" class="invisible"
                     style='background: url("<?php echo __('filelang.drag-drop');?>") no-repeat center 80px #212121;'>
                    <h3><span></span>{{ __('interactivity.'.$component->Class . '_name') }}</h3>
                    <p>{{ __('interactivity.'.$component->Class.'_component_description') }}</p>
                </div>
            @endforeach
        </div>
        <!-- end component-info -->

        <form id="pagecomponents">
            {{ Form::token() }}
            <input type="hidden" id="included" name="included" value="{{ $included }}">
            <input type="hidden" id="contentfileid" name="contentfileid" value="{{ $ContentFileID }}">
            <input type="hidden" id="pageno" name="pageno" value="">
            <input type="hidden" id="closing" name="closing" value="false"/>

            <div id="component-container"></div>
        </form>
        <!-- end component-container -->
    </div>
    <!-- end components -->
</div>
<!-- end sidebar -->