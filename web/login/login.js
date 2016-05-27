$("#loginfrm").submit(function(event) {
	var email = $("#loginfrm input[name=email]").val();
	var password = $("#loginfrm input[name=password]").val();

	event.preventDefault();
	$.ajax({
		method: 'POST',
		url: window.apiBaseUrl + "/v1/auth/login",
		data: {
			email: email,
			password: password
		}
	}).then(function(response) {
		Cookies.set("tmtoken", response.token);
		window.location.href = 'client.php';
	}, function(err) {
		console.error(err);
		$("#loginfailed").show();
	});

	return null;
});

var token = Cookies.get("tmtoken");
if (token) {
	$.ajax({
		url: window.apiBaseUrl + "/v1/auth/check",
		headers: {
			authorization: token
		}
	}).then(function() {
		// si el token es valido, redirigir a client.php
		window.location = "/client.php";
	}, function(response) {
		if (response.status == 403) {
			// mostrar la pantalla de login
			$("body").show();
		} else {
			// otros errores q no sean 403 llevan a client.php
			window.location = "/client.php";
		}
	});
} else {
	$("body").show();
}
