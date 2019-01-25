<?php

/**
 * Class RootCampaign_Factory
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Factory extends PerchAPI_Factory {

    /**
     * Auth array to be used for API authentication
     * @var $auth
     */
    protected $rest_api;

    public function __construct($api = false) {
        parent::__construct($api);
        $this->rest_api = new RootCampaign_API();
    }

}