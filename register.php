<?php

require("template.php");
openHTML("", "register");
writeHeader();
$datos = <<<EOD
<section>
	<h2>Formulario de Registro</h2>
		<form method="POST" action="register_check.php">
			<ul>
				<li><p><label for="register_name">Name</label><input type="text" id="register_name" name="name"/></p></li>
				<li><p><label for="register_surname">Surname</label><input type="text" id="register_surname" name="surname" /></p></li>
				<li><p><label for="register_username">User</label><input type="text" id="register_username" name="username" /></p></li>
				<li><p><label for="register_email">Email</label><input type="text" id="register_email" name="email" /></p></li>
				<li><p><label for="register_password">Password</label><input type="password" id="register_password" name="password" /></p></li>
				<li><p><label for="register_password2">Password2</label><input type="password" id="register_password2" name="password2" /></p></li>	
				<li><p><label for="register_birthdate">Birthdate</label><input type="date" id="register_birthdate" name="birthdate" /></p></li>
			</ul>
			<p>
				<input type="submit" value="Register" />
			</p>
		</form>
<section>
EOD;
writeMain($datos);
closeHtml();
?>
