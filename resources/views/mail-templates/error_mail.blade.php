@extends('mail-templates.html')
@section('title')
  {{config('app.name')}} Error
@endsection
@section('content1')
  <pre>
    {!! print_r($msg) !!}
  </pre>
@endsection
@section('galepress_link')
  <a href="{{url('/')}}">{{config('app.name')}}</a>
@endsection