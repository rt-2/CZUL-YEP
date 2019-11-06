<html>
	<head>
		<title>CANotAPI Example HTML Page</title>
		
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
		<?php
			require('CANotAPI.inc');
			
			$search = ['CLSD', 'NOT AUTH', ' '];
			
			echo '<h2>Test(s) for CYUL</h2>';
			CANotAPI_EchoNotamsString('CYUL', $search);
			echo '<h2>Test(s) for CYJN</h2>';
			CANotAPI_EchoNotamsString('cyjn', $search);
			
			//echo '<h2>All Notams for CYUL</h2>';
			//echo CANotAPI_GetNotamsString('cyul', ' ');
		?>
	</body>
</html>