<?php

require("template.php");




openHTML("", "portada");

writeHeader();


$datos = <<<EOD
<article>
	<h2>La carta más cara</h2>
</article>
EOD;

writeMain($datos);


closeHTML();

?>
