<?php

function openHtml ($title = "", $id="default_html"){
if($title==""){
	$title = "gachenti: card trading game";
}

$html_id = "";
if($id!=""){
$html_id= " id=\"".$id."\"";
}

echo <<<EOD
	<!doctype html>
	<html>
	<head>
		<title>{$title}</title>
	</head>
	<body{$html_id}>
EOD;
}

function writeHeader(){
echo <<<EOD
	<header>
		<h1>Gachenti</h1>
	</header>
	<nav>
		<menu>
			<li><a href="index.php">Portada</a></li>
			<li><a href="cards.php">Cartas</a></li>
			<li><a href="shop.php">Compraventa</a></li>
			<li><a href="login.php">Login/Register</a></li>
		</menu>
	</nav>
EOD;
}

function writeMain($content){
echo <<<EOD
	<main>
	{$content}
	</main>
EOD;
}

function writeFooter(){
echo <<<EOD
	<footer>
	</footer>
EOD;
}

function closeHtml(){
echo <<<EOD
	</body>
	</html>
EOD;
}



?>
