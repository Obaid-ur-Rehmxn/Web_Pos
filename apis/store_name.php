<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3 = mysqli_query($con1, "Select * from tblusers where username='$pname'");
$count = mysqli_fetch_assoc($result3);
$cl=$count['store'];
$cl1=mysqli_query($con1,"Select * from tblstores where store_id='$cl'");
$cl2=mysqli_fetch_assoc($cl1);
$cl3=$cl2['store_name'];
echo $cl3;
?>
