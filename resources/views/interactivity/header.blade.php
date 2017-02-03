<header>
    <div id="topbar">
        <div id="logo"><img src="/img/logo.png" alt="Gale Press"></div>
        <div id="user-settings">
            <ul>
                <!--<li><a href="javascript:void(0);"><i class="icon-question-sign"></i>{{ __('interactivity.help') }}</a></li>-->
                <li>
                    <a href="javascript:void(0);" onclick="cInteractivity.openSettings();">
                        <i class="icon-download-alt"></i>{{ __('interactivity.import') }}
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" onclick="cInteractivity.exitWithoutSave();">
                        <i class="icon-backward"></i>{{ __('interactivity.back_to_panel') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div id="pdf-controls">
        <div id="full-screen"><a href="javascript:void(0);" onclick="toogleFullscreen();"><i class="icon-fullscreen"></i></a></div>
        <div id="thumbs">
            <div class="text dark">
                <input type="text" name="pdf-page" value="1/{{ count($pages) }}" id="pdf-page">
            </div>
            <div class="thumblist slideshow js-slideshow">
                <div class="show-slide prev js-slideshow-prev-slide"><i class="icon-chevron-left"></i></div>
                <div class="show-slide next js-slideshow-next-slide"><i class="icon-chevron-right"></i></div>
                <div class="slideshow-slides-wrapper">
                    <ul class="slideshow-slides js-slideshow-slides">
                    	@foreach($pages as $page)
                        	<li class="each-slide js-slideshow-slide">
                            	<a href="javascript:void(0);" class="img-tooltip" pageno="{{ $page->No }}"><img src="/{{ $page->FilePath }}/{{ $page->FileName }}" alt="{{ $page->No }}" title="{{ $page->No }}"><span>{{ $page->No }}</span></a>
							</li>
                        @endforeach
                    </ul>
                </div>
                <!-- end slider-wrapper --> 
            </div>
            <!-- end thumblist --> 
        </div>
        <!-- end thumbs --> 
    </div>
    <!-- end pdf-controls -->
    <div id="pdf-save">
        <div class="seperator"> </div>
        <p>{{$content->Name}}</p>
        <button id="saveAndExitBtn" class="btn btn-success btn-block"
                onclick="cInteractivity.saveAndClose();">{{ __('interactivity.saveandclose') }} </button>
        <div id="saveProgressBar" class="progress progress-striped active"
             style="display: none; margin: 0 0 0 0; height: 30px">
            <div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%"></div>
        </div>
        <span id="saveInfoTime" class="save-info"></span>
	</div>
</header>