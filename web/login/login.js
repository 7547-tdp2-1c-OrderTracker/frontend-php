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