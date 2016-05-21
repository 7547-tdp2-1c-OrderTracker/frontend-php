<?php
	include 'common/trackerman_api.php';
	$url = TrackermanAPI::getBaseUrl();
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="general/general.css">
<script type="text/javascript" src="lib/moment.js"></script>
<script type="text/javascript" src="general/utils.js"></script>

<script>
window.apiBaseUrl = '<?= $url ?>';
</script>