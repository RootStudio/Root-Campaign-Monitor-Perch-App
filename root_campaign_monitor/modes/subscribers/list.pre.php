<?php
$Form = $API->get('Form');


$id = $_GET['id'];
$state = (isset($_GET['state'])) ? $_GET['state'] : 'Active';
if ($id && $state) {

    $Lists = new RootCampaign_Lists($API);
    $Paging = $API->get('Paging');

    $Paging->set_per_page(20);
    $list = $Lists->find($id, null, true);

    $Subscribers = new RootCampaign_Subscribers($list->listCampaignMonitorID(), $state, $API);

    $subscribers = $Subscribers->all($Paging);

    if (!PerchUtil::count($subscribers)) {
        // No subscribers! gasp!

        $message = $HTML->warning_message('There are no subscribers for this list');

    }

} else {
    $list = false;
    $message = $HTML->warning_message('No ID Found');
}
