<?php

echo $HTML->title_panel([
    'heading' => $Lang->get('Campaign: %s', $campaign->campaignName()),
], $CurrentUser);


$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => true,
    'title'  => 'Details',
    'link'   => $API->app_nav() . '/campaigns/details/?id=' . $campaign->id(),
    'icon'   => 'core/document'
]);

echo $Smartbar->render();

?>
<div class="inner">
    <table>
        <tr>
            <th style="width:20%;">Title</th>
            <td> <?= nl2br($HTML->encode($campaign->campaignName())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Subject</th>
            <td> <?= nl2br($HTML->encode($campaign->campaignSubject())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Status</th>
            <td> <?= nl2br($HTML->encode($campaign->campaignStatus())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Scheduled</th>
            <td><?= nl2br($HTML->encode($campaign->campaignDateScheduled())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">List ID</th>
            <td> <?= nl2br($HTML->encode($campaign->campaignMonitorID())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Preview URL</th>
            <td><a href="<?= nl2br($HTML->encode($campaign->campaignPreviewURL())) ?>" target="_blank" rel="noopener"> <?= nl2br($HTML->encode($campaign->campaignPreviewURL())) ?></a> </td>
        </tr>
        <tr>
            <th style="width:20%;">Total Recipients</th>
            <td> <?= $campaign->campaignRecipients() ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Total Opened</th>
            <td> <?= nl2br($HTML->encode($campaign->campaignOpened())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Total Bounces</th>
            <td> <?= nl2br($HTML->encode($campaign->campaignBounces())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Total Clicks</th>
            <td> <?= nl2br($HTML->encode($campaign->campaignClicks())) ?></td>
        </tr>
        <tr>
            <th style="width:20%;">Unsubscribed Users</th>
            <td> <?= $campaign->campaignUnsubscribed() ?></td>
        </tr>
    </table>
</div>