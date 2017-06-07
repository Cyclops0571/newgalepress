@extends('layouts.genericmaster')
@section('content')
    <style type="text/css">
        .whiteMessage {
            color: #fff;
            text-align: center;
        }
    </style>

    <div class="header">
        <h2><?php echo __('common.detailpage_caption'); ?> </h2>
    </div>
    <div class="content controls whiteMessage">
        <h2>{{__('common.registration_succesful')}}</h2>
    </div>
@endsection