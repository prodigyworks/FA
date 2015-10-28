<html>
<body>
<h1>Test clock</h2>
<h3>Before timezone change : <?php echo date("d/m/Y H:i:s"); ?></h3>
<?php

include("system-db.php");

start_db();

?>
<h3>After timezone change : <?php echo date("d/m/Y H:i:s"); ?></h3>
</body>
</html>