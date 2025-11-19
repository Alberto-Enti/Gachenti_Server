<?php

require("template.php");
openHTML("", "portada");
writeHeader();
$datos = <<<EOD
<article>
	<h2>La carta mas cara</h2>
</article>
EOD;
writeMain($datos);
closeHtml();
?>
