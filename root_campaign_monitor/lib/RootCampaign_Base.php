<?php

/**
 * Class RootCampaign_Base
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_Base extends PerchAPI_Base {

    /**
     * Auth array to be used for API authentication
     * @var $auth
     */
    protected $api;

    public function __construct($api = false) {
        parent::__construct($api);
        $this->rest_api = new RootCampaign_API();
    }
}