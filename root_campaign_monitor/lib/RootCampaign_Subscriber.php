<?php

/**
 * Class RootCampaign_Subscriber
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Subscriber extends RootCampaign_Base {
    protected $factory_classname = 'RootCampaign_Subscribers';
    protected $table = 'root_campaign_monitor_subscribers';
    protected $pk = 'subscriberID';

    protected $modified_date_column = 'subscriberUpdated';

    public function update($data) {
        $data['subscriberUpdated'] = date('Y-m-d H:i:s');

        return parent::update($data);
    }

    public function transform($campaign) {
        return [
            'subscriberID'                => $campaign['campaignID'],
            'subscriberCampaignMonitorID' => $campaign['Bounced'],
            'subscriberEmailAddress'      => $campaign['TotalOpened'],
            'campaignClicks'              => $campaign['Clicks'],
            'campaignUnsubscribed'        => $campaign['Unsubscribed'],
            'campaignRecipients'          => $campaign['Recipients'],
        ];
    }

}