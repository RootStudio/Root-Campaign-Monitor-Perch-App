<?php

echo $HTML->title_panel([
    'heading' => $Lang->get('Listing all lists'),
    'form'    => [
        'action' => $Form->action(),
        'button' => $Form->submit('btnSubmit', 'Sync', 'button button-icon icon-left', true, true, PerchUI::icon('ext/o-sync', 14))
    ]
], $CurrentUser);

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => true,
    'title'  => 'Lists',
    'link'   => $API->app_nav(),
    'icon'   => 'blocks/mail',
]);

echo $Smartbar->render();

$Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

$Listing->add_col([
    'title'     => 'Title',
    'value'     => 'listTitle',
    'sort'      => 'listTitle',
]);

$Listing->add_col([
    'title'     => 'List ID',
    'value'     => 'listCampaignMonitorID',
    'sort'      => 'listCampaignMonitorID',
]);

$Listing->add_col([
    'title'     => 'Subscribers',
    'value'     => 'listTotalActiveSubscribers',
    'sort'      => 'listTotalActiveSubscribers',
]);

echo $Listing->render($lists);
