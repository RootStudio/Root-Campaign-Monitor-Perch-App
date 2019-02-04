<?php

/**
 * Class RootCampaign_Base
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Base extends PerchAPI_Base {

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