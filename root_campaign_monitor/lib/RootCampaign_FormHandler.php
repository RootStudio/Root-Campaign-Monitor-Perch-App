<?php

/**
 * Class RootCampaign_FormHandler
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

class RootCampaign_FormHandler {


    /**
     * Rest API handler for campaign monitor
     * @var $rest_api
     */
    protected $rest_api;

    /**
     * Payload to be sent to Campaign Monitor
     * @var $payload
     */
    protected $payload;

    public function __construct() {
        $this->rest_api = new RootCampaign_API();
    }

    public static function subscribe_from_form(PerchAPI_SubmittedForm $SubmittedForm) {
        $self = new self();
        $subscriber_IDs = [];
        if (isset($SubmittedForm->data['list_id'])) {
            $subscriber_IDs[] = $SubmittedForm->data['list_id'];

            $attr_map = $SubmittedForm->get_attribute_map('campaign');
            if (PerchUtil::count($attr_map)) {
                foreach ($attr_map as $fieldID => $key) {
                    switch ($key) {
                        case 'list':
                            if (isset($SubmittedForm->data[$fieldID])) {
                                $subscriber_IDs[] = $SubmittedForm->data[$fieldID];
                            }
                            break;

                        case 'name':
                            $self->payload['Name'] = $SubmittedForm->data[$fieldID];
                            break;

                        case 'email':
                            $self->payload['EmailAddress'] = $SubmittedForm->data[$fieldID];
                            break;

                        case 'consent':
                            $self->payload['ConsentToTrack'] = (isset($SubmittedForm->data[$fieldID])) ? $SubmittedForm->data[$fieldID] : false ;
                            break;

                        case 'resubscribe':
                            $self->payload['Resubscribe'] = isset($SubmittedForm->data[$fieldID]) ? PerchUtil::bool_val($SubmittedForm->data[$fieldID]) : false ;
                            break;

                        default:
                            $self->payload['CustomFields'][] = [
                                'Key'   => $key,
                                'Value' => $SubmittedForm->data[$fieldID]
                            ];
                            break;

                    }
                }
            }

            if (PerchUtil::count($subscriber_IDs)) {


                foreach ($subscriber_IDs as $subscriber_ID) {

                    PerchUtil::debug('Subscribing ' . $self->payload['Name'] . ' <' . $self->payload['EmailAddress'] . '> to: ' . $subscriber_ID);

                    $result = $self->rest_api->subscribers($subscriber_ID)->add($self->payload);

                    if ($result->was_successful()) {
                        PerchUtil::debug("Subscribed with code $result->http_status_code");
                    } else {
                        PerchUtil::debug(json_encode($result->response));
                    }

                }
            }

        } else {
            PerchUtil::debug('No List ID Set fro campaign monitor', 'error');
        }

    }
}