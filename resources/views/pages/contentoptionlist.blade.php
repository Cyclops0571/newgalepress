<option value="0">{{ __('common.reports_select_content') }}</option>
@foreach($rows as $row)
	<option value="{{ $row->ContentID }}">{{ $row->Name }}</option>
@endforeach