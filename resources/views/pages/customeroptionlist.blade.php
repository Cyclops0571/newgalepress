<option value="0">{{ __('common.reports_select_customer') }}</option>
@foreach($rows as $row)
	<option value="{{ $row->CustomerID }}">{{ $row->CustomerName }}</option>
@endforeach