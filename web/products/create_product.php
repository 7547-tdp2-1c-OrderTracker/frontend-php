<?php
	include '../common/trackerman_api.php';

	$attrs['name'] = htmlspecialchars($_REQUEST['name']);
	$attrs['description'] = htmlspecialchars($_REQUEST['description']);
	$attrs['picture'] = htmlspecialchars($_REQUEST['picture']);
	$attrs['thumbnail'] = htmlspecialchars($_REQUEST['picture']);
	$attrs['stock'] = htmlspecialchars($_REQUEST['stock']);
	$attrs['currency'] = "ARS";
	$attrs['wholesalePrice'] = htmlspecialchars($_REQUEST['wholesalePrice']);
	$attrs['retailPrice'] = htmlspecialchars($_REQUEST['retailPrice']);
	$attrs['brand_id'] = htmlspecialchars($_REQUEST['brand_id']);
	$attrs['categories'] = htmlspecialchars($_REQUEST['categories']);
	
	$json = TrackermanAPI::createProduct($attrs);

	echo json_encode($json);
