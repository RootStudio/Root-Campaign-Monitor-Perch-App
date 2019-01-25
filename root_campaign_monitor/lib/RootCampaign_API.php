<?php

/**
 * Class RootCampaign_API
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_API {
    /**
     * Client ID for campaign monitor
     * @var $client_id
     */
    private $client_id;

    /**
     * Client API key for campaign monitor
     * @var $client_key
     */
    private $client_key;

    /**
     * Auth array to be used for API authentication
     * @var $auth
     */
    private $auth;

    public function __construct() {
        $Settings = PerchSettings::fetch();
        $this->client_id = $Settings->get('root_campaign_monitor_client_id')->settingValue();
        $this->client_key = $Settings->get('root_campaign_monitor_client_key')->settingValue();
        $this->auth = [
            'api_key' => $this->client_key
        ];
    }

    public function subscribers($list_id = null) {
        $API = new CS_REST_Subscribers($list_id, $this->auth);

        return $API;
    }

    public function lists($list_id = null) {
        $API = new CS_REST_Lists($list_id, $this->auth);

        return $API;
    }

    public function campaigns($campaign_id = null) {
        $API = new CS_REST_Campaigns($campaign_id, $this->auth);

        return $API;
    }

    public function clients() {
        $API = new CS_REST_Clients($this->client_id, $this->auth);

        return $API;
    }
}