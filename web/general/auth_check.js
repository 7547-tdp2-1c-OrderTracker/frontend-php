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
	$("body").show();
}, function() {
	// fallo la autenticacion, redirigir a login
	window.location = "/login.php";
});