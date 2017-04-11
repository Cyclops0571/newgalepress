@extends('mail-templates.html')<?php
use App\User;
?>
@section('title')
  {{trans('common.welcome')}}
@endsection
@section('content1')
    <?php /** @var User $user */ ?>
    {!! trans('maillang.subscription_welcome_part1', ["NAME" => $user->FirstName, "SURNAME" => $user->LastName]) !!}
    <a href="https://www.youtube.com/channel/UCIJuAlRjVwV6OdCK9uzoN5w">
      <img style="display:block; line-height:0; font-size:0; border:0;" class="img1"
           src="http://www.galepress.com/img/mail-templates/hosgeldiniz/img.png" alt="img" width="500" height="250"/>
      </br></br>
    </a>
    {!! trans('maillang.subscription_welcome_part2', ["NAME" => $user->FirstName, "SURNAME" => $user->LastName]) !!}
@endsection
@section('galepress_link')
  <a href="{{ route('common_login_get')}}"><?php echo __('website.menu_login');?></a>
@endsection
