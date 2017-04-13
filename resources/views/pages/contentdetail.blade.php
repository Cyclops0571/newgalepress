@extends('layouts.master')

@section('content')

    <?php

    /** @var App\Models\Application $app */
    /** @var App\Models\Content $content */
    $ContentID = (int)$content->ContentID;
    $Name = e($content->Name);
    $Detail = $content->Detail;
    $MonthlyName = $content->MonthlyName;
    $PublishDate = $content->PublishDate;
    $UnpublishDate = $content->UnpublishDate;
    $IsUnpublishActive = $content->IsUnpublishActive;
    $IsProtected = (int)$content->IsProtected;
    $Password = $content->Password;
    $IsBuyable = (int)$content->IsBuyable;
    $CurrencyID = (int)$content->CurrencyID;
    $IsMaster = (int)$content->IsMaster;
    $Orientation = (int)$content->Orientation;
    $Identifier = $content->getIdentifier();
    $AutoDownload = (int)$content->AutoDownload;
    $Approval = (int)$content->Approval;
    $Blocked = (int)$content->Blocked;
    $Status = (int)$content->Status;
    $Version = (int)$content->Version;


    /** @var App\Models\ContentFile $ContentFile */
    $ContentFile = $content->ContentFile()
        ->getQuery()
        ->where('StatusID', '=', eStatus::Active)
        ->orderBy('ContentFileID', 'DESC')
        ->take(1)->first();

    if ($ContentFile)
    {
        $ContentFileID = (int)$ContentFile->ContentFileID;
        $Transferable = True;
        $Transferred = $ContentFile->Transferred == 1;
    }

    if ($IsMaster == 1)
    {
        $IsProtected = 0;
        $Password = '';
    }

    ?>
    <iframe id="interactivity" class="interactivity"></iframe>
    <form method="post" enctype="multipart/form-data" action="{{route('contents_save')}}">
      {{csrf_field()}}
      <div class="col-md-9" style="padding-left:25px;">
        <div class="block">
          <div class="header">
            <h2>{{ __('common.detailpage_caption') }}</h2>
          </div>
          <div class="content controls" style="overflow:visible">

            @if(!$authMaxPDF)
              <script type="text/javascript">
                  $(function () {
                      cNotification.failure(notification["auth_max_pdf"]);
                  });</script>
            @endif

            <input type="hidden" name="ContentID" id="ContentID" value="{{ $ContentID }}"/>
            @if((int)Auth::user()->UserTypeID == eUserTypes::Customer)
              <input type="hidden" name="ApplicationID" id="ApplicationID" value="{{ $app->ApplicationID }}"/>
            @endif
            <div class="form-row">
              <div class="col-md-3">
                <label class="label-grey" for="Name">{{ __('common.contents_name') }}</label>
                <span class="error">*</span>
              </div>
              <div class="col-md-8">
                <input type="text" name="Name" id="Name" class="form-control textbox required" value="{{ $Name }}"/>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_name') }}">
                  <span class="icon-info-sign"></span>
                </a>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-3">
                <label class="label-grey" for="Detail">{{ __('common.contents_detail') }}</label>
              </div>
              <div class="col-md-8">
                <textarea class="form-control" name="Detail" id="Detail" rows="2" cols="15">{{ $Detail }}</textarea>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_detail') }}"><span class="icon-info-sign"></span>
                </a>
              </div>
            </div>
              <?php if($app->TopicStatus == eStatus::Active && count($app->ApplicationTopics)): ?>
            <div class="form-row">
              <div class="col-md-3">
                <label class="label-grey" for="topicIds">{{ __('applicationlang.application_category') }}</label>
              </div>
              <div class="col-md-8">
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" name="topicStatus"
                               <?php echo $content->TopicStatus || !$content->ContentID ? 'checked="checked"' : ''?>id="topicStatus">
                      </span>
                  <select id="topicIds" name="topicIds[]" multiple="multiple" class="chosen-container">
                      <?php
                      $contentTopicIds = array_map(function ($o)
                      {
                          return $o->TopicID;
                      }, $content->ContentTopics);
                      foreach($app->ApplicationTopics as $applicationTopic):?>
                      <?php $selected = in_array($applicationTopic->TopicID, $contentTopicIds) || !$content->ContentID ? ' selected="selected"' : '';?>
                    <option value="<?php echo $applicationTopic->TopicID ?>" <?php echo $selected; ?> >
                        <?php echo $applicationTopic->Topic->Name; ?>
                    </option>
                      <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_status') }}">
                  <span class="icon-info-sign"></span>
                </a>
              </div>
            </div>
              <?php endif; ?>

            <div class="form-row">
              <div class="col-md-3">
                <label class="label-grey" for="CategoryID">{{ __('common.contents_category') }}</label>
                <a href="#" class="widget-icon widget-icon-circle" onclick="cContent.showCategoryList();" data-toggle="modal">
                  <span class="icon-pencil"></span>
                </a>
              </div>
              <div class="col-md-8">
                <select id="CategoryID" name="chkCategoryID[]" multiple="multiple" class="chosen-container required">
                  @if(count($content->ContentCategory) == 0 || $content->hasContentCategory(0))
                    <option value="" selected="selected">{{ __('common.contents_category_list_general') }}</option>
                  @else
                    <option value="">{{ __('common.contents_category_list_general') }}</option>
                  @endif
                    <?php foreach ($categories as $category): ?>
                  <option value="{{ $category->CategoryID }}"{{ ($content->hasContentCategory($category->CategoryID) ? ' selected="selected"' : '') }}>{{ $category->Name }}</option>
                    <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_category') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-3">
                <label class="label-grey" for="MonthlyName">{{ __('common.contents_monthlyname') }}</label>
              </div>
              <div class="col-md-8">
                <input type="text" name="MonthlyName" id="MonthlyName" class="form-control textbox"
                       value="{{ $MonthlyName }}"/>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_monthlyname') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
            <div class="form-row" style="background: none !important;">
              <div class="col-md-3 ">
                <label class="label-grey" for="PublishDate">{{ __('common.contents_publishdate') }}</label>
              </div>
              <div class="col-md-8">
                <div class="input-group">
                  <div class="input-group-addon"><span class="icon-calendar"></span></div>
                  <input type="text" name="PublishDate" id="PublishDate" class="form-control textbox date"
                         value="<?php echo Common::dateRead($PublishDate, 'd.m.Y'); ?>"/>
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_publishdate') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
            <div class="form-row" style="background: none !important;">
              <div class="col-md-3 ">
                <label class="label-grey" for="UnpublishDate">
                  {{ __('common.contents_unpublishdate') }}
                </label>
              </div>
              <div class="col-md-8">
                <div class="input-group">
                  <div class="input-group-addon"><span class="icon-calendar"></span></div>
                  <input type="text" name="UnpublishDate" id="UnpublishDate"
                         class="form-control textbox date {{ ((int)$IsUnpublishActive == 1 ?  '' : ' disabledFields') }}"
                         value="{{ Common::dateRead($UnpublishDate, 'd.m.Y') }}" {{ ((int)$IsUnpublishActive == 1 ?  '' : ' disabled="disabled"') }} />
                  <span class="input-group-addon">
							<input type="checkbox" title="{{ __('common.contents_unpublishdate') }}" name="IsUnpublishActive"
                     id="IsUnpublishActive" value="1"{{ ((int)$IsUnpublishActive == 1 ? ' checked="checked"' : '') }} />
						</span>
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_unpublishdate') }}">
                  <span class="icon-info-sign"></span>
                </a>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-3">
                {{ __('common.contents_file') }}
                {!! $ContentID == 0 ? ' <span class="error">*</span>' : '' !!}
              </div>
              <div class="col-md-3" id="contentPdfFile">
                <input type="file" name="File" class="btn btn-mini hidden" id="File" style="opacity:0;"/>
                <script type="text/javascript">
                    $('#File').ready(function () {
                        $('#File').css('opacity', '1');
                    });
                </script>

                <div id="FileButton" class="uploadify hide" style="height: 30px; width: 120px; opacity: 1;">
                  <div id="File-button" class="uploadify-button "
                       style="height: 30px; line-height: 30px; width: 120px;">
                    <span class="uploadify-button-text">{{ __('common.contents_file_select') }}</span>
                  </div>
                </div>

                <div id="FileProgress" class="myProgress hide">
                  <a href="#">{{ __('interactivity.cancel') }}
                    <i class="icon-remove"></i>
                  </a>
                  <label for="scale">0%</label>

                  <div class="scrollbox dot">
                    <div class="scale" style="width: 0"></div>
                  </div>
                </div>

                <input type="hidden" name="hdnFileSelected" id="hdnFileSelected" value="0"/>
                <input type="hidden" name="hdnFileName" id="hdnFileName" {!! $ContentID == 0 ? ' class="required"' : ''  !!} />
              </div>
              <div class="col-md-5" style="padding-top:2px;">
                @if($ContentID > 0 && $ContentFile && $authInteractivity && $Transferable)
                  <div class="checkbox-inline">
                    <input type="checkbox" name="Transferred" id="Transferred" value="1" checked="checked"/>
                  </div>
                  <label class="label-grey" for="Transferred">{{ __('common.contents_transfer') }}</label>
                @endif
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_file') }}">
                  <span class="icon-info-sign"></span>
                </a>
              </div>
            </div>
            @if($ContentFile && $authInteractivity)
              <div class="form-row">
                <div class="col-md-3" style="padding-top:8px;">
                  {{ __('common.contents_file_interactive_label') }}
                </div>
                <div class="col-md-8" id="contentPdfButton">
                  <section>
                    <a href="{{route('interactivity_show', $ContentFileID)}}"
                       onclick="cContent.openInteractiveIDE({{ $ContentFileID }});" id="btn_interactive">&#xF011;</a>
                    <span></span>
                  </section>
                </div>
                <div class="col-md-1" style="padding-top: 8px">
                  <a class="tipr" title="{{ __('common.contents_tooltip_interactive') }}">
                    <span class="icon-info-sign"></span>
                  </a>
                </div>
              </div>
                  <?php if($ContentFile->Interactivity == Interactivity::ProcessQueued): ?>
              <div class="form-row">
                <div class="col-md-3">{{__('interactivity.interactivity_status')}}</div>
                <div class="col-md-8">
                    <?php if($ContentFile->HasCreated == 1): ?>
                  <div class="process">
                    <div id="interactivityStatus" class="progress-bar progress-bar-success" style="width: 100%">
                      <span><?php echo __('common.contents_interactive_file_has_been_created'); ?></span>
                    </div>
                  </div>
                    <?php else: ?>
                  <div id="interactivityStatus" class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%">
                        <?php echo __('common.contents_interactive_file_hasnt_been_created'); ?>
                    </div>
                  </div>
                  <script type="text/javascript">
                      cContent.checkInteractivityStatus('{{$ContentFile->ContentFileID}}' , '#interactivityStatus', '{{__('common.contents_interactive_file_has_been_created')}}');
                  </script>
                    <?php endif; ?>
                </div>
                <div class="col-md-1">
                  <a class="tipr" title="{{ __('interactivity.interactivity_status_tooltip') }}">
                    <span class="icon-info-sign"></span>
                  </a>
                </div>
              </div>
                  <?php endif; ?>
              @if(sizeof($contentList)>0)
                <div class="form-row">
                  <div class="col-md-3">
                    <label for="AppContents" class="label-grey">
                      {{ __('common.contents_interactivity_copy_title') }}
                    </label>
                  </div>
                  <div class="col-md-4">
                    <select data-placeholder="{{ __('common.contents_interactivity_target') }}" style="width: 100%;"
                            tabindex="-1" id="AppContents" name="AppContents" class="form-control select2">
                      <option value="">{{ __('common.contents_interactivity_target') }}</option>
                      @foreach ($contentList as $cList)
                        <option value="{{ $cList->ContentID }}">{{ $cList->Name }}
                          @if((int)Auth::user()->UserTypeID == eUserTypes::Manager)
                            <i> -> AppID:{{ $cList->ApplicationID }}</i>
                          @endif
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-1">
                    <img src="/img/interactivityCopyArrow.png"/>
                  </div>
                  <div class="col-md-3">
                    <input type="button" value="{{ __('common.contents_interactivity_target_copy') }}"
                           class="btn my-btn-send" onclick="cContent.copyInteractivity();"
                           style="max-height:33px; margin-top:-1px;"/>
                  </div>
                  <div class="col-md-1">
                    <a class="tipr" title="{{ __('common.contents_interactivity_copy_info') }}"><span
                          class="icon-info-sign"></span></a>
                  </div>
                </div>
              @endif
            @endif
              <?php if($ContentFile): ?>
            <div class="form-row">
              <div class="col-md-3"><?php echo __('interactivity.download_original_pdf'); ?></div>
              <div class="col-md-8">
                <a href="<?php echo $ContentFile->pdfOriginalLink();?>" download="mypdf.pdf">
                  <img width="24px" height="24px" src="/img/cloud-download-32x32.svg"/>
                </a>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('interactivity.download_original_pdf_tooltip') }}">
                  <span class="icon-info-sign"></span>
                </a>
              </div>
            </div>
              <?php endif; ?>

          </div>
        </div>
        <div class="block">
          <div class="content controls" style="overflow:visible">
            <div class="form-row">
              <div class="col-md-3">
                <label for="Orientation" class="label-grey">
                  {{ __('common.contents_orientation') }}
                </label>
              </div>
              <div class="col-md-8">
                <select style="width: 100%;" tabindex="-1" id="Orientation" name="Orientation"
                        class="form-control select2">
                  <option
                      value="0"{{ ($Orientation == 0 ? ' selected="selected"' : '') }}>{{__('common.contents_landscape_portrait')}}</option>
                  <option
                      value="1"{{ ($Orientation == 1 ? ' selected="selected"' : '') }}>{{__('common.contents_landscape')}}</option>
                  <option
                      value="2"{{ ($Orientation == 2 ? ' selected="selected"' : '') }}>{{__('common.contents_portrait')}}</option>
                </select>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_orientation') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
          </div>
        </div>
        <div class="block">
          <div class="content controls" style="overflow:visible">
            <div class="form-row">
              <div class="col-md-3">
                <label for="IsMaster" class="label-grey">
                  {{ __('common.contents_ismaster') }}
                </label>
              </div>
              <div class="col-md-8">
                <div class="checkbox-inline">
                  <input type="checkbox" name="IsMaster" id="IsMaster"
                         value="1"{{ ((int)$IsMaster == 1 ? ' checked="checked"' : '') }} />
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_ismaster') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
          </div>
        </div>

        <div class="block {{ ((int)$IsMaster == 1 ? 'disabledFields' : '') }}">
          <div class="content controls" style="overflow:visible">
            <div class="form-row">
              <div class="col-md-3">
                <label for="IsProtected" class="label-grey">
                  {{ __('common.contents_isprotected') }}
                </label>
              </div>
              <div class="col-md-8">
                <div class="checkbox-inline">
                  <input type="checkbox" name="IsProtected" id="IsProtected"
                         value="1"{{ ((int)$IsProtected == 1 ? ' checked="checked"' : '') }} {{ ((int)$IsMaster == 1 ? 'disabled="disabled"' : '') }}/>
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_isprotected') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-3">
                <label for="Password" class="label-grey">
                  {{ __('common.contents_password') }}
                </label>
                <a href="#" class="widget-icon widget-icon-circle"
                   onclick="cContent.showPasswordList();" data-toggle="modal"><span class="icon-group"></span></a>
              </div>
              <div class="col-md-8">
                <input type="password" name="Password" id="Password" class="form-control textbox"
                       value="" {{ ((int)$IsMaster == 1 ? 'disabled="disabled"' : '') }}/>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_password') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
          </div>
        </div>
          <?php if($app->InAppPurchaseActive):?>
        <div class="block">
          <div class="content controls" style="overflow:visible">
            <div class="form-row <?php echo ($ContentID && $IsBuyable) > 0 ? "" : 'disabledFields hide' ?>">
              <div class="col-md-3">
                <label for="ContentIdentifier" class="label-grey">
                  {{ __('common.contents_identifier') }}
                </label>
              </div>
              <div class="col-md-8">
                <div class="input-group">
                  <input type="text" id="ContentIdentifier" value="<?php echo $Identifier; ?>" readonly="readonly">
                  <span class="input-group-btn">
							<button class="btn btn-primary urlCheck" type="button"
                      onclick="cContent.refreshIdentifier(<?php echo $ContentID; ?>);">
                                <span class="icon-refresh"></span>
                            </button>
						</span>
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_identifier') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-3">
                <label for="IsBuyable" class="label-grey">
                  {{ __('common.contents_isbuyable') }}
                </label>
              </div>
              <div class="col-md-8">
                <div class="checkbox-inline">
                  <input type="checkbox" name="IsBuyable" id="IsBuyable"
                         value="1"{{ ((int)$IsBuyable == 1 ? ' checked="checked"' : '') }} />
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_isbuyable') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
            <div class="form-row disabledFields hide">
              <div class="col-md-3">
                <label for="CurrencyID" class="label-grey">
                  {{ __('common.contents_currency') }}
                </label>
              </div>
              <div class="col-md-8">
                <select id="CurrencyID" name="CurrencyID" disabled class="form-control select2" style="width: 100%;"
                        tabindex="-1">
                  <option
                      value=""{{ ($CurrencyID == 0 ? ' selected="selected"' : '') }}>{{ __('common.reports_select') }}</option>
                  @foreach ($groupCodes as $groupCode)
                    <option
                        value="{{ $groupCode->GroupCodeID }}"{{ ($CurrencyID == $groupCode->GroupCodeID ? ' selected="selected"' : '') }}>{{ $groupCode->DisplayName }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_currency') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
          </div>
        </div>

          <?php endif;?>
        <div class="block disabledFields hide">
          <div class="content controls" style="overflow:visible">
            <div class="form-row">
              <div class="col-md-3">
                <label for="AutoDownload" class="label-grey">
                  {{ __('common.contents_autodownload') }}
                </label>
              </div>
              <div class="col-md-8">
                <div class="checkbox-inline">
                  <input type="checkbox" name="AutoDownload" disabled id="AutoDownload"
                         value="1"{{ ((int)$AutoDownload == 1 ? ' checked="checked"' : '') }} />
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_autodownload') }}"><span
                      class="icon-info-sign"></span></a>
              </div>
            </div>
          </div>
        </div>
        <div class="block">
          <div class="content controls" style="overflow:visible">
            @if((int)Auth::user()->UserTypeID == eUserTypes::Manager)
              <div class="form-row">
                <div class="col-md-3">
                  <label for="Approval" class="label-grey">
                    {{ __('common.contents_approval') }}
                  </label>
                </div>
                <div class="col-md-8">
                  <div class="checkbox-inline">
                    <input type="checkbox" name="Approval" id="Approval"
                           value="1"{{ ((int)$Approval == 1 ? ' checked="checked"' : '') }} />
                  </div>
                </div>
                <div class="col-md-1">
                  <a class="tipr" title="{{ __('common.contents_tooltip_approval') }}"><span
                        class="icon-info-sign"></span></a>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-3">
                  <label for="Blocked" class="label-grey">
                    {{ __('common.contents_blocked') }}
                  </label>
                </div>
                <div class="col-md-8">
                  <div class="checkbox-inline">
                    <input type="checkbox" name="Blocked" id="Blocked"
                           value="1"{{ ((int)$Blocked == 1 ? ' checked="checked"' : '') }} />
                  </div>
                </div>
                <div class="col-md-1">
                  <a class="tipr" title="{{ __('common.contents_tooltip_blocked') }}"><span
                        class="icon-info-sign"></span></a>
                </div>
              </div>
            @endif
            <div class="form-row">
              <div class="col-md-3">
                <label for="Status" class="label-grey">
                  {{ __('common.contents_status') }}
                </label>
              </div>
              <div class="col-md-8">
                <div class="checkbox-inline">
                  <input type="checkbox" name="Status" id="Status"
                         value="1"{{ ((int)$Status == 1 ? ' checked="checked"' : '') }} />
                </div>
              </div>
              <div class="col-md-1">
                <a class="tipr" title="{{ __('common.contents_tooltip_status') }}">
                  <span class="icon-info-sign"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="block">
          <div class="content controls" style="overflow:visible">
            <div class="form-row">
				<span class="command">
					@if($ContentID == 0)
            <div class="col-md-offset-9 col-md-2">
                            <input type="button" class="btn my-btn-success" name="save"
                                   value="{{ __('common.detailpage_save') }}" onclick="cContent.save();"/>
                        </div>
          @else
            <div class="col-md-offset-3 col-md-5">
                            <a href="#modal_default_11" class="btn delete expand remove" style="width:100%;"
                               data-toggle="modal">{{ __('content.remove_from_mobile_device') }}</a>
                        </div>
            <div class="col-md-2">
                            <a href="#modal_default_10" class="btn delete expand remove" style="width:100%;"
                               data-toggle="modal">{{ __('common.detailpage_delete') }}</a>
                        </div>
          <!--<div class="col-md-2">
                            <input type="button" value="{{ __('common.contents_copy_btn') }}" class="btn my-btn-send"
                                   onclick="cContent.copy();"/>
                        </div> -->
            <div class="col-md-2">
                            <input type="button" class="btn my-btn-success" name="save"
                                   value="{{ __('common.detailpage_update') }}" onclick="cContent.save();"/>
                        </div>
          @endif
				</span>
            </div>
          </div>
        </div>
      </div>
      <div class="rightbar col-md-3 {{ ($ContentID == 0 ? ' hidden' : '') }}">
        <div class="block bg-light">
          <div class="content controls" style="overflow:visible">
            <div class="form-row">
              <div class="header">
                <h2 class="header" style="text-align:center;">{{ __('common.contents_coverimage') }}</h2>
              </div>
              <div class="form-row" id="areaCoverImg" style="text-align:center;">
                <a href="#dialog-cover-image" data-toggle="modal">
                  <img class="coverImage" id="imgPreview"
                       src="{{route('contents_request', array('RequestTypeID' => eRequestType::NORMAL_IMAGE_FILE, 'ContentID'=>$ContentID , 'W' => 768, 'H' => 1024))}}"
                       width="200"/>
                </a>
              </div>
                <?php if($ContentID): ?>
              <div class="fileupload_container text-center">
                <div class="input-group file" style="margin: 0 auto; display:inline-block;">
                  <input type="file" name="CoverImageFile" id="CoverImageFile" class="hidden"/>

                  <div id="CoverImageFileButton" class="uploadify hide" style="height: 30px; width: 120px; opacity: 1;">
                    <div id="File-button" class="uploadify-button "
                         style="height: 30px; line-height: 30px; width: 120px;">
                      <span class="uploadify-button-text">{{ __('common.contents_coverimage_select') }}</span>
                    </div>
                  </div>
                  <div id="CoverImageFileProgress" class="myProgress hide">
                    <a href="#">
                      {{ __('interactivity.cancel') }} <i class="icon-remove"></i>
                    </a>
                    <label for="scale">0%</label>
                    <div class="scrollbox dot">
                      <div class="scale" style="width: 0"></div>
                    </div>
                  </div>
                </div>
              </div>
                <?php endif; ?>
              <input type="hidden" name="hdnCoverImageFileSelected" id="hdnCoverImageFileSelected" value="0"/>
              <input type="hidden" name="hdnCoverImageFileName" id="hdnCoverImageFileName" value=""/>
            </div>
          </div>
        </div>
      </div>
    </form>

    <div class="modal" id="dialog-category-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ __('common.contents_category_title') }}</h4>
          </div>
          <div class="list_container">
            <table class="table table-bordered table-striped table-hover">
              <colgroup>
                <col/>
                <col width="100px"/>
              </colgroup>
              <thead>
                <tr>
                  <th>{{ __('common.contents_category_column2') }}</th>
                  <th>{{ __('common.contents_category_column3') }}</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="cta_container">
            <div class="modal-footer modal-footer-categoryList">
              <div class="col-md-5" style="float:right;">
                <input type="button" value="{{ __('common.contents_category_new') }}" class="btn my-btn-default"
                       onclick="cContent.addNewCategory();"/>
              </div>
            </div>
          </div>
          <div class="form_container hidden">
            <form method="post" action="{{route('categories_save')}}">
              {{csrf_field()}}
              <input type="hidden" name="CategoryCategoryID" id="CategoryCategoryID" value=""/>
              <input type="hidden" name="CategoryApplicationID" id="CategoryApplicationID" value=""/>

              <div class="modal-footer modal-footer-categoryList">
                <div class="form-row">
                  <div class="col-md-4">
                    <label for="CategoryName">{{ __('common.contents_category_name') }}</label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="CategoryName" id="CategoryName" class="form-control textbox required"
                           value=""/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4" style="float:right;">
                    <input type="button" value="{{ __('common.detailpage_save') }}" class="btn my-btn-success"
                           onclick="cContent.saveCategory();"/>
                  </div>
                  <div class="col-md-4" style="float:right;">
                    <input type="button" value="{{ __('common.contents_category_button_giveup') }}"
                           class="btn my-btn-default" onclick="cContent.giveup();"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="dialog-password-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ __('common.contents_password_title') }}</h4>
          </div>
          <div class="list_container">
            <table class="table table-bordered table-striped table-hover">
              <colgroup>
                <col/>
                <col/>
                <col/>
              </colgroup>
              <thead>
                <tr>
                  <th>{{ __('common.contents_password_column2') }}</th>
                  <th>{{ __('common.contents_password_column3') }}</th>
                  <th>{{ __('common.contents_password_column4') }}</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="cta_container">
            <div class="modal-footer modal-footer-categoryList">
              <div class="col-md-5" style="float:right;">
                <input type="button" value="{{ __('common.contents_password_new') }}" class="btn my-btn-default"
                       onclick="cContent.addNewPassword();"/>
              </div>
            </div>
          </div>
          <div class="form_container hidden">
            <form method="post" action="{{route('categories_save')}}">
              {{csrf_field()}}


              <input type="hidden" name="ContentPasswordID" id="ContentPasswordID" value=""/>
              <input type="hidden" name="ContentPasswordContentID" id="ContentPasswordContentID" value=""/>

              <div class="modal-footer modal-footer-categoryList">
                <div class="form-row">
                  <div class="col-md-4">
                    <label for="ContentPasswordName">{{ __('common.contents_password_name') }}</label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="ContentPasswordName" id="ContentPasswordName"
                           class="form-control textbox required" value=""/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4">
                    <label for="ContentPasswordPassword">{{ __('common.contents_password_pwd') }}</label>
                  </div>
                  <div class="col-md-8">
                    <input type="password" name="ContentPasswordPassword" id="ContentPasswordPassword"
                           class="form-control textbox required" value=""/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4">
                    <label for="ContentPasswordQty">{{ __('common.contents_password_qty') }}</label>
                  </div>
                  <div class="col-md-8">
                    <input type="number" name="ContentPasswordQty" id="ContentPasswordQty"
                           class="form-control textbox required" value=""/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4" style="float:right;">
                    <input type="button" value="{{ __('common.detailpage_save') }}" class="btn my-btn-success"
                           onclick="cContent.savePassword();"/>
                  </div>
                  <div class="col-md-4" style="float:right;">
                    <input type="button" value="{{ __('common.contents_password_button_giveup') }}"
                           class="btn my-btn-default" onclick="cContent.giveup();"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="dialog-target-content-warning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><span class="icon-warning-sign"
                                          style="color:#ebaf3c;"></span>&nbsp;{{ __('common.contents_interactivity_copy_modal_title') }}
            </h4>
          </div>
          <div class="modal-body">
            {{ __('common.contents_interactivity_copy_modal_body') }}
          </div>
          <div class="modal-footer">
            <div class="col-md-5" style="float:right;">
              <input type="button" value="{{ __('common.contents_category_warning_ok') }}" class="btn my-btn-default"
                     data-dismiss="modal"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="dialog-category-warning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><span class="icon-warning-sign"
                                          style="color:#ebaf3c;"></span> {{ __('common.contents_category_warning_title') }}
            </h4>
          </div>
          <div class="modal-body">
            {{ __('common.contents_category_warning_content') }}
          </div>
          <div class="modal-footer">
            <div class="col-md-5" style="float:right;">
              <input type="button" value="{{ __('common.contents_category_warning_ok') }}" class="btn my-btn-default"
                     data-dismiss="modal"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-info" id="modal_default_10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ __('common.contents_delete_question') }}</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-clean" data-dismiss="modal" onclick="cContent.erase();"
                    style="background:#9d0000;">{{ __('common.detailpage_delete') }}</button>
            <button type="button" class="btn btn-default btn-clean"
                    data-dismiss="modal">{{ __('common.contents_category_button_giveup') }}</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-info" id="modal_default_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{ __('content.remove_mobile_question') }}</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-clean" data-dismiss="modal"
                    onclick="cContent.removeFromMobile(<?php echo $ContentID; ?>);"
                    style="background:#9d0000;">{{ __('common.detailpage_remove') }}</button>
            <button type="button" class="btn btn-default btn-clean"
                    data-dismiss="modal">{{ __('common.contents_category_button_giveup') }}</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="dialog-cover-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
         aria-hidden="true" style="display:none;">
      <div class="modal-dialog flip-container">
        <div class="flip-container">
          <div class="front" style="transform: rotateY(90deg);">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-left">
                                <span class="icon-crop"
                                      style="color:#1681bf; font-size:18px;"></span> {{ __('common.crop_coverimage_title') }}
                </h4>
              </div>
              <div id="coverImageModalBody" class="modal-body">
                <iframe id="coverImageIframe"
                        src="<?php echo '/' . app()->getLocale() . '/crop/image?contentID=' . $ContentID ?>"
                        scrolling="no" frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="content-buyable-warning" tabindex="-1" role="dialog" aria-labelledby="content-buyable-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{__('content.buyable_warning_title')}}</h4>
          </div>
          <div class="modal-body">
            {{__('content.buyable_warning_body')}}
          </div>
          <div class="modal-footer">
            <div class="col-md-7"></div>
            <div class="col-md-5">
              <input type="button" value="{{ __('common.contents_category_warning_ok') }}" class="btn my-btn-default"
                     data-dismiss="modal"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
        var showBuyableModal = {{json_encode(!$IsBuyable)}};
        var showCropPage = {{json_encode($showCropPage)}};
        $(function () {
            var ContentID = parseInt($("#ContentID").val());
            var dialogCoverImage = $('#dialog-cover-image');
            var coverImageIframe = $('#coverImageIframe');
            var coverImageModalBody = $('#coverImageModalBody');
            $("#CategoryID, #topicIds").chosen({
                placeholder_text_single: javascriptLang['select'],
                placeholder_text_multiple: javascriptLang['select'],
                no_results_text: javascriptLang['no_results'],
            });

            $('#topicIds').prop('disabled', !$('#topicStatus').is(':checked')).trigger('chosen:updated');
            $('#topicStatus').on('click', function () {
                $('#topicIds').prop('disabled', !$('#topicStatus').is(':checked')).trigger('chosen:updated');
            });
            var inputGroup = $('.input-group');
            inputGroup.find('.chosen-container').css({"height": "100%"});
            inputGroup.find('.chosen-choices').css({"border": "1px solid rgba(0, 0, 0, 0)", "border-radius": "3px"});
            inputGroup.find('.search-field').css("margin", "3px 0 1px 3px");

            cContent.addFileUpload();
            cContent.addImageUpload();
            if (ContentID == 0) {
                $('#areaCoverImg').addClass('noTouch');
            }
            coverImageIframe.load(function () {
                $('#coverImageModalBody').css('height', coverImageIframe.contents().find('.jcrop-holder').height() + 55 + 'px');
            });

            dialogCoverImage.on('shown.bs.modal', function () {
                if (ContentID > 0) {
                    coverImageIframe.attr('iframeContentID', ContentID);
                }
                dialogCoverImage.find('.front').css('transform', 'rotateY(360deg)');
            }).on('hidden.bs.modal', function () {
                dialogCoverImage.find('.front').css('transform', 'rotateY(90deg)');
            });
            if (showCropPage == 'showImageCrop') {
                dialogCoverImage.modal('show');
                coverImageIframe.attr("iframeContentID", ContentID);
            }

            $('#IsBuyable').click(function () {
                if ($(this).is(':checked') && showBuyableModal) {
                    showBuyableModal = false;
                    $('#content-buyable-warning').modal('show');
                }
            });

        })
    </script>
@endsection