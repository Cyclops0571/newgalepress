<div class="tree">
    <h5 title="{{ __('interactivity.sidebar_tab2_tooltip') }}" class="tooltip">{{ __('interactivity.sidebar_tab2_description') }} <i class="icon-info-sign"></i></h5>
    <ul>
    	<?php
		$pagess = DB::table('ContentFilePage')
			->where('ContentFileID', '=', $ContentFileID)
			->raw_where('(SELECT COUNT(*) FROM `PageComponent` WHERE ContentFilePageID=`ContentFilePage`.ContentFilePageID AND StatusID=1) > 0')
			->where('StatusID', '=', eStatus::Active)
			->orderBy('No', 'ASC')
			->get();
		?>
        @foreach($pagess as $page)
        <li data-collapse="" class="page" pageno="{{ $page->No }}">
            <a href="javascript:void(0);"><i class="icon-"></i>{{ __('interactivity.page') }} {{ $page->No }}</a>
            <ul class="close">
				<?php
				$comps = DB::table('Component')
					->raw_where('ComponentID IN (SELECT ComponentID FROM `PageComponent` WHERE ContentFilePageID='.(int)$page->ContentFilePageID.' AND StatusID=1)')
					->where('StatusID', '=', eStatus::Active)
					->orderBy('DisplayOrder', 'ASC')
					->get();
				?>
                @foreach($comps as $comp)
                <li data-collapse="" class="component" componentname="{{ $comp->Class }}">
                    <a href="javascript:void(0);" id="tree-{{ $comp->Class }}"><i class="icon-"></i>{{ __('interactivity.'.$comp->Class.'_name') }}</a>
                    <ul class="close">
                    	<?php
						$pcs = DB::table('PageComponent')
							->where('ContentFilePageID', '=', $page->ContentFilePageID)
							->where('ComponentID', '=', $comp->ComponentID)
							->where('StatusID', '=', eStatus::Active)
							->orderBy('No', 'ASC')
							->get();
						?>
                    	@foreach($pcs as $pc)
                    		<li componentid="{{ $pc->No }}" style="position:relative;">
                                <a href="javascript:void(0);" class="selectcomponent" componentid="{{ $pc->No }}">{{ __('interactivity.'.$comp->Class.'_componentid').$pc->No }}</a>
                                <i class="icon-exchange transfer" onclick="cInteractivity.openTransferModal($(this));"></i>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
            <i class="icon-exchange transfer" onclick="cInteractivity.openTransferModal($(this));"></i>
        </li>
        @endforeach
    </ul>
    <a href="javascript:void(0);" class="delete-all-components" onclick="cInteractivity.deleteComponentOnCurrentPage();">{{ __('interactivity.sidebar_delete_all') }}</a>
</div>
<!-- end tree -->