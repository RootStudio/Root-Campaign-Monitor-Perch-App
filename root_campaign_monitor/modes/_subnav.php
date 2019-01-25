<?php

PerchUI::set_subnav([
    [
        'page'  => [
            'root_campaign_monitor/lists',
        ],
        'label' => 'Lists',
        'priv'  => 'root_campaign_monitor.lists'
    ],
    [
        'page'  => [
            'root_campaign_monitor/campaigns',
            'root_campaign_monitor/campaigns/edit',
        ],
        'label' => 'Campaigns',
        'priv'  => 'root_campaign_monitor.campaigns',
    ]
], $CurrentUser);
