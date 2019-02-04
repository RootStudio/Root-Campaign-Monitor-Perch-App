<?php
# include the API
include(__DIR__.'/../../../../../core/inc/api.php');

$API  = new PerchAPI(1.0, 'root_campaign_monitor');
$Lang = $API->get('Lang');
$HTML = $API->get('HTML');
$Paging = $API->get('Paging');

# Set the page title
$Perch->page_title = $Lang->get('Campaign Monitor Campaigns');

# Do anything you want to do before output is started
include('../../modes/_subnav.php');
include('../../modes/campaigns/details.pre.php');

# Top layout
include(PERCH_CORE . '/inc/top.php');

# Display your page
include('../../modes/campaigns/details.post.php');

# Bottom layout
include(PERCH_CORE . '/inc/btm.php');