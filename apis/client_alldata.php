<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result=mysqli_query($con1,"Select * from tblclient where client_id='$pname'");
$result1=mysqli_fetch_assoc($result);
echo json_encode($result1);
?>