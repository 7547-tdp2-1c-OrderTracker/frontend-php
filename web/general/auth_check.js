var token = Cookies.get("tmtoken");
if (!token) {
	window.location = "/login.php"
}

$.ajax({
	url: window.apiBaseUrl + "/v1/auth/check",
	headers: {
		authorization: token
	}
}).then(function() {
	$("body").css('opacity', 1);
}, function(response) {
	if (response.status == 403) {
		// fallo la autenticacion, redirigir a login
		window.location = "/login.php";
	} else {
		$("body").css('opacity', 1);
	}
});