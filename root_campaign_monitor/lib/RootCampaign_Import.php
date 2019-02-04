<?php

/**
 * Class RootCampaign_Import
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

use \Carbon\Carbon;

class RootCampaign_Import extends PerchAPI_Base {

    /**
     * Event table
     *
     * @var string
     */
    protected $table = 'root_campaign_monitor_imports';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'importID';

    /**
     * Template namespace
     *
     * @var string
     */
    protected $syncTimer = false;


    public function __construct($api = false) {
        parent::__construct($api);
        $Settings = new PerchAPI_Settings();
        $this->syncTimer = $Settings->get('root_campaign_monitor_scheduled')->settingValue();
    }

    public function checkSync() {

        $lastUpdated = Carbon::parse($this->importUpdated());

        return $lastUpdated->addMinutes($this->syncTimer)->lessThanOrEqualTo(Carbon::now());
    }
}