<?php
# include the API
include(__DIR__.'/../../../../core/inc/api.php');

$API  = new PerchAPI(1.0, 'root_campaign_monitor');
$Lang = $API->get('Lang');
$HTML = $API->get('HTML');
$Paging = $API->get('Paging');

# Set the page title
$Perch->page_title = $Lang->get('Campaign Monitor lists');

# Do anything you want to do before output is started
include('../modes/_subnav.php');
include('../modes/campaigns/list.pre.php');

# Top layout
include(PERCH_CORE . '/inc/top.php');

# Display your page
include('../modes/campaigns/list.post.php');

# Bottom layout
include(PERCH_CORE . '/inc/btm.php');