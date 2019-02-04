<?php

$this->add_setting('root_campaign_monitor_client_id', 'Client ID', 'text', '');
$this->add_setting('root_campaign_monitor_client_key', 'Client API Key', 'text', '');
$this->add_setting('root_campaign_monitor_scheduled', 'Update Lists', 'select', false, [
    ['label' => 'Every Minute', 'value' => '1'],
    ['label' => '10 Minutes', 'value' => '10'],
    ['label' => '30 Minutes', 'value' => '30'],
    ['label' => '1 Hour', 'value' => '60'],
    ['label' => '6 Hours', 'value' => '360'],
    ['label' => '12 Hours', 'value' => '720'],
    ['label' => 'Every Day', 'value' => '1440'],
    ['label' => 'Every Week', 'value' => '10080'],
    ['label' => 'Every Month', 'value' => '43800'],
], 'How often should the lists refresh');