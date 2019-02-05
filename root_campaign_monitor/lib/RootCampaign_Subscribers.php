<?php

/**
 * Class RootCampaign_Subscribers
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Subscribers extends RootCampaign_Factory {
    /**
     * Campaigns table
     *
     * @var string
     */
    protected $table = 'root_campaign_monitor_subscribers';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'subscriberID';

    /**
     * Sort column
     *
     * @var string
     */
    protected $default_sort_column = 'subscriberID';

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
    protected $singular_classname = 'RootCampaign_Subscriber';

    /**
     * Template namespace
     *
     * @var string
     */
    protected $namespace = 'subscribers';

    /**
     * List ID for subscribers
     *
     * @var string
     */
    protected $listID;

    /**
     * Type of subscriber
     *
     * @var string
     */
    protected $state;

    public function __construct($listID, $state = 'Active', $api = false) {
        $this->listID = $listID;
        $this->state = $state;
        parent::__construct($api);
    }

    /**
     * Find a subscriber by ID
     *
     * @param int    $value
     * @param string    $column
     * @param boolean $import
     *
     * @return RootBuilder_list|bool
     */
    public function find($value, $column = null) {
        $column = ($column === null) ? $this->pk : $column ;
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
     * @param int    $listID
     * @param bool   $Paging
     *
     * @return array|bool|SplFixedArray
     */
    public function all($Paging = false) {
        if ($this->importer->checkSync('subscribers' . $this->state, $this->listID)) $this->import();

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
        switch ($this->state) {
            case 'Unconfirmed':
                $subscriber_result = $this->rest_api->lists($this->listID)->get_unconfirmed_subscribers(null, 1, null);
                break;
            case 'Unsubscribed':
                $subscriber_result = $this->rest_api->lists($this->listID)->get_unsubscribed_subscribers(null, 1, null);
                break;
            case 'Bounced':
                $subscriber_result = $this->rest_api->lists($this->listID)->get_bounced_subscribers(null, 1, null);
                break;
            case 'Deleted':
                $subscriber_result = $this->rest_api->lists($this->listID)->get_deleted_subscribers(null, 1, null);
                break;
            default:
                $subscriber_result = $this->rest_api->lists($this->listID)->get_active_subscribers(null, 1, null);
                break;
        }

        $subscribers = $subscriber_result->was_successful() ? $subscriber_result->response->Results : false;
        if($subscribers) {
            $this->importer->update('subscribers' . $this->state, $this->listID);
            $this->createMultiple($this->transform($subscribers));
        }

    }

    public function createMultiple($data) {
        foreach ($data as $subscriber) {
            $current = $this->find($subscriber['subscriberEmailAddress'], 'subscriberEmailAddress');
            if ($current) {
                $current->update($subscriber);
            } else {
                $this->create($subscriber);
            }
        }
    }

    public function transform($data) {
        return array_map(function ($subscriber) {
            return [
                'listCampaignMonitorID' => $this->listID,
                'subscriberEmailAddress'   => $subscriber->EmailAddress,
                'subscriberName'           => $subscriber->Name,
                'subscriberState'          => $subscriber->State,
                'subscriberDateSubscribed' => $subscriber->Date,
            ];
        }, $data);
    }

    /**
     * Standard restrictions (soft deleting)
     *
     * @return string
     */
    protected function standard_restrictions() {
        return " listCampaignMonitorID = '$this->listID' AND subscriberState = '$this->state'";
    }

}