<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3 = mysqli_query($con1, "Select * from tblinventory where inventory_id='$pname'");
$result4=mysqli_fetch_assoc($result3);
echo json_encode($result4);
?>

