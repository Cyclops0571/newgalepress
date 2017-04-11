@extends('mail-templates.html')
@section('title')
  {{$title}}
  @endsection
@section('content1')
  {!! $content !!}
  @endsection
@section('galepress_link')
  <a href="{{$url}}">{{config('app.name')}}</a>
@endsection