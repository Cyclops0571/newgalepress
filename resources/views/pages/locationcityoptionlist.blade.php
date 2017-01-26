<option value="">{{ __('common.reports_select_city') }}</option>
@foreach($rows as $row)
	<option value="{{ $row->City }}">{{ $row->City }}</option>
@endforeach