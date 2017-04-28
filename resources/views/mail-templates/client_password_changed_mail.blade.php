@extends('mail-templates.html_without_button')
@section('title')
    {{$subject}}
@endsection
@section('content1')
    {!! $msg !!}
@endsection
