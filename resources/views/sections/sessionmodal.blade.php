<div class="modal in" id="modalWarning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; z-index:9999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close interactivityPopup" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="icon-warning-sign"></span>&nbsp;&nbsp;&nbsp;{{ __('common.site_system_message') }}</h4>
            </div>
            <div class="modal-body clearfix">
                <div style="float:left; margin-top: 10px; margin-left: 7px;">{{ __('common.site_system_message_expiring') }} <span id="dialogText-warning"></span></div>
                <input type="button" class="btn expand" value="{{ __('common.session_continue') }}" onclick="restartSession()" style="width: 120px; float: right;">
            </div>
        </div>
    </div>
</div>

<div class="modal in" id="modalExpired" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; z-index:9999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close interactivityPopup" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="icon-frown"></span>&nbsp;&nbsp;&nbsp;{{ __('common.site_system_message') }}</h4>
            </div>
            <div class="modal-body clearfix">
                <span style="float:left; margin-top: 10px; margin-left: 7px;">{{ __('common.site_system_message_expired') }}</span>
                <input type="button" class="btn expand" value="{{ __('common.login_button') }}" onclick="goLogin()"  style="width: 120px; float: right;">
            </div>
        </div>
    </div>
</div>