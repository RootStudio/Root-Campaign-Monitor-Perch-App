<?php

include __DIR__ . '/autoload.php';

function root_campaign_monitor_form_handler($SubmittedForm) {
    if ($SubmittedForm->validate()) {
        RootCampaign_Subscribers::subscribe_from_form($SubmittedForm);
    }
}