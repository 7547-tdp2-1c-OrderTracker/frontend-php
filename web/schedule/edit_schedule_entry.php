<?php
	include '../common/trackerman_api.php';

	$attrs['client_id'] = intval($_REQUEST['client_id']);
	$attrs['seller_id'] = intval($_REQUEST['seller_id']);
	$attrs['day_of_week'] = intval($_REQUEST['day_of_week']);

	$json = TrackermanAPI::editScheduleEntry($attrs);

	echo json_encode($json);