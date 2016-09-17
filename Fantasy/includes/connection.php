
<?php
	require("constants.php");

	try {
	    $conn = new PDO('mysql:host=localhost;dbname=Fantasy',DB_USER,DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $ex) {
	    echo "ERROR: " . $ex->getMessage();
	}
	
?>	