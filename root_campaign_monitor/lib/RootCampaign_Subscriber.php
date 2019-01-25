<?php

/**
 * Class RootCampaign_Subscriber
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Subscriber extends RootCampaign_Base  {
    protected $factory_classname = 'PerchMailChimp_Subscribers';
    protected $table = 'mailchimp_subscribers';
    protected $pk = 'subscriberID';

    protected $modified_date_column = 'subscriberUpdated';

    public function update($data) {
        $data['campaignUpdated'] = date('Y-m-d H:i:s');

        return parent::update($data);
    }

    public function import() {
        $result = $this->clients()->get_campaigns();

        $campaign = ($result->is_successful) ? $result->response : null;

        $this->update($this->transform($campaign));

    }

    public function transform($campaign) {
        return [
            'campaignID'           => $campaign['campaignID'],
            'campaignBounces'      => $campaign['Bounced'],
            'campaignOpened'       => $campaign['TotalOpened'],
            'campaignClicks'       => $campaign['Clicks'],
            'campaignUnsubscribed' => $campaign['Unsubscribed'],
            'campaignRecipients'   => $campaign['Recipients'],
        ];
    }

}