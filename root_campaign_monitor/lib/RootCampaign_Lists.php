<?php

/**
 * Class RootCampaign_Lists
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Lists extends RootCampaign_Factory {
    /**
     * Campaigns table
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

    /**
     * Sort column
     *
     * @var string
     */
    protected $default_sort_column = 'listID';

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
    protected $singular_classname = 'RootCampaign_List';

    /**
     * Template namespace
     *
     * @var string
     */
    protected $namespace = 'lists';

    /**
     * Non dynamic fields
     *
     * @var array
     */
    public $static_fields = [
        'listID',
        'listCampaignMonitorID',
        'campaignID',
        'listTitle',
        'listTotalActiveSubscribers',
        'listTotalUnsubscribes',
        'listTotalBounces',
        'listConfirmedOptIn',
        'listSearchable',
        'listCreated',
        'listUpdated',
    ];

    /**
     * Find a campaign by ID
     *
     * @param int    $value
     * @param string $column
     *
     * @return RootBuilder_campaign|bool
     */
    public function find($value, $column = null) {
        $column = ($column === null) ? $this->pk : $column;
        $sql = 'SELECT * FROM ' . $this->table .
            ' WHERE ' . $column . '=' . $this->db->pdb($value) . ' AND ' . $this->standard_restrictions() . ' LIMIT 1';
        $result = $this->db->get_row($sql);

        if (is_array($result)) {
            return $this->return_instance($result);
        }

        return false;
    }

    /**
     * Returns all records optionally paginated
     *
     * @param bool $Paging
     *
     * @return array|bool|SplFixedArray
     */
    public function all($Paging = false) {

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

    public function import() {

        $list_result = $this->rest_api->clients()->get_lists();
        $lists = $list_result->was_successful() ? $list_result->response : [];
        $this->createMultiple($this->transform($lists));

    }

    public function createMultiple($data) {
        foreach ($data as $list) {
            $current = $this->find($list['listCampaignMonitorID'], 'listCampaignMonitorID');
            if ($current) {
                $current->updateAndImport($list);
            } else {
                $this->create($list);
            }
        }
    }

    public function create($data) {
        $list = parent::create($data);

        if ($list) {
            $list->import();
        }
    }

    public function update() {

    }

    public function transform($data) {
        return array_map(function ($list) {
            return [
                'listCampaignMonitorID' => $list->ListID,
                'listTitle'             => $list->Name,
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