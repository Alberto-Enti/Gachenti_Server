<?php
session_start();
$isAdmin;
if (!session_id()){
	header("Location: index.php");
	exit();
}

$id_user = intval($_SESSION['id_user']);

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$query = "SELECT * FROM users WHERE id_user=".$id_user;


$result = mysqli_query($conn, $query);
if (!$result) {
	header("Location: index.php");
	exit();
}

if (mysqli_num_rows($result) != 1){
	header("Location: index.php");
	exit();
}

$user = mysqli_fetch_assoc($result);


$id_user_type = intval($user["id_user_type"]);
if($id_user_type == 1){
	echo "<p>Is Admin {$id_user_type}</p>";
	$isAdmin=true;
}
else
{
	echo "<p>NOT Admin {$id_user_type}</p>";
	$isAdmin=false;
}

require("template.php");

openHTML("", "portada");


$datos = <<<EOD
<article>
	<h2>Dashboard</h2>
	<menu>
		<li><a href="dashboard.php">Perfil</a></li>
		<li><a href="dashboard_cards.php"><strong>Cartas</strong></a></li>
	</menu>

	<section>
		<h3>Cartas</h3>
EOD;

$query = <<<EOD
SELECT cards.id_card,card_templates.card,cards.price,card_templates.image
FROM cards
LEFT JOIN card_templates ON cards.id_card_template=card_templates.id_card_template
LEFT JOIN users_cards ON cards.id_card=users_cards.id_card
LEFT JOIN users ON users.id_user=users_cards.id_user
EOD;


$result = mysqli_query($conn, $query);

while($card = mysqli_fetch_assoc($result)){
	$datos .= <<<EOD
		<article>
		<h4>{$card["card"]}</h4>
		<figure>
			<img src="imgs/{$card["image"]}" />
		</figure>
		</article>
EOD;
}

$datos .= <<<EOD
	</section>
</article>
EOD;


$query = "SELECT id_card_type, type FROM card_types";
$result = mysqli_query($conn, $query);
if(!$result){
	die("Error: No hay tipos de cartas");
}

$options_cards_types = "";

while($card_type = mysqli_fetch_assoc($result)){
	$options_cards_types .= <<<EOD
		<option value="{$card_type["id_card_type"]}">
			{$card_type["type"]}
		</option>
	EOD;
}


$query = "SELECT id_card_rarity, rarity FROM card_rarities";
$result = mysqli_query($conn, $query);
if(!$result){
	die("ERROR: No hay rarezas");
}

$options_cards_rarities = "";

while($card_rarity = mysqli_fetch_assoc($result)){
$options_cards_rarities .= <<<EOD
		<option value="{$card_rarity["id_card_rarity"]}">
			{$card_rarity["rarity"]}
		</option>
	EOD;
}

	$datos .= <<<EOD
	<section>
		<h4>Selector de cartas</h4>
		<form method="POST" action="dashboard_cards_check.php">
		<p><label for="card">Nombre</label><input type="text" name="card" id="card" /></p>
		<p><label for="card_type">Tipo</label>
		<select name="card_type" id="card_type">
		{$options_cards_types}
		</select>
		</p>
		<p><label for="card_price">Precio</label><input type="number" name="price" id="card_price" /></p>
		<p><label for="card_rarity">Rareza</label>
		<select name="card_rarity" id="card_rarity">
		{$options_cards_rarities}
		</select>
		</p>
		<p><label for="card_image">Imagen</label><input type="file" name="image" id="card_image" /></p>
		<p><label for="card_price">Precio</label><input type="number" name="price" id="card_price" /></p>
EOD;


writeMain($datos);

closeHTML();
?>
