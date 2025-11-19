<?php

if (
	!isset($_POST["name"]) ||
	!isset($_POST["surname"]) ||
	!isset($_POST["username"]) ||
	!isset($_POST["password"]) ||
	!isset($_POST["password2"]) ||
	!isset($_POST["birthdate"]) ||
	!isset($_POST["email"])
) {
	die("ERROR 1: Formulario no enviado.");
}


$name = $_POST["name"];
if(strlen($name) < 3 || strlen($name) > 32){
	die("ERROR 1: Nombre excede el número máximo de carácteres.");
}


$surname = $_POST["surname"];
if(strlen($surname) < 3 || strlen($surname) > 16){
	die("ERROR 2: Apellido excede el número máximo de carácteres.");
}

$username = $_POST["username"];
if (strlen($username) < 3 || strlen($username) > 16){
	die("ERROR 2: Nombre de usuario incorrecto.");
}

$username = addslashes($username);
if($username != $_POST["username"]){
	die("ERROR 6: Caracteres inválidos en el usuario.");
}

$password = $_POST["password"];
if (strlen($password) < 4){
	die("ERROR 3: Contraseña demasiado corta.");
}

if ($password !== $_POST["password2"]){
	die("ERROR 4: Las contraseñas no coinciden.");
}


$birthdate = intval($_POST["birthdate"]);

$yearNow = intval(date("Y"));

$birth_data = explode("-", $_POST["birthdate"]);

if ($yearNow - intval($birth_data[0]) < 18){
	die("ERROR 5: Debes ser mayor de edad.");
}

$birthdate = addslashes($_POST["birthdate"]);

if ($birthdate !== $_POST["birthdate"]){
	die("ERROR 5: Fechade nacimiento incorrecta");
}

$email = $_POST["email"];

$email_safe = addslashes($email);
if($email_safe != $email){
	die("ERROR 7: Caracteres inválidos en email.");
}

$password = md5($password);

$conn = mysqli_connect("localhost", "enti", "enti", "gachenti");
if(!$conn){
	die("ERROR DB 1: Error en la conexión.");
}

$query = <<<EOD
INSERT INTO users (name, surname, username, password, email, birthdate, id_user_type)
VALUES ('{$name}','{$surname}' , '{$username}', '{$password}', '{$email_safe}', '{$birthdate}', 3)
EOD;

$result = mysqli_query($conn, $query);
if(!$result){
	die("ERROR DB 2: Error al insertar.");
}

$new_id = mysqli_insert_id($conn);

echo "Registro completado correctamente. ID asignado: " . $new_id;

session_start();

$_SESSION["id_user"] = $user["id_user"];

header("Location: dashboard.php");

exit();

?>
