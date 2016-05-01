<?php
	include 'http_request.php';

	class TrackermanAPI {
		private static $baseUrl = "https://trackerman-api.herokuapp.com";

		static function listClients($limit, $offset) {
			$vars['limit'] = $limit;
			$vars['offset'] = $offset;

			return getJSON(self::$baseUrl."/v1/clients", $vars);
		}

		static function createClient($body) {
			return postJSON(self::$baseUrl."/v1/clients", $body);
		}

		static function editClient($id, $body) {
			return putJSON(self::$baseUrl."/v1/clients/".$id, $body);
		}

		static function deleteClient($id) {
			return deleteJSON(self::$baseUrl."/v1/clients/".$id);
		}
	}
