<html>
	<head>
        <title>Ganzapp</title>
		<link rel="stylesheet" href="index.css">
		<link rel="icon" href="img/icon.png">
	</head>
	<body>
		<?php
			require("funzioni.php");

			if(isset($_REQUEST['scelta'])) $sc = $_REQUEST['scelta']; else $sc = null;

			switch($sc){
				/* AUTENTICAZIONE */
				case 'formRegister': {
					include 'authentication/formRegister.php';
					break;
				}
				case 'register': {
					include 'authentication/register.php';
					break;
				}
				default: {
					include 'authentication/formLogin.php';
					break;
				}
				case 'formLogin': {
					include 'authentication/formLogin.php';
					break;
				}
				case 'login': {
					include 'authentication/login.php';
					break;
				}
				case 'logout': {
					include 'authentication/logout.php';
					break;
				}

				/* CHAT */
				case 'chat': {
					/* check cookie */
					include 'authentication/checkCookie.php';

					include 'chat.php';
					break;
				}
			}
		?>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/c39fe6a4d3.js" crossorigin="anonymous"></script> <!-- icone -->
		<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
		<script>
			// per file javascript
			let script = document.createElement("script");
            script.src = "script.js" + "?_dc=" + Date.now();
            document.body.appendChild(script);
		</script>
	</body>
</html>