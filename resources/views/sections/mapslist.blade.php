@if(Auth::user()->UserTypeID != eUserTypes::Manager)

  <div class="modal in" id="modalMapsList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6"
       aria-hidden="false" style="display: none; overflow:hidden;">
    <div class="modal-dialog" style="width:40%; margin-top:0 !important; padding-top:0 !important;">
      <div class="modal-content">
        <div class="modal-body clearfix">
          <div class="controls">
            <div class="content controls">
              <div class="form-row">
                <div class="col-md-12">
                  <div data-device="ipad" data-orientation="portrait" data-color="white" class="device-mockup">
                    <div class="device">
                      <div class="screen">
                        <iframe src="{{ route('maps_location', request('applicationID', 0))  }}" scrolling="no"
                                frameborder="0"
                                style="width:100% !important; height:100% !important; overflow:hidden;"></iframe>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif