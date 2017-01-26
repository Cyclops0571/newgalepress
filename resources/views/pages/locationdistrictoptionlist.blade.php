<option value="">{{ __('common.reports_select_district') }}</option>
@foreach($rows as $row)
	<option value="{{ $row->District }}">{{ $row->District }}</option>
@endforeach