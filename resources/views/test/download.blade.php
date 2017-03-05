@layout('layouts.master')

@section('content')
  <div class="col-md-8">
    <div class="block block-drop-shadow">
      <div class="header">
        <h2><?php echo __('common.detailpage_caption'); ?> </h2>
      </div>
      <div class="content controls">
        <form method="post" action="'http://localhost/test'" enctype="multipart/form-data">
            <?php echo Form::token(); ?>
          <div class="form-row">
            <div class="col-md-2" id="contentPdfFile">
              <input type="file" name="File" class="btn btn-mini hidden" id="File" style="opacity:0;"/>
              <script type="text/javascript">
                  $('#File').ready(function () {
                      $('#File').css('opacity', '1');
                  });
              </script>

              <div id="FileButton" class="input-group commands">
                <div id="File-button" class="uploadify-button " style="widget-icon widget-icon-circle">
                  <img src="/img/excel_28x28.png" style="border-radius: 50%"/>
                  <!--<span class="icon-upload"></span>-->
                </div>
              </div>

              <div for="File" class="myProgress hide">
                <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                <label for="scale"></label>
                <div class="scrollbox dot">
                  <div class="scale" style="width: 0%"></div>
                </div>
              </div>

              <input type="hidden" name="hdnFileSelected" id="hdnFileSelected" value="0"/>
              <input type="hidden" name="hdnFileName" id="hdnFileName"/>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-12">
              <input type="submit" value="Gönder" class="btn">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
      $("#File").fileupload({
          url: '/test/download',
          dataType: 'json',
          sequentialUploads: true,
          multipart: true,
          formData: {
              'element': 'File'
          },
          add: function (e, data) {
              //accept all files
              $('#hdnFileSelected').val("1");
              $("[for='File']").removeClass("hide");

              data.context = $("[for='File']");
              data.context.find('a').click(function (e) {
                  e.preventDefault();
                  var template = $("[for='File']");
                  data = template.data('data') || {};
                  if (data.jqXHR) {
                      data.jqXHR.abort();
                  }
              });
              var xhr = data.submit();
              data.context.data('data', {jqXHR: xhr});
          },
          progressall: function (e, data) {

              var progress = data.loaded / data.total * 100;

              $("[for='File'] label").html(progress.toFixed(0) + '%');
              $("[for='File'] div.scale").css('width', progress.toFixed(0) + '%');
          },
          done: function (e, data) {
              if (data.textStatus.valueOf() === 'success'.valueOf()) {
                  var fileName = data.result.name;

                  $('#hdnFileName').val(fileName);
//		$("[for='File']").addClass("hide");
                  $("div.rightbar").removeClass("hidden");
              }
          },
          fail: function (e, data) {
              $("[for='File']").addClass("hide");
          }
      });

      //select file
      $("#FileButton").click(function () {
          $("#File").click();
      });
  </script>
@endsection