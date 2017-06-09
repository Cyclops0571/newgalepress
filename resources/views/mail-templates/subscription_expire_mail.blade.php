@extends('mail-templates.html_without_button')
@section('title')
{{$title}}
@endsection
@section('content1')
{!! $content !!}
@endsection