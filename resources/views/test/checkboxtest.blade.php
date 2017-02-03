@layout('layouts.master')

@section('content')
    <div class="col-md-8">
        <input type="checkbox" id="mycheckbox" title="mycheckbox">
    </div>

    <script type="text/javascript">
        $(function () {
            $("#mycheckbox").iButton();
        });
    </script>



    <div class="toggle_div">
        <div class="checker" id="uniform-BannerStatus_39"><span>
        <div class="toggle btn btn-danger off ios" data-toggle="toggle" style="width: 68px; height: 35px;"><input
                    type="checkbox" title="BannerStatus" class="bannerCheckbox" style="color: white"
                    id="BannerStatus_41">

            <div class="toggle-group"><label class="btn btn-info toggle-on">Aktif</label><label
                        class="btn btn-danger active toggle-off">Pasif</label><span
                        class="toggle-handle btn btn-default"></span></div>
        </div>
        </div>

        <div class="toggle_div">
            <div class="checker" id="uniform-BannerStatus_39"><span><div class="toggle btn ios btn-danger off"
                                                                         data-toggle="toggle"
                                                                         style="width: 40.5px; height: 27px;"><input
                                type="checkbox" title="BannerStatus" class="bannerCheckbox" id="BannerStatus_39">

                        <div class="toggle-group"><label class="btn btn-info toggle-on">Aktif</label><label
                                    class="btn btn-danger active toggle-off">Pasif</label><span
                                    class="toggle-handle btn btn-default"></span></div>
                    </div></span></div>
        </div>
@endsection