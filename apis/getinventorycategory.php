<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3 = mysqli_query($con1, "Select * from tblinventory where inventory_id='$pname'");
$count = mysqli_fetch_assoc($result3);
$cl=$count['category'];
$cl1=mysqli_query($con1,"Select * from tblcategory where category_id='$cl'");
$cl2=mysqli_fetch_assoc($cl1);
$cl3=$cl2['category_name'];
echo $cl3;
?>
