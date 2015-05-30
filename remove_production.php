<?php
	//login
	require_once "../login.php";
	// Create data object
	$dbh = new PDO('mysql:host=localhost;dbname=infoboard', $username, $password);
	// set attributes
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$dbh->beginTransaction();
	$sql = "select * from production";
	$query = $dbh->query($sql);
	$rowassoc = $query->fetchAll(PDO::FETCH_ASSOC);
	//print_r(array_values($rowassoc));
	
	if (isset($_POST['remove'])){
		$remove = htmlentities($_POST['remove']);
		//Remove record by rowid
		$sql = "Delete from production where rowid=:remove";
		$stmnt =  $dbh->prepare($sql);
		$stmnt->execute(array(':remove'=>$remove));
		$dbh->commit();
		//Update the rowassoc object
		$sql = "select * from production";
		$query = $dbh->query($sql);
		$rowassoc = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	echo "<form method='post' action='remove_production_JM.php'>";
	echo "<select name='remove'>";
	echo "<option value=''>choose employee</option>";
	foreach ($rowassoc as $count => $record){
	echo "<option value=".$record['rowid'].">".$record['operator']."</option>";	
	}
	echo "</select>";
	echo "<input type='submit' value='Remove'></input>";
	echo "</form>";
	

			
?>
