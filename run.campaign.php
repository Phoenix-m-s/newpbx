<?php
/**
 * Created by PhpStorm.
 * User: FaridCS
 * Date: 12/28/2014
 * Time: 15:35 PM
 */

include_once("server.inc.php");
include_once("common/essential.inc.php");


$campaign = new campaign();

// run campaign
$campaign->runCampaign();
           