<?php

session_start();

if (!session_id()){
	header("Location: index.php");
	exit();
}

if (!isset($_SESSION["id_user"])){
	header("Location: index.php");
	exit();
}

$id_user = intval($_SESSION["id_user"]);



require("template.php");


openHTML("", "portada");

writeHeader();


$num_cards = 5;

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$query = "SELECT * FROM card_templates ORDER BY RAND() LIMIT 1";

$datos = "<h3 class=\"section_title\">Tús cartas del día</h3><article id=\"get_lucky_cards\">";

for ($i = $num_cards; $i > 0; $i--){
	$result = mysqli_query($conn, $query);
	if(!$result){
		die("Error: No hay cartas");
	}

	$card = mysqli_fetch_assoc($result);

	$datos .= <<<EOD
	<section class="get_lucky_card fade{$i}">
		<figure>
			<img src="imgs/{$card["image"]}" class="card_img" />
			<figcaption>{$card["card"]}</figcaption>
		</figure>
	</section>
EOD;

	$card_state = rand(80, 100);

	$card_price = 0;

	if (isset($card["initial_price"])){
		$card_price = rand($card["initial_price"] - 4, $card["initial_price"]);
	}


	$query_insert = <<<EOD
INSERT INTO cards (price, state, id_card_template)
VALUES({$card_price}, {$card_state}, {$card["id_card_template"]})
EOD;
	
	$result = mysqli_query($conn, $query_insert);
	if(!$result){
		die("Error: Error al insertar una nueva carta");
	}

	$id_card = mysqli_insert_id($conn);

	$query_user_card = <<<EOD
INSERT INTO user_cards (id_user, id_card)
VALUES({$id_user}, {$id_card})
EOD;
	$result = mysqli_query($conn, $query_user_card);
	if(!$result){
		die("Error: Error al insertar una nueva carta");
	}
}

$datos .= "</article>";

writeMain($datos);


closeHTML();

?>
