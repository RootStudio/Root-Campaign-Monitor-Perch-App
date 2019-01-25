<?php

$this->add_setting('root_campaign_monitor_client_id', 'Client ID', 'text', '');
$this->add_setting('root_campaign_monitor_client_key', 'Client API Key', 'text', '');
$this->add_setting('root_campaign_monitor_scheduled', 'Update Lists', 'select', false, [
    ['label' => '10 Minutes', 'value' => '10'],
    ['label' => '30 Minutes', 'value' => '10'],
    ['label' => '1 Hour', 'value' => '10'],
    ['label' => '6 Hours', 'value' => '10'],
    ['label' => '12 Hours', 'value' => '10'],
    ['label' => 'Every Day', 'value' => '10'],
    ['label' => 'Every Week', 'value' => '10'],
], 'How often should the lists refresh');