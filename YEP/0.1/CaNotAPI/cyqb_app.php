<!DOCTYPE html>
<html>
	<head>
		<title>CANotAPI CYUL_APP Example Page</title>
		
		<style>
			.CANotAPI_Notam_active {
				background-color: lightgreen;
			}
			.CANotAPI_Notam_soonActive {
				background-color: yellow;
				background-opacity: 0.6;
			}
			.CANotAPI_Notam_inactive {
				background-color: red;
			}
			.CANotAPI_Notam_timeUndef {
				background-color: gray;
			}
		</style>
	</head>
	<body>
		<span style="font-family:webdings;">A</span>
		<?php
			// Requires the CANotAPI script from this package
			require('./CANotAPI.inc');
			
			//$search = ['CLSD', 'APCH'];
			$search = ['CLSD', 'NOT AUTH', 'NOT AVBL'];
			
			echo '<h2>Important Notams for CYQB</h2>';
			CANotAPI_EchoNotamsString('cyqb', $search, false);
      
		?>
	</body>
</html>