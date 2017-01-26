<option value="0">{{ __('common.reports_select_application') }}</option>
@foreach($rows as $row)
	<option value="{{ $row->ApplicationID }}">{{ $row->Name }}</option>
@endforeach