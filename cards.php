<?php

session_start();

require("template.php");

openHTML("Listado de cartas", "cards");

writeHeader();

$query = <<<EOD
SELECT
	cards.id_card,
	card_templates.card,
	card_templates.image,
	cards.price,
	users.id_user,
	users.username
FROM
	cards
LEFT JOIN card_templates
	ON cards.id_card_template = card_templates.id_card_template
LEFT JOIN user_cards
	ON user_cards.id_card = cards.id_card
LEFT JOIN users
	ON users.id_user = user_cards.id_user;
EOD;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);
if (!$conn) {
	die("Error DB 1: Error en la conexión");
}

$result = mysqli_query($conn, $query);
if (!$result) {
	die("Error DB 2: Error al realizar la petición");
}

if (mysqli_num_rows($result) <= 0) {
	die("Error 1: No hay cartas");
}

$datos = "<ol>";
while($card = mysqli_fetch_assoc($result)){
	$datos .= <<<EOD
<li><p><strong>CardID:</strong> {$card["id_card"]}</p>
<p><strong>Card:</strong> {$card["card"]}</p>
<p><img src="imgs/{$card["image"]}" class="card_img" /></p>
<p><strong>Price:</strong> {$card["price"]}</p>
<p><strong>Owner</strong>: {$card["username"]}</p>
<form method="POST" action="card_buy.php">
<input type="hidden" name="id_user" value="{$card["id_user"]}" />
<input type="hidden" name="id_card" value="{$card["id_card"]}" />
<input type="submit" value="Compra!!!" />
</form></li>
EOD;

}
$datos .= "</ol>";

writeMain($datos);

closeHTML();

?>
