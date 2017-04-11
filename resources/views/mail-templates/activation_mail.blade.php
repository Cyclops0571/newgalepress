@extends('mail-templates.html')
@section('title')
    <?php echo __('maillang.activation'); ?>
@endsection
@section('content1')
    <?php echo __('maillang.tryitactivationmail', array('USERNAME' => $name, 'SURNAME' => $surname)); ?>
@endsection
@section('galepress_link')
  <a href="{{$url}}"><?php echo __('maillang.activatesubscription'); ?></a>
@endsection