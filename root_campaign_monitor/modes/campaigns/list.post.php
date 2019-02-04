<?php

echo $HTML->title_panel([
    'heading' => $Lang->get('Listing all campaigns'),
    'form'    => [
        'action' => $Form->action(),
        'button' => $Form->submit('btnSubmit', 'Sync', 'button button-icon icon-left', true, true, PerchUI::icon('ext/o-sync', 14))
    ]
], $CurrentUser);

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => true,
    'title'  => 'Campaigns',
    'link'   => $API->app_nav(),
    'icon'   => 'blocks/mail',
]);

echo $Smartbar->render();

$Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

$Listing->add_col([
    'title'     => 'Title',
    'value'     => 'campaignName',
    'sort'      => 'campaignName',
    'edit_link' => $API->app_path() . '/campaigns/details'
]);

$Listing->add_col([
    'title'     => 'Campaign ID',
    'value'     => 'campaignMonitorID',
    'sort'      => 'campaignMonitorID',
]);

$Listing->add_col([
    'title'     => 'Status',
    'value'     => 'campaignStatus',
]);

echo $Listing->render($campaigns);
