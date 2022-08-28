<?php
$id=$_GET['id'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3=mysqli_query($con1,"Delete from tblexpense2 where expense_id='$id'");
if($result3){
    echo "1";
}
else{
    echo "0";
}
?>
