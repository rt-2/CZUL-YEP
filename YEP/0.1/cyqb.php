<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>YEP (Yanick's Euroscope Program/Plugin</title>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"/>

	<style>
	* {
		margin: 0 0;
		padding: 0 0;
		box-sizing: border-box;
	}
	iframe {
		width: 100%;
		height: 100%;
	}
	#theTable {
		position: absolute;
		height:100%;width:100%;
		top: 0; bottom: 0; left: 0; right: 0;
	}
	</style>

	<script>

	/*
		jQuery Document Ready
	*/
	$( document ).ready(function() {
		// Document ready

		setInterval(function () {
			document.getElementById('WeatherIframe').contentWindow.location.reload();

		}, 600000);

	});

	</script>

</head>

<body>
	<table id="theTable">
		<tr>
			<td colspan="2" height="40%" width="100%">
				<iframe src="http://rt-2.net/YEP/CaNotAPI/cyqb_app.php">

				</iframe>

			</td>

		</tr>
		<tr>
			<td>
				<iframe id="WeatherIframe" src="http://rt-2.net/YEP/Weather/?icao=cyqb">

				</iframe>

			</td>
			<td width="30%">
				<iframe src="http://rt-2.net/YEP/WLTs/">

				</iframe>

			</td>
		</tr>
	</table>


</body>

</html>
	