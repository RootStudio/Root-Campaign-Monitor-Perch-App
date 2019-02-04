<?php

/**
 * Class RootCampaign_Campaigns
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Campaigns extends RootCampaign_Factory {
    /**
     * Campaigns table
     *
     * @var string
     */
    protected $table = 'root_campaign_monitor_campaigns';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'campaignID';

    /**
     * Sort column
     *
     * @var string
     */
    protected $default_sort_column = 'campaignID';

    /**
     * Sort direction
     *
     * @var string
     */
    protected $default_sort_direction = 'ASC';

    /**
     * Factory singular class
     *
     * @var string
     */
    protected $singular_classname = 'RootCampaign_Campaign';

    /**
     * Template namespace
     *
     * @var string
     */
    protected $namespace = 'campaigns';

    /**
     * Non dynamic fields
     *
     * @var array
     */
    public $static_fields = [
        'campaignID',
        'campaignMonitorID',
        'campaignDateScheduled',
        'campaignStatus',
        'campaignSubject',
        'campaignName',
        'campaignPreviewURL',
        'campaignBounces',
        'campaignOpened',
        'campaignClicks',
        'campaignUnsubscribed',
        'campaignRecipients',
        'campaignCreated',
        'campaignUpdated',
    ];

    /**
     * Find a campaign by value and column, defaults to Primary key
     *
     * @param int $value
     * @param string $column
     * @param boolean $import
     *
     * @return RootBuilder_campaign|bool
     */
    public function find($value, $column = null, $import = false) {
        $column = ($column === null) ? $this->pk : $column ;
        $sql = 'SELECT * FROM ' . $this->table .
            ' WHERE ' . $column . '=' . $this->db->pdb($value) . ' AND ' . $this->standard_restrictions() . ' LIMIT 1';
        $result = $this->db->get_row($sql);

        if (is_array($result)) {
            $campaign = $this->return_instance($result);
            if($import && $this->importer->checkSync('listSingle', $value)) $campaign->update([], true);
            return $campaign;
        }

        return false;
    }

    /**
     * Returns all records optionally paginated
     *
     * @param bool $Paging
     * @param bool $importAll
     *
     * @return array|bool|SplFixedArray
     */
    public function all($Paging = false, $importAll = false) {

        if($this->importer->checkSync('campaigns')) $this->import($importAll);

        if ($Paging && $Paging->enabled()) {
            $sql = $Paging->select_sql();
        } else {
            $sql = 'SELECT';
        }

        $sql .= ' *   
                FROM ' . $this->table;

        $restrictions = ' WHERE ' . $this->standard_restrictions();

        $sql .= $restrictions;

        if (isset($this->default_sort_column)) {
            $sql .= ' ORDER BY ' . $this->default_sort_column . ' ' . $this->default_sort_direction;
        }

        if ($Paging && $Paging->enabled()) {
            $sql .= ' ' . $Paging->limit_sql();
        }

        $results = $this->db->get_rows($sql);


        if ($Paging && $Paging->enabled()) {
            $Paging->set_total($this->db->get_count($Paging->total_count_sql()));
        }

        return $this->return_instances($results);

    }

    public function import($importAll = false) {
        $sent_result = $this->rest_api->clients()->get_campaigns();
        $pending_result = $this->rest_api->clients()->get_scheduled();
        $draft_result = $this->rest_api->clients()->get_drafts();

        $sent = ($sent_result->was_successful()) ? $sent_result->response : [];
        $pending = ($sent_result->was_successful()) ? $pending_result->response : [];
        $draft = ($sent_result->was_successful()) ? $draft_result->response : [];

        $campaigns = array_merge(
            $this->transform($sent, 'Sent'),
            $this->transform($pending, 'Scheduled'),
            $this->transform($draft, 'Draft')
        );
        $this->importer->update('campaigns');

        $this->createOrUpdateMultiple($campaigns, $importAll);

    }

    public function createOrUpdateMultiple($data, $import = false) {
        foreach ($data as $campaign) {
            $current = $this->find($campaign['campaignMonitorID'], 'campaignMonitorID', $import);
            if($current) {
                $current->update($campaign, $import);
            } else {
                $this->create($campaign, $import);
            }
        }
    }

    public function create($data, $import = false) {

        $campaign = parent::create($data);

        if($campaign && $import) {
            $campaign->import();
        }

    }

    public function transform($data, $status) {
        return array_map(function ($campaign) use ($status) {
            return [
                'campaignMonitorID'     => $campaign->CampaignID,
                'campaignDateScheduled' => (property_exists($campaign, 'SentDate')) ? $campaign->SentDate : ((property_exists($campaign, 'DateScheduled')) ? $campaign->DateScheduled : null),
                'campaignStatus'        => $status,
                'campaignSubject'       => $campaign->Subject,
                'campaignName'          => $campaign->Name,
                'campaignPreviewURL'    => (property_exists($campaign, 'WebVersionURL')) ? $campaign->WebVersionURL : $campaign->PreviewURL,
            ];
        }, $data);
    }

    /**
     * Standard restrictions (soft deleting)
     *
     * @return string
     */
    protected function standard_restrictions() {
        return ' 1 = 1';
    }

}