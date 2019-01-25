<?php

// Prevent running directly:
if (!defined('PERCH_DB_PREFIX')) exit;


$API = new PerchAPI(1.0, 'root_campaign_monitor');
$Settings = $API->get('Settings');
$secret = $Settings->get('root_campaign_monitor_client_key')->settingValue();

// Let's go
$sql = file_get_contents(__DIR__.'/db.sql');

$sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);

$statements = explode(';', $sql);
foreach($statements as $statement) {
    $statement = trim($statement);
    if ($statement!='') $this->db->execute($statement);
}

$UserPrivileges = $API->get('UserPrivileges');
$UserPrivileges->create_privilege('root_campaign_monitor', 'Access Campaign Monitor');
$UserPrivileges->create_privilege('root_campaign_monitor.dash', 'Show Campaign Monitor on dashboard');
$UserPrivileges->create_privilege('root_campaign_monitor.lists.edit', 'Edit list options');
