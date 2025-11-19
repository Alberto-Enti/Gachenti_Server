<?php

require("template.php");
openHTML("", "login");
writeHeader();
$datos = <<<EOD
<section>
	<h2>Formulario de Login</h2>
		<form method="POST" action="login_check.php">
			<ul>
				<li>
					<p>
						<label for="login_username">User</label>
						<input type="text" id="login_username" name="username" />
					</p>
				</li>
				<li>
					<p>
					<label for="login_password">Password</label>
					<input type="password" id="login_password" name="password" />
					</p>
				</li>
			</ul>
			<p>
				<input type="submit" value="Login" />
			</p>
		</form>
			<p><a href="register.php">
				<button type="button">Register</button>
			</a></p>
<section>
EOD;
writeMain($datos);
closeHtml();
?>
