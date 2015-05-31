<?php
// retrieve an array of all existing dates.
require_once "../login.php";
	// Create data object
	$dbh = new PDO('mysql:host=localhost;dbname=infoboard', $username, $password);
	// set attributes
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//begin transaction
	$dbh->beginTransaction();
//do initial queries for existing dates.
//For Before DESC
	$sql = "select date from production order by date desc"; // ideally, this should be a more specific select statement.
	$query = $dbh->query($sql);
	$beforeassoc = $query->fetchAll(PDO::FETCH_ASSOC);
//For After	ASC
	$sql = "select date from production order by date asc"; // ideally, this should be a more specific select statement.
	$query = $dbh->query($sql);
	$afterassoc = $query->fetchAll(PDO::FETCH_ASSOC);
	//print_r(array_values($rowassoc));
	$prodassoc = "";
// use a select statement to pull all information from between date ranges.
if(isset($_POST['after']) || isset($_POST['before'])) {
		$after = htmlentities($_POST['after']);
		$before = htmlentities($_POST['before']);
		//If an after date is higher than before, just set it to the lowest date. (Optional)
		if(strtotime($after) > strtotime($before)) $after="0000-00-00";
		$sql = "Select operator From production Where date BETWEEN :after AND :before";
		$query = $dbh->prepare($sql);
		$query->execute(array(':after'=>$after,':before'=>$before));
		$prodassoc = $query->fetchAll(PDO::FETCH_ASSOC);
		//print_r(array_values($prodassoc));
	}
?>
<!--Display dates to user as select inputs named before and after-->
<form method="post" action="date_selector_3.php">
After:
<select name="after"> 
<option value="0000-00-00">select</option>
<?php 
	foreach($afterassoc as $date){
	echo "<option value=".$date['date'].">".$date['date']."</option>";	
	}
?>
</select>
Before:
<select name="before"> 
<option value=" ">select</option>
<?php 
	foreach($beforeassoc as $date){
	echo "<option value=".$date['date'].">".$date['date']."</option>";	
	}
?>
</select>
<input type="submit" value="List"></input> 
</form>
<ol>
<?php
if($prodassoc) {
foreach($prodassoc as $row){
echo "<li>".$row['operator']."</li>";
}
}
?>
</ol>
