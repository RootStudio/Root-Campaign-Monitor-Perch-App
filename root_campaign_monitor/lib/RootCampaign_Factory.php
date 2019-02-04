<?php

/**
 * Class RootCampaign_Factory
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Factory extends PerchAPI_Factory {

    /**
     * Rest API handler for campaign monitor
     * @var $rest_api
     */
    protected $rest_api;

    /**
     * Import logger
     * @var $importer
     */
    protected $importer;

    public function __construct($api = false) {
        parent::__construct($api);
        $this->importer = new RootCampaign_Imports();
        $this->rest_api = new RootCampaign_API();
    }

}