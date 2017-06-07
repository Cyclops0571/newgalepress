@extends('layouts.genericmaster')

@section('content') 
<div class="header">
    <h2><?php echo __('common.password_renewed_caption'); ?> </h2>
</div>
<div class="content controls">
    <?php echo __('common.login_passwordhasbeenchanged'); ?>
</div>
@endsection