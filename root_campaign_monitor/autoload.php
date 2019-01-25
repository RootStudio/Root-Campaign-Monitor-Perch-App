<?php

// Composer
require __DIR__ . '/lib/vendor/autoload.php';

// Perch API
spl_autoload_register(function ($class) {

    if (strpos($class, 'RootCampaign') === 0) {
        include(PERCH_PATH . '/addons/apps/root_campaign_monitor/lib/' . $class . '.php');

        return true;
    }

    return false;
});
