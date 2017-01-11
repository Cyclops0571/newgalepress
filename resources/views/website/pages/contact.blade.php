@extends('website.html')

@section('body-content')

      <section class="sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-6 sep-top-2x">
              <h4 class="upper">{{__('website.contact')}}</h4>
              <div class="contact-form">
                <div id="successMessage" style="display:none" class="alert alert-success text-center">
                  <p><i class="fa fa-check-circle fa-2x"></i></p>
                  <p>{{__('website.contact_form_success_message')}}</p>
                </div>
                <div id="failureMessage" style="display:none" class="alert alert-danger text-center">
                  <p><i class="fa fa-times-circle fa-2x"></i></p>
                  <p>{{__('website.contact_form_error_message')}}</p>
                </div>
                <div id="incompleteMessage" style="display:none" class="alert alert-warning text-center">
                  <p><i class="fa fa-exclamation-triangle fa-2x"></i></p>
                  <p>{{__('website.contact_form_required_message')}}</p>
                </div>
                  <form id="contactForm" action="<?php echo URL::to('contactmail'); ?>" method="post"
                        class="form-gray-fields validate">
                  <div class="row">
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="name">{{__('website.contact_form_name')}}</label>
                        <input id="name" type="text" name="senderName" class="form-control input-lg required" placeholder="{{__('website.contact_form_placeholder_name')}}">
                      </div>
                    </div>
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="senderEmail" class="form-control input-lg required email" placeholder="{{__('website.contact_form_placeholder_email')}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="phone">{{__('website.contact_form_tel')}}</label>
                        <input id="phone" type="text" name="phone" class="form-control input-lg required" placeholder="{{__('website.contact_form_placeholder_tel')}}">
                      </div>
                    </div>
                    <div class="col-md-6 sep-top-xs">
                      <div class="form-group">
                        <label for="phone">{{__('website.contact_form_company')}}</label>
                        <input id="company" type="text" name="company" class="form-control input-lg required" placeholder="{{__('website.contact_form_placeholder_company')}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 sep-top-xs">
                      <div class="form-group">
                        <label for="comment">{{__('website.contact_form_message')}}</label>
                        <textarea id="comment" rows="9" name="comment" class="form-control input-lg required" placeholder="{{__('website.contact_form_placeholder_message')}}"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 sep-top-xs">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i>&nbsp;{{__('website.contact_form_submit')}}</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-6 sep-top-2x">
              <h4 class="upper">{{__('website.contact_form_location')}}</h4>
              <div class="sep-top-xs">
                <div id="map-canvas" style="height:500px">
                  <script>
                    var
                      lat = 39.740242,
                      lon = -104.991615,
                      infoText = [
                        '<div style="white-space:nowrap">',, 
                          '<h5>Detaysoft</h5>',
                          'North Tustin, CA <br>',
                          'Call: +1-949-836-7342<br>',
                          'United States of America (USA)',
                        '</div>'
                      ],
                      infoText2 = [
                        '<div style="white-space:nowrap">',, 
                          '<h5>Detaysoft</h5>',
                          'Denver, CO <br>',
                          'Call: +1-973-462-6622<br>',
                          'United States of America (USA)',
                        '</div>'
                      ],
                      mapOptions = {
                        scrollwheel: false,
                        markers: [
                          { latitude: lat, longitude: lon, html: infoText.join('') },
                          { latitude: 33.763610, longitude: -117.791064, html: infoText2.join('') }
                        ],
                        icon: {
                          image: '/images/website/themes/royalblue/marker.png',
                          iconsize: [72, 65],
                          iconanchor: [12, 65],
                        },
                        latitude: lat,
                        longitude: lon,
                        zoom: 4
                      };
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection