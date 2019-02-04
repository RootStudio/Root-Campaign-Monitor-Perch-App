<?php
$Form = $API->get('Form');

$Paging = $API->get('Paging');
$Paging->set_per_page(20);

$Lists = new RootCampaign_Lists($API);

$lists = $Lists->all($Paging);

if (!PerchUtil::count($lists)) {
    // No lists! gasp!

    // Do we have a license key?
    $Settings  = PerchSettings::fetch();
    $api_key   = $Settings->get('root_campaign_monitor_client_key')->val();

    if ($api_key) {
        $Lists->attempt_install();

        $Lists->import();

        $lists = $Lists->all($Paging);
    }else{

        $message = $HTML->warning_message('Please add your Campaign Monitor Client API key on the Settings page.');

    }


}else{
    if ($Form->submitted()) {
        $Lists->import(true);

        $lists = $Lists->all($Paging);

        $message = $HTML->success_message('Lists updated.');
    }
}
