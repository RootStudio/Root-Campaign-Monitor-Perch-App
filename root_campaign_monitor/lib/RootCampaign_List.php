<?php

/**
 * Class RootCampaign_List
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_List extends RootCampaign_Base {

    /**
     * Event table
     *
     * @var string
     */
    protected $table = 'root_campaign_monitor_lists';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'listID';

    public function update($data) {

        return parent::update($data);
    }

    public function updateAndImport($data) {
        $result_stats = $this->rest_api->lists($this->listCampaignMonitorID())->get_stats();
        $result = $this->rest_api->lists($this->listCampaignMonitorID())->get();

        $list_stats = ($result_stats->was_successful()) ? $result_stats->response : [];
        $list = ($result->was_successful()) ? $result->response : [];
        $list = (object) array_merge( (array) $list, (array) $list_stats);

        $data = array_merge($data, $this->transform($list));
        $this->update($data);

    }

    public function import() {
        $result_stats = $this->rest_api->lists($this->listCampaignMonitorID())->get_stats();
        $result = $this->rest_api->lists($this->listCampaignMonitorID())->get();

        $list_stats = ($result_stats->was_successful()) ? $result_stats->response : [];
        $list = ($result->was_successful()) ? $result->response : [];
        $list = (object) array_merge( (array) $list, (array) $list_stats);

        $this->update($this->transform($list));

    }

    public function transform($list) {
        return [
            'listTotalActiveSubscribers' => $list->TotalActiveSubscribers,
            'listTotalUnsubscribes'      => $list->TotalUnsubscribes,
            'listTotalBounces'           => $list->TotalBounces,
            'listConfirmedOptIn'         => $list->ConfirmedOptIn,
        ];
    }
}