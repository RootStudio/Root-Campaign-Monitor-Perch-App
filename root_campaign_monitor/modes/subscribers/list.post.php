<?php

echo $HTML->title_panel([
    'heading' => $Lang->get('List: %s', $list->listTitle()),
], $CurrentUser);


$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => false,
    'title'  => 'Details',
    'link'   => $API->app_nav() . '/lists/details/?id=' . $list->id(),
    'icon'   => 'core/document'
]);

$Smartbar->add_item([
    'active' => ($state === 'Active'),
    'title'  => 'Subscribers',
    'link'   => $API->app_nav() . '/lists/subscribers/?id=' . $list->id(),
    'icon'   => 'core/circle-check'
]);

$Smartbar->add_item([
    'active' => ($state === 'Unconfirmed'),
    'title'  => 'Unconfirmed',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Unconfirmed&id=' . $list->id(),
    'icon'   => 'core/clock'
]);

$Smartbar->add_item([
    'active' => ($state === 'Unsubscribed'),
    'title'  => 'Unsubscribed',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Unsubscribed&id=' . $list->id(),
    'icon'   => 'core/cancel'
]);

$Smartbar->add_item([
    'active' => ($state === 'Bounced'),
    'title'  => 'Bounced',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Bounced&id=' . $list->id(),
    'icon'   => 'core/o-undo'
]);

$Smartbar->add_item([
    'active' => ($state === 'Deleted'),
    'title'  => 'Deleted',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Deleted&id=' . $list->id(),
    'icon'   => 'core/circle-delete'
]);

echo $Smartbar->render();

$Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

$Listing->add_col([
    'title'     => 'Name',
    'value'     => 'subscriberName',
    'sort'      => 'subscriberName',
]);

$Listing->add_col([
    'title'     => 'Email',
    'value'     => 'subscriberEmailAddress',
    'sort'      => 'subscriberEmailAddress',
]);

$Listing->add_col([
    'title'     => 'Date Subscribed',
    'value'     => 'subscriberDateSubscribed',
    'sort'      => 'subscriberDateSubscribed',
]);

echo $Listing->render($subscribers);
