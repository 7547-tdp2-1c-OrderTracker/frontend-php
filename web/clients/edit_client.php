<?php
	include '../common/trackerman_api.php';

	$id = htmlspecialchars($_REQUEST['id']);
	$name = htmlspecialchars($_REQUEST['name']);
	$lastname = htmlspecialchars($_REQUEST['lastname']);
	$cuil = htmlspecialchars($_REQUEST['cuil']);
	$address = htmlspecialchars($_REQUEST['address']);
	$phone = htmlspecialchars($_REQUEST['phone_number']);
	$email = htmlspecialchars($_REQUEST['email']);
	$type = htmlspecialchars($_REQUEST['sellerType']);
	$lat = htmlspecialchars($_REQUEST['lat']);
	$lon = htmlspecialchars($_REQUEST['lon']);

	$json = TrackermanAPI::editClient($id, $name, $lastname, $cuil, $address, $phone, $email, $type, $lat, $lon);

	echo json_encode($json);
