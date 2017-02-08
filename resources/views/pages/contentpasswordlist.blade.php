@if(count($rows) > 0)
	@foreach($rows as $row)
	    <tr id="contentpassword{{ $row->ContentPasswordID }}" class="{{ Html::oddeven('contentpassword') }}">
	        <td>{{ $row->Name }}</td>
	        <td>{{ $row->Qty }}</td>
	        <td>
	            <a href="javascript:cContent.modifyPassword({{ $row->ContentPasswordID }});">{{ __('common.contents_password_list_modify') }}</a>
	            <a href="javascript:cContent.deletePassword({{ $row->ContentPasswordID }});">{{ __('common.contents_password_list_delete') }}</a>
	        </td>
	    </tr>
	@endforeach
@else
	<tr>
		<td colspan="3">{{ __('common.list_norecord') }}</td>
	</tr>
@endif