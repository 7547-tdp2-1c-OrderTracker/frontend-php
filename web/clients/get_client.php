<?php
	include '../common/trackerman_api.php';

	$id = intval($_REQUEST['id']);
	
	$json = TrackermanAPI::getClient($id);

	echo json_encode($json);