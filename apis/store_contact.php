<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3 = mysqli_query($con1, "Select * from tblstores where store_id='$pname'");
$count = mysqli_fetch_assoc($result3);
$cl=$count['store_contact'];
echo $cl;
?>
