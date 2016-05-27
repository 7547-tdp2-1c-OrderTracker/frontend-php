<?php
	include '../common/trackerman_api.php';

	$id = intval($_REQUEST['id']);
	
	$json = TrackermanAPI::getProduct($id);

	echo json_encode($json);