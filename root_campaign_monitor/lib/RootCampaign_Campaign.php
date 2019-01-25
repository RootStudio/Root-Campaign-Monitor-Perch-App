<?php

/**
 * Class RootCampaign_Campaign
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Campaign extends RootCampaign_Base {
    protected $factory_classname = 'RootCampaign_Campaigns';
    protected $table = 'root_campaign_monitor_campaigns';
    protected $pk = 'campaignID';

    protected $modified_date_column = 'campaignUpdated';

    public function update($data) {
        return parent::update($data);
    }

    public function updateAndImport($data) {
        $result = $this->rest_api->campaigns($this->campaignMonitorID())->get_summary();

        $campaign = ($result->was_successful()) ? $result->response : null;
        $data = array_merge($data, $this->transform($campaign));
        $this->update($data);

    }

    public function import() {
        $result = $this->rest_api->campaigns($this->campaignMonitorID())->get_summary();

        $campaign = ($result->was_successful()) ? $result->response : null;

        $this->update($this->transform($campaign));

    }

    public function transform($campaign) {
        if ($campaign) {
            return [
                'campaignBounces'      => $campaign->Bounced,
                'campaignOpened'       => $campaign->TotalOpened,
                'campaignClicks'       => $campaign->Clicks,
                'campaignUnsubscribed' => $campaign->Unsubscribed,
                'campaignRecipients'   => $campaign->Recipients,
            ];
        }
    }
}