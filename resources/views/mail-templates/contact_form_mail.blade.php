@extends('mail-templates.html')
@section('title')
  Galepress Customer Contact Request
@endsection
@section('content1')
  <b>Sender Name: </b>{{$name}}<br/>
  <b>Sender Phone: </b>{{$phone}}<br/>
  @if(!empty($company))
    <b>Company: </b>{{$company}}<br/>
  @endif
  <b>Comment: </b>{{$comment}}<br/>
@endsection