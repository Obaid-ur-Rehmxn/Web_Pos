<?php
$id=$_GET['id'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3=mysqli_query($con1,"Select * from tblexpense1 where expense_id='$id'");
$result4=mysqli_fetch_assoc($result3);
$amount=$result4['expense_amount'];
echo $amount;
?>
