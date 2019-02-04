<?php

echo $HTML->title_panel([
    'heading' => $Lang->get('List: %s', $list->listTitle()),
], $CurrentUser);


$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => true,
    'title'  => 'Details',
    'link'   => $API->app_nav() . '/lists/details/?id=' . $list->id(),
    'icon'   => 'core/document'
]);

$Smartbar->add_item([
    'active' => false,
    'title'  => 'Subscribers',
    'link'   => $API->app_nav() . '/lists/subscribers/?id=' . $list->id(),
    'icon'   => 'core/circle-check'
]);

$Smartbar->add_item([
    'active' => false,
    'title'  => 'Unconfirmed',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Unconfirmed&id=' . $list->id(),
    'icon'   => 'core/clock'
]);

$Smartbar->add_item([
    'active' => false,
    'title'  => 'Unsubscribed',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Unsubscribed&id=' . $list->id(),
    'icon'   => 'core/cancel'
]);

$Smartbar->add_item([
    'active' => false,
    'title'  => 'Bounced',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Bounced&id=' . $list->id(),
    'icon'   => 'core/o-undo'
]);

$Smartbar->add_item([
    'active' => false,
    'title'  => 'Deleted',
    'link'   => $API->app_nav() . '/lists/subscribers/?state=Deleted&id=' . $list->id(),
    'icon'   => 'core/circle-delete'
]);

echo $Smartbar->render();

?>
<div class="inner">
    <table>
        <tr>
            <th style="width:20%;">Title</th>
            <td> <?= nl2br($HTML->encode($list->listTitle())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">List ID</th>
            <td> <?= nl2br($HTML->encode($list->listCampaignMonitorID())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Active Subscribers</th>
            <td> <?= nl2br($HTML->encode($list->listTotalActiveSubscribers())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Total Unsubscribed</th>
            <td> <?= nl2br($HTML->encode($list->listTotalUnsubscribes())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Total Bounces</th>
            <td> <?= nl2br($HTML->encode($list->listTotalBounces())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Total Deleted</th>
            <td> <?= nl2br($HTML->encode($list->listTotalDeleted())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Confirmed Opt In</th>
            <td> <?= $list->listConfirmedOptIn() ? 'Yes' : 'No' ?></td>
        </tr>
    </table>
</div>