<?php
$Form = $API->get('Form');

$Lists = new RootCampaign_Lists($API);

$id = $_GET['id'];
if ($id) {
    $list = $Lists->find($id, null, true);

} else {
    $list = false;
    $message = $HTML->warning_message('No ID Found');
}
