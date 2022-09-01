<?php
$id=$_GET['id'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3=mysqli_query($con1,"Select * from tblpurchase1 where purchase_id='$id'");
$result4=mysqli_fetch_assoc($result3);
echo json_encode($result4);
?>
