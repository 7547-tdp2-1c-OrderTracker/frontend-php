<?php
	include '../common/trackerman_api.php';

	$name = htmlspecialchars($_REQUEST['name']);
	$lastname = htmlspecialchars($_REQUEST['lastname']);
	$cuil = htmlspecialchars($_REQUEST['cuil']);
	$phone = htmlspecialchars($_REQUEST['phone_number']);
	$email = htmlspecialchars($_REQUEST['email']);
	$type = htmlspecialchars($_REQUEST['sellerType']);

	$json = TrackermanAPI::createClient($name, $lastname, $cuil, $phone, $email, $type);

	echo json_encode($json);
