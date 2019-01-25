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
    protected $default_sort_column = 'subscriberD';

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

    private $payload;

    public static function subscribe_from_form(PerchAPI_SubmittedForm $SubmittedForm) {
        $self = new self();
        $list_IDs = [];
        if (isset($SubmittedForm->data['list_id'])) {
            $list_IDs[] = $SubmittedForm->data['list_id'];

            $attr_map = $SubmittedForm->get_attribute_map('campaign');
            if (PerchUtil::count($attr_map)) {
                foreach ($attr_map as $fieldID => $key) {
                    switch ($key) {
                        case 'list':
                            if (isset($SubmittedForm->data[$fieldID])) {
                                $list_IDs[] = $SubmittedForm->data[$fieldID];
                            }
                            break;

                        case 'name':
                            $self->payload['Name'] = $SubmittedForm->data[$fieldID];
                            break;

                        case 'email':
                            $self->payload['EmailAddress'] = $SubmittedForm->data[$fieldID];
                            break;

                        case 'consent':
                            $self->payload['ConsentToTrack'] = $SubmittedForm->data[$fieldID];
                            break;

                        case 'resubscribe':
                            $self->payload['Resubscribe'] = PerchUtil::bool_val($SubmittedForm->data[$fieldID]);
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

            if (PerchUtil::count($list_IDs)) {


                foreach ($list_IDs as $list_ID) {

                    PerchUtil::debug('Subscribing ' . $self->payload['Name'] . ' <' . $self->payload['EmailAddress'] . '> to: ' . $list_ID);

                    $result = $self->rest_api->subscribers($list_ID)->add($self->payload);

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

    public function import() {
        $sent_result = $this->clients()->get_campaigns();
        $pending_result = $this->clients()->get_campaigns();
        $draft_result = $this->clients()->get_campaigns();

        $sent = ($sent_result->is_successful) ? $sent_result->response() : [];
        $pending = ($sent_result->is_successful) ? $pending_result->response() : [];
        $draft = ($sent_result->is_successful) ? $draft_result->response() : [];

        $campaigns = array_merge(
            $this->transform($sent, 'sent'),
            $this->transform($pending, 'pending'),
            $this->transform($draft, 'draft')
        );

        foreach ($campaigns as $campaign) {
            $this->createMultiple($campaign);
        }

    }

    public function createMultiple($data) {
        foreach ($data as $campaign) {
            $this->create($campaign);
        }
    }

    public function create($data) {
        $data['campaignCreated'] = date('Y-m-d H:i:s');
        $data['campaignUpdated'] = date('Y-m-d H:i:s');

        parent::create($data);
    }

    public function update() {

    }

    public function transform($data) {
        return array_map(function ($campaign, $status) {
            return [
                'campaignMonitorID'     => $campaign['CampaignID'],
                'campaignDateScheduled' => ($campaign['SentDate']) ? $campaign['SentDate'] : $campaign['DateScheduled'],
                'campaignStatus'        => $status,
                'campaignSubject'       => $campaign['Subject'],
                'campaignName'          => $campaign['Name'],
                'campaignPreviewURL'    => ($campaign['WebVersionURL']) ? $campaign['WebVersionURL'] : $campaign['PreviewURL'],
            ];
        }, $data);
    }

}