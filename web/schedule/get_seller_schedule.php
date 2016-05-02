<?php
	include '../common/trackerman_api.php';

	$seller = intval($_REQUEST['seller_id']);
	
	$json = TrackermanAPI::listScheduleEntries($seller);

	echo json_encode($json["results"]);