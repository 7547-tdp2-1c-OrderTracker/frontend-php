<?php
	include 'http_request.php';

	class TrackermanAPI {
		private static $baseUrl = "https://trackerman-api.herokuapp.com";

		static function listClients($limit, $offset) {
			$vars['limit'] = $limit;
			$vars['offset'] = $offset;

			return getJSON(self::$baseUrl."/v1/clients", $vars);
		}

		static function createClient($name, $lastname, $cuil, $phone, $email, $type) {
			$body['name'] = $name;
			$body['lastname'] = $lastname;
			$body['cuil'] = $cuil;
			$body['phone_number'] = $phone;
			$body['email'] = $email;
			$body['sellerType'] = $type;

			return postJSON(self::$baseUrl."/v1/clients", $body);
		}

		static function editClient($id, $name, $lastname, $cuil, $phone, $email, $type) {
			$body['name'] = $name;
			$body['lastname'] = $lastname;
			$body['cuil'] = $cuil;
			$body['phone_number'] = $phone;
			$body['email'] = $email;
			$body['sellerType'] = $type;

			return putJSON(self::$baseUrl."/v1/clients/".$id, $body);
		}

		static function deleteClient($id) {
			return deleteJSON(self::$baseUrl."/v1/clients/".$id);
		}

	}
