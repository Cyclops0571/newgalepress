<?php
$selected = 0;
if($contentID > 0)
{
    $selected = DB::table('ContentCategory')->where('ContentID', $contentID)->where('CategoryID', '0')->count();
}
?>
<option value=""{{ ($selected == 1 ? ' selected="selected"' : '') }}>{{ __('common.contents_category_list_general') }}</option>
@foreach($rows as $row)
    <?php
    $selected = 0;
    if($contentID > 0)
    {
        $selected = DB::table('ContentCategory')->where('ContentID', $contentID)->where('CategoryID', $row->CategoryID)->count();
    }
    ?>
	<option value="{{ $row->CategoryID }}"{{ ($selected == 1 ? ' selected="selected"' : '') }}>{{ $row->Name }}</option>
@endforeach
<?php /*
<option value="-1" class="modify">{{ __('common.contents_category_title') }}</option>
*/?>


<?php
/*
$selected = 0;
if($contentID > 0)
{
	$selected = DB::table('ContentCategory')->where('ContentID', $contentID)->where('CategoryID', '0')->count();
}
?>
<li><input type="checkbox" name="chkCategoryID[]" value="0"{{ ($selected == 1 ? ' checked="checked"' : '') }} />{{ __('common.contents_category_list_general') }}</li>
@foreach($rows as $row)
    <?php
    $selected = 0;
    if($contentID > 0)
    {
        $selected = DB::table('ContentCategory')->where('ContentID', $contentID)->where('CategoryID', $row->CategoryID)->count();
    }
    ?>
	<li><input type="checkbox" name="chkCategoryID[]" value="{{ $row->CategoryID }}"{{ ($selected == 1 ? ' checked="checked"' : '') }} />{{ $row->Name }}</li>
@endforeach
*/
?>