<?php
$body = '';
$body .= "<b>Sender Name: </b>" . $request->get('senderName') . '<br/>';
$body .= "<b>Sender Phone: </b>" . $request->get('phone') . '<br/>';
if ($request->get('company', '')) {
$body .= "<b>Company: </b>" . $request->get('company', '') . '<br/>';
}
$body .= "<b>Comment: </b>" . $request->get('comment') . '<br/>';

