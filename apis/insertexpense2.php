<?php
$id=$_GET['id'];
$narration=$_GET['narration'];
$amount=$_GET['amount'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3=mysqli_query($con1,"Insert into tblexpense2 (expense_id,narration,amount) values ('$id','$narration','$amount')");
if($result3){
    echo "1";
}
else{
    echo "0";
}
?>
