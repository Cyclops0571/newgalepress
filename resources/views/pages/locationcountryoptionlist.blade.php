<option value="">{{ __('common.reports_select_country') }}</option>
@foreach($rows as $row)
	<option value="{{ $row->Country }}">{{ $row->Country }}</option>
@endforeach