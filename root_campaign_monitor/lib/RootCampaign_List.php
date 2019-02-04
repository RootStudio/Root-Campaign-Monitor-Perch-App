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

    public function update($data, $import = false) {

        $data = array_merge($data, ($import) ? $this->import() : []);

        return parent::update($data);
    }

    public function import() {
        $result_stats = $this->rest_api->lists($this->listCampaignMonitorID())->get_stats();
        $result = $this->rest_api->lists($this->listCampaignMonitorID())->get();

        $list_stats = ($result_stats->was_successful()) ? $result_stats->response : [];
        $list = ($result->was_successful()) ? $result->response : [];
        $list = (object) array_merge((array) $list, (array) $list_stats);

        $this->importer->update('listSingle', $this->id());

        return $this->transform($list);

    }

    public function transform($list) {
        return [
            'listTotalActiveSubscribers' => $list->TotalActiveSubscribers,
            'listTotalUnsubscribes'      => $list->TotalUnsubscribes,
            'listTotalBounces'           => $list->TotalBounces,
            'listConfirmedOptIn'         => ($list->ConfirmedOptIn) ? 1 : 0,
            'listTotalDeleted'           => $list->TotalDeleted,
        ];
    }
}