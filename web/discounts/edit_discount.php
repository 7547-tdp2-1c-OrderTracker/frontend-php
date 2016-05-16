<?php
	include '../common/trackerman_api.php';

	$id = htmlspecialchars($_REQUEST['id']);
	$attrs['name'] = htmlspecialchars($_REQUEST['name']);
	$attrs['min_quantity'] = htmlspecialchars($_REQUEST['min_quantity']);
	$attrs['percent'] = htmlspecialchars($_REQUEST['percent']);
	$attrs['begin_date'] = htmlspecialchars($_REQUEST['begin_date']);
	$attrs['end_date'] = htmlspecialchars($_REQUEST['end_date']);
	$attrs['product_id'] = htmlspecialchars($_REQUEST['product_id']);
	$attrs['brand_id'] = htmlspecialchars($_REQUEST['brand_id']);

	$json = TrackermanAPI::editDiscount($id, $attrs);

	echo json_encode($json);
