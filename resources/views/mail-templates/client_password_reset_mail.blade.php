@extends('mail-templates.html')
@section('title')
    <?php echo __('maillang.activation'); ?>
@endsection
@section('content1')
    {!! $msg !!}
@endsection
@section('galepress_link')
  <a href="{{$url}}">{{trans('clients.reset_password')}}</a>
@endsection