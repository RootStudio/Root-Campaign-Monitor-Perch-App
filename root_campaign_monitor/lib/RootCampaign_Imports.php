<?php

/**
 * Class RootCampaign_Imports
 *
 * @author Byron Fitzgerald <byron@rootstudio.co.uk>
 */

use Carbon\Carbon;

class RootCampaign_Imports extends PerchAPI_Factory {
    /**
     * Campaigns table
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
     * Sort column
     *
     * @var string
     */
    protected $default_sort_column = 'importID';

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
    protected $singular_classname = 'RootCampaign_Import';

    /**
     * Template namespace
     *
     * @var string
     */
    protected $namespace = 'imports';

    /**
     * Non dynamic fields
     *
     * @var array
     */
    public $static_fields = [
        'importID',
        'importType',
        'importValue',
        'importUpdated',
    ];

    public function find($type = 'campaigns', $value = false) {

        $sql = 'SELECT *
                FROM ' . $this->table;

        $restrictions = " WHERE importType = '$type'";

        if($value) {
            $restrictions .= " AND importValue = '$value'";
        }

        $sql .= $restrictions;

        $results = $this->db->get_row($sql);

        return $this->return_instance($results);

    }

    public function update($type, $value = false) {
        $data = [
            'importType' => $type,
            'importValue' => $value
        ];
        $import = $this->find($type, $value);
        $import ?
            $import->update(['importUpdated' => Carbon::now()->format('Y-m-d H:i:s')]) :
            parent::create($data);
    }

    public function checkSync($type, $value = false) {
        $import = $this->find($type, $value);

        return ($import) ? $import->checkSync() : true;
    }

}