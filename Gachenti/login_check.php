<?php

if (!isset($_POST["username"]) || !isset($_POST["password"])){
die("Error 1: Formulario no enviado");
}

if(strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 16){
die("Error 2: Nombre de usuario no tiene el tamaño correcto");
}

if(strlen($_POST["password"]) < 3 || strlen($_POST["password"]) > 16){
die("Error 3: Contraseña no tiene el tamaño correcto");
}

$username = addslashes($_POST["username"]);
$password = addslashes($_POST["password"]);

if($username != $_POST["username"] || $password != $_POST["password"]){
die("Error 4: La contraseña o el usuario están mal formados");
}

$password = md5($password);

$query = <<<EOD
SELECT id_user
FROM users
WHERE
	username='{$username}'
	AND password='{$password}'
EOD;

$conn = mysqli_connect("localhost","enti", "enti", "gachenti" );
if(!$conn){
	die("Error DB 1: Error en la conexión");
}

$result = mysqli_query($conn, $query);
if(!$result){
	die("Error DB 2: Error al realizar la petición");
}

if(mysqli_num_rows($result) != 1){
	die("Error 6: El usuario o el password son erróneos");
}

$user = mysqli_fetch_assoc($result);
echo $user["id_user"];


?>
