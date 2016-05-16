<?php
	include '../common/trackerman_api.php';

	$id = intval($_REQUEST['id']);

	$json = TrackermanAPI::deleteDiscount($id);

	echo json_encode(array('success'=>true));