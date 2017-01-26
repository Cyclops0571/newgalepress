@extends('layouts.master')

@section('content')    

<?php
$CustomerID = 0;
$CustomerNo = '';
$CustomerName = '';
$Address = '';
$City = '';
$Country = '';
$Phone1 = '';
$Phone2 = '';
$Email = '';
$BillName = '';
$BillAddress = '';
$BillTaxOffice = '';
$BillTaxNumber = '';

if (isset($row)) {
    $CustomerID = (int) $row->CustomerID;
    $CustomerNo = $row->CustomerNo;
    $CustomerName = $row->CustomerName;
    $Address = $row->Address;
    $City = $row->City;
    $Country = $row->Country;
    $Phone1 = $row->Phone1;
    $Phone2 = $row->Phone2;
    $Email = $row->Email;
    $BillName = $row->BillName;
    $BillAddress = $row->BillAddress;
    $BillTaxOffice = $row->BillTaxOffice;
    $BillTaxNumber = $row->BillTaxNumber;
}
?>
<div class="col-md-9">    
    <div class="block block-drop-shadow">
	<div class="header">
	    <h2>{{ __('common.detailpage_caption') }}</h2>
	</div>
	<div class="content controls">
	    {{ Form::open(__('route.customers_save'), 'POST') }}
	    {{ Form::token() }}
	    <div class="form-row">
		<input type="hidden" name="CustomerID" id="CustomerID" value="{{ $CustomerID }}" />
		<div class="col-md-3">{{ __('common.customers_customerno') }} <span class="error">*</span></div>
		{{ $errors->first('CustomerNo', '<p class="error">:message</p>') }}
		<div class="col-md-9">
		    <input type="text" name="CustomerNo" id="CustomerNo" class="form-control textbox required" value="{{ $CustomerNo }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_customername') }}<span class="error"></span></div>
		{{ $errors->first('CustomerName', '<p class="error">:message</p>') }}
		<div class="col-md-9">
		    <input type="text" name="CustomerName" id="CustomerName" class="form-control textbox required" value="{{ $CustomerName }}" />
		</div>
	    </div>                        
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_address') }}<span class="error"></span></div>
		<div class="col-md-9">
		    <textarea name="Address" class="form-control" id="Address" rows="2" cols="20">{{ $Address }}</textarea>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_city') }}<span class="error">*</span></div>
		<div class="col-md-9">
		    <input type="text" name="City" id="City" class="form-control textbox required" value="{{ $City }}" />      
		</div>
	    </div>                        
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_country') }}</div>
		<div class="col-md-9">
		    <input type="text" name="Country" id="Country" class="form-control textbox" value="{{ $Country }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_phone1') }}</div>
		<div class="col-md-9">
		    <input type="text" name="Phone1" id="Phone1" class="form-control textbox" value="{{ $Phone1 }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_phone2') }}</div>
		<div class="col-md-9">
		    <input type="text" name="Phone2" id="Phone2" class="form-control textbox" value="{{ $Phone2 }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_email') }}</div>
		<div class="col-md-9">
		    <input type="text" name="Email" id="Email" class="form-control textbox" value="{{ $Email }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_billname') }}</div>
		<div class="col-md-9">
		    <input type="text" name="BillName" id="BillName" class="form-control textbox" value="{{ $BillName }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_billaddress') }}</div>
		<div class="col-md-9">
		    <textarea name="BillAddress" id="BillAddress" class="form-control" rows="2" cols="20">{{ $BillAddress }}</textarea>
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_billtaxoffice') }}</div>
		<div class="col-md-9">
		    <input type="text" name="BillTaxOffice" id="BillTaxOffice" class="form-control textbox" value="{{ $BillTaxOffice }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-3">{{ __('common.customers_billtaxnumber') }}</div>
		<div class="col-md-9">
		    <input type="text" name="BillTaxNumber" id="BillTaxNumber" class="form-control textbox" value="{{ $BillTaxNumber }}" />
		</div>
	    </div>
	    <div class="form-row">
		<div class="col-md-8"></div>
		<div class="col-md-2">
		    <?php if ($CustomerID != 0): ?>
    		    <a href="#modal_default_10" data-toggle="modal"><input type="button" value="{{ __('common.detailpage_delete') }}" name="delete" class="btn delete expand remove" /></a>
		    <?php endif; ?>
		</div>
		<div class="col-md-2">
		    <input type="button" class="btn my-btn-success" name="save" value="{{ __('common.detailpage_update') }}" onclick="cCustomer.save();" />
		</div>
	    </div>
	    {{ Form::close() }}
	</div>
    </div>
</div>
<div class="modal modal-info" id="modal_default_10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Silmek istediğinize emin misiniz?</h4>
	    </div>                
	    <div class="modal-footer">
		<button type="button" class="btn btn-default btn-clean"  data-dismiss="modal" onclick="cCustomer.erase();" style="background:#9d0000;">{{ __('common.detailpage_delete') }}</button>       
		<button type="button" class="btn btn-default btn-clean" data-dismiss="modal">{{ __('common.contents_category_button_giveup') }}</button>
	    </div>
	</div>
    </div>
</div>
<!-- end form_content-->
@endsection