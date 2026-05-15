<?php
session_start();

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
LEFT JOIN user_cards ON cards.id_card=user_cards.id_card
LEFT JOIN users ON users.id_user=user_cards.id_user
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
	</section>
</article>
EOD;
}

writeMain($datos);

closeHTML();
?>
