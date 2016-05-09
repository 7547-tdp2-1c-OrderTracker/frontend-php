<?php
	include 'http_request.php';

	class TrackermanAPI {
		private static $baseUrl = "https://powerful-hollows-15939.herokuapp.com";

		// CLIENTES

		static function getClient($id) {
			return getJSON(self::$baseUrl."/v1/clients/".$id, []);
		}

		static function listClients($limit, $offset, $unnasigned) {
			$vars['limit'] = $limit;
			$vars['offset'] = $offset;
			if($unnasigned) {
				$vars['seller_id'] = 'null';
			}
			
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

		// VENDEDORES

		static function listSellers($limit, $offset) {
			$vars['limit'] = $limit;
			$vars['offset'] = $offset;

			return getJSON(self::$baseUrl."/v1/sellers", $vars);
		}

		// AGENDA

		static function listScheduleEntries($seller) {
			$vars['limit'] = 100;
			$vars['offset'] = 0;
			$vars['seller_id'] = $seller;

			return getJSON(self::$baseUrl."/v1/schedule_entries", $vars);
		}

		static function createScheduleEntry($body) {
			return postJSON(self::$baseUrl."/v1/schedule_entries", $body);
		}

		static function editScheduleEntry($body) {
			$vars['client_id'] = $body['client_id'];
			$entry = getJSON(self::$baseUrl."/v1/schedule_entries", $vars);
			$id = $entry['results'][0]['id'];

			return putJSON(self::$baseUrl."/v1/schedule_entries/".$id, $body);
		}

		static function deleteScheduleEntry($client_id) {
			$vars['client_id'] = $client_id;
			$entry = getJSON(self::$baseUrl."/v1/schedule_entries", $vars);
			$id = $entry['results'][0]['id'];

			return deleteJSON(self::$baseUrl."/v1/schedule_entries/".$id);
		}

		// PEDIDOS

		static function listOrders($limit, $offset, $seller_id) {
			$vars['limit'] = $limit;
			$vars['offset'] = $offset;
			if($seller_id) {
				$vars['seller_id'] = $seller_id;
			}
			
			return getJSON(self::$baseUrl."/v1/orders", $vars);
		}
	
	}
