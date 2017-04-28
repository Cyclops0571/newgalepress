@extends('layouts.master')

@section('content')

    <?php
    $ClientID = 0;
    $ApplicationID = 0;
    $Username = '';
    $Password = '';
    $Email = '';
    $FirstName = '';
    $LastName = '';
    $LastLoginData = '';
    $InvalidPasswordAttempts = 0;
    /* @var $applications Application */
    $applications;
    /* @var $contents Content */
    $contents;
    /* @var $row Client */
    if (isset($row)) {
        $ClientID = (int)$row->ClientID;
        $ApplicationID = (int)$row->ApplicationID;
        $Username = $row->Username;
        $Password = $row->Password;
        $Email = $row->Email;
        $FirstName = $row->Name;
        $LastName = $row->Surname;
        $LastLoginData = $row->LastLoginDate;
        $InvalidPasswordAttempts = $row->InvalidPasswordAttempts;
    }
    ?>
    <div class="col-md-12">
      <div class="block block-drop-shadow">
        <div class="header">
          <h2><?php echo __('common.detailpage_caption'); ?> </h2>
        </div>
        <div class="content controls">
          <form method="post" action="{{route('clients_save')}}">
              <?php echo Form::token(); ?>
            <input type="hidden" name="ClientID" id="ClientID" value="<?php echo $ClientID; ?>"/>
              <?php if (count($applications) > 1): ?>
            <div class="form-row">
              <div class="col-md-3">
                  <?php echo __('common.menu_caption_applications'); ?> <span class="error">*</span>
              </div>
              <div class="col-md-8">
                <select style="width: 100%;" tabindex="-1" id="ApplicationID" name="ApplicationID"
                        class="form-control select2 required">
                  <option value="" <?php echo $ApplicationID == 0 ? 'selected="selected"' : ''; ?> ></option>
                    <?php foreach ($applications as $app): ?>
                  <option
                      value="<?php echo $app->ApplicationID; ?>" <?php echo $ApplicationID == $app->ApplicationID ? 'selected="selected"' : ''; ?>>
                      <?php echo $app->Name; ?>
                  </option>
                    <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-1"><a class="tipr"
                                       title="<?php echo __('common.menu_caption_applications'); ?>"><span
                      class="icon-info-sign"></span></a></div>
            </div>
              <?php else: ?>
            <input type="hidden" name="ApplicationID" value="<?php echo $applications[0]->ApplicationID; ?>"/>
              <?php endif; ?>

            <div class="form-row">
              <div class="col-md-3"><?php echo __('common.clients_username'); ?> <span class="error">*</span>
              </div>
                <?php echo $errors->first('Username', '<p class="error">:message</p>'); ?>
              <div class="col-md-8">
                <input type="text" name="Username" id="Username" class="form-control textbox required"
                       value="<?php echo $Username; ?>" autocomplete="off"/>
              </div>
              <div class="col-md-1"><a class="tipr" title="<?php echo __('common.clients_username'); ?>"><span
                      class="icon-info-sign"></span></a></div>
            </div>
            <div class="form-row">
              <div
                  class="col-md-3"><?php echo __('common.clients_password'); ?><?php echo $ClientID == 0 ? ' <span class="error">*</span>' : ''; ?></div>
                <?php echo $errors->first('Password', '<p class="error">:message</p>'); ?>
              <div class="col-md-8">
                <input type="text" name="Password" id="Password"
                       class="form-control textbox<?php echo $ClientID == 0 ? ' required' : ''; ?>" value=""
                       autocomplete="off"/>
              </div>
              <div class="col-md-1"><a class="tipr"
                                       title="<?php echo __('common.clients_password_tooltip'); ?>"><span
                      class="icon-info-sign"></span></a></div>
            </div>
            <div class="form-row">
              <div class="col-md-3"><?php echo __('common.clients_firstname'); ?> <span class="error">*</span>
              </div>
                <?php echo $errors->first('FirstName', '<p class="error">:message</p>'); ?>
              <div class="col-md-8">
                <input type="text" name="FirstName" id="FirstName" class="form-control textbox required"
                       value="<?php echo $FirstName; ?>"/>
              </div>
              <div class="col-md-1"><a class="tipr"
                                       title="<?php echo __('common.clients_firstname'); ?>"><span
                      class="icon-info-sign"></span></a></div>
            </div>
            <div class="form-row">
              <div class="col-md-3"><?php echo __('common.clients_lastname'); ?> <span class="error">*</span>
              </div>
                <?php echo $errors->first('LastName', '<p class="error">:message</p>'); ?>
              <div class="col-md-8">
                <input type="text" name="LastName" id="LastName" class="form-control textbox required"
                       value="<?php echo $LastName; ?>"/>
              </div>
              <div class="col-md-1"><a class="tipr" title="<?php echo __('common.clients_lastname'); ?>"><span
                      class="icon-info-sign"></span></a></div>
            </div>
            <div class="form-row">
              <div class="col-md-3"><?php echo __('common.users_email'); ?> <span class="error">*</span></div>
                <?php echo $errors->first('Email', '<p class="error">:message</p>'); ?>
              <div class="col-md-8">
                <input type="text" name="Email" id="Email" class="form-control textbox required"
                       value="<?php echo $Email; ?>"/>
              </div>
              <div class="col-md-1"><a class="tipr" title="<?php echo __('common.users_email'); ?>"><span
                      class="icon-info-sign"></span></a></div>
            </div>
            <div class="form-row">
              <div class="col-md-6">
                <table id="selectedContents" cellpadding="0" cellspacing="0" width="100%"
                       class="table table-bordered table-striped table-hover mySortable">
                  <thead>
                  <tr>
                    <th>
                        <?php echo __("clients.selected_content_name"); ?>
                    </th>
                    <th>
                        <?php echo __("common.contents_list_content_id"); ?>
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($contents as $content): ?>
                  <?php /* @var $selectableContent Content */ ?>
                  <tr id="contentIDSet_<?php echo $content->ContentID; ?>">
                    <td>
                        <?php echo $content->Name; ?>
                    </td>
                    <td>
                        <?php echo $content->ContentID; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php if(empty($contents)): ?>
                  <tr id="contentIDSet_0">
                    <td colspan="2">
                        <?php echo __('clients.drop_contents_here'); ?>
                    </td>
                  </tr>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6 sortableDiv">
                  <?php if (!empty($selectableContents)): ?>
                <table id="selectableContents" cellpadding="0" cellspacing="0" width="100%"
                       class="table table-bordered table-striped table-hover mySortable">
                  <thead>
                  <tr>
                    <th>
                        <?php echo __("clients.selectable_content_name"); ?>
                    </th>
                    <th>
                        <?php echo __("common.contents_list_content_id"); ?>
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($selectableContents as $selectableContent): ?>
                  <?php /* @var $selectableContent Content */ ?>
                  <tr id="contentIDSet_<?php echo $selectableContent->ContentID; ?>">
                    <td>
                        <?php echo $selectableContent->Name; ?>
                    </td>
                    <td>
                        <?php echo $selectableContent->ContentID; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
                  <?php endif; ?>
              </div>
            </div>


            <div class="form-row">
              <div class="col-md-8"></div>
              <div class="col-md-2">
                  <?php if ($ClientID): ?>
                <a href="#modal_default_11" data-toggle="modal">
                  <input type="button" value="<?php echo __('common.detailpage_delete'); ?>" name="delete"
                         class="btn delete expand remove"/>
                </a>
                  <?php endif; ?>
              </div>
              <div class="col-md-2">
                <input type="button" class="btn my-btn-success" name="save"
                       value="<?php echo __('common.detailpage_save'); ?>"
                       onclick="cClient.save(<?php echo $ClientID; ?>);"/>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal modal-info" id="modal_default_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Silmek istediğinize emin misiniz?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-clean" data-dismiss="modal"
                    onclick="cClient.erase();"
                    style="background:#9d0000;"><?php echo __('common.detailpage_delete'); ?></button>
            <button type="button" class="btn btn-default btn-clean"
                    data-dismiss="modal"><?php echo __('common.contents_category_button_giveup'); ?></button>
          </div>
        </div>
      </div>
    </div>
    <!-- end form_content-->

    <script>
        $(function () {
            $(".mySortable").sortable({
                connectWith: '.mySortable',
                items: 'tbody > tr',
                receive: function (ev, ui) {
                    ui.item.parent().find('tbody').append(ui.item);
                    $("#contentIDSet_0").remove();
                }
            }).disableSelection();
        });

        // USER
        var cClient = new function () {
            var _self = this;
            this.objectName = "clients";

            this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
                cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
            };

            this.save = function (clientID) {
                var contentIDSet = "&" + $('#selectedContents').sortable("serialize");
                var fsuccess = undefined;
                if (clientID === 0) {
                    fsuccess = function (ret) {
                        cNotification.success();
                        window.location = '/' + currentLanguage + '/' + route[_self.objectName] + '/' + ret.getValue("id");
                    };
                }
                cCommon.save(this.objectName, fsuccess, undefined, contentIDSet);
            };

            this.erase = function () {
                cCommon.erase(this.objectName);
            };

        };
    </script>
@endsection