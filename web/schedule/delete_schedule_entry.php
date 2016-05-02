<?php
	include '../common/trackerman_api.php';

	$client = intval($_REQUEST['client_id']);
	
	$json = TrackermanAPI::deleteScheduleEntry($client);

	echo json_encode($json);