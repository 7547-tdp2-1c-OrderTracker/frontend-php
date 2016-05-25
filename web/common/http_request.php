<?php
	function jsonRequest($method, $url, $body = NULL) {
		$headers = array(
		    "Content-type: application/json"
		);
		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_TIMEOUT, 5000);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		if(!is_null($body)) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
		}
		//var_dump($curl);
		if (isset($_COOKIE['tmtoken'])) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'authorization: ' . $_COOKIE['tmtoken']
			));
		}

	    $output = curl_exec($curl);
	    curl_close($curl);
		
		//var_dump($output);
		return json_decode($output, true);
	}

	function getJSON($url, $vars) {
		return jsonRequest("GET", $url."?".http_build_query($vars));
	}

	function postJSON($url, $body) {
		return jsonRequest("POST", $url, $body);
	}

	function putJSON($url, $body) {
		return jsonRequest("PUT", $url, $body);
	}

	function deleteJSON($url) {
		return jsonRequest("DELETE", $url);
	}
