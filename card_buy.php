<?php

if (!isset($_POST["id_user"]) || !isset($_POST["id_card"])){
	die("Error 1: Formulario no enviado");
}

session_start();

if (!isset($_SESSION["id_user"])){
	die("Error 2: no te has logueado");
}

$id_user = intval($_POST["id_user"]);
if ($id_user <= 0) {
	die("Error 3: Usuario incorrecto");
}

$id_card = intval($_POST["id_card"]);
if ($id_card <= 0) {
	die("Error 3: Carta incorrecta");
}


require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$query = <<<EOD
SELECT price FROM cards WHERE id_card={$id_card}
EOD;

$result = mysqli_query($conn, $query);
if (!$result){
	die("Error 4: carta incorrecta");
}

if (mysqli_num_rows($result) != 1){
	die("Error 5: carta incorrecta");
}

$card = mysqli_fetch_assoc($result);

$id_buyer = intval($_SESSION["id_user"]);

$query = <<<EOD
SELECT funds FROM users WHERE id_user={$id_buyer};
EOD;

$result = mysqli_query($conn, $query);
if (!$result){
	die("Error 6: el usuario no existe"); 
}

if (mysqli_num_rows($result) != 1){
	die("Error 7: usuario incorrecto");
}

$user = mysqli_fetch_assoc($result);

$funds_total = $user["funds"] - $card["price"];
if ($funds_total < 0){
	die("Error 8: No tienes dinero suficiente para comprar la carta");
}

$query = <<<EOD
UPDATE users SET funds={$funds_total} WHERE id_user={$id_buyer};
EOD;

$result = mysqli_query($conn, $query);
if (!$result){
	die("Error 9: No se ha podido realizar el pago");
}

$query = <<<EOD
UPDATE users SET funds=funds+{$card["price"]} WHERE id_user={$id_user};
EOD;
$result = mysqli_query($conn, $query);
if (!$result){
	die("Error 10: No se ha podido enviar el dinero");
}

$query = <<<EOD
UPDATE user_cards SET id_user={$id_buyer} WHERE id_card={$id_card};
EOD;
$result = mysqli_query($conn, $query);
if (!$result){
	die("Error 11: No se ha podido asignar la carta");
}

header("Location: cards.php");
exit();



?>
