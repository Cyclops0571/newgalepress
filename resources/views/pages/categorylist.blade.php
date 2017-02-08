<tr id="category0" class="even">
    <td>{{ __('common.contents_category_list_general') }}</td>
    <td></td>
</tr>
@foreach($rows as $row)
    <tr id="category{{ $row->CategoryID }}" class="{{ Html::oddeven('category') }}">
        <td>{{ $row->Name }}</td>
        <td>
            <a href="javascript:cContent.modifyCategory({{ $row->CategoryID }});">{{ __('common.contents_category_list_modify') }}</a>
            <a href="javascript:cContent.deleteCategory({{ $row->CategoryID }});">{{ __('common.contents_category_list_delete') }}</a>
        </td>
    </tr>
@endforeach