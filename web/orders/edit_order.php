<?php
	include '../common/trackerman_api.php';

	$id = htmlspecialchars($_REQUEST['id']);
	$attrs['status'] = htmlspecialchars($_REQUEST['status']);

	$json = TrackermanAPI::editOrder($id, $attrs);

	echo json_encode($json);
