<?php
$Form = $API->get('Form');

$Paging = $API->get('Paging');
$Paging->set_per_page(20);

$Campaigns = new RootCampaign_Campaigns($API);

$campaigns = $Campaigns->all($Paging);

if (!PerchUtil::count($campaigns)) {
    // No lists! gasp!

    // Do we have a license key?
    $Settings  = PerchSettings::fetch();
    $api_key   = $Settings->get('root_campaign_monitor_client_key')->val();

    if ($api_key) {

        $Campaigns->import();

        $campaigns = $Campaigns->all($Paging);
    } else{

        $message = $HTML->warning_message('Please add your Campaign Monitor Client API key on the Settings page.');

    }


}else{
    if ($Form->submitted()) {
        $Campaigns->import();

        $campaigns = $Campaigns->all($Paging);

        $message = $HTML->success_message('Lists updated.');
    }
}
