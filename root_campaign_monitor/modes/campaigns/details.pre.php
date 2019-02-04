<?php
$Form = $API->get('Form');

$Campaigns = new RootCampaign_Campaigns($API);

$id = $_GET['id'];
if ($id) {
    $campaign = $Campaigns->find($id,null, true);

} else {
    $campaign = false;
    $message = $HTML->warning_message('No ID Found');
}
