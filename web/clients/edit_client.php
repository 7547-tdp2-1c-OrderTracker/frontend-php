<?php
	include '../common/trackerman_api.php';

	$id = htmlspecialchars($_REQUEST['id']);
	$attrs['name'] = htmlspecialchars($_REQUEST['name']);
	$attrs['lastname'] = htmlspecialchars($_REQUEST['lastname']);
	$attrs['cuil'] = htmlspecialchars($_REQUEST['cuil']);
	$attrs['address'] = htmlspecialchars($_REQUEST['address']);
	$attrs['phone_number'] = htmlspecialchars($_REQUEST['phone_number']);
	$attrs['email'] = htmlspecialchars($_REQUEST['email']);
	$attrs['sellerType'] = htmlspecialchars($_REQUEST['sellerType']);
	$attrs['avatar'] = htmlspecialchars($_REQUEST['avatar']);
	$attrs['thumbnail'] = htmlspecialchars($_REQUEST['thumbnail']);
	$attrs['lat'] = htmlspecialchars($_REQUEST['lat']);
	$attrs['lon'] = htmlspecialchars($_REQUEST['lon']);

	$json = TrackermanAPI::editClient($id, $attrs);

	echo json_encode($json);
