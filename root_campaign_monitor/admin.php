<?php

if ($CurrentUser->logged_in() && $CurrentUser->has_priv('root_campaign_monitor')) {
    // Register app
    $this->register_app('root_campaign_monitor', 'Campaign Monitor', 5, 'Campaign monitor forms integration', '1.0.0');

    // Hooks

    // Settings
    require __DIR__ . '/settings.php';

    // Autoload
    require __DIR__ . '/autoload.php';
}
