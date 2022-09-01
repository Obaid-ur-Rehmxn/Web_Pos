<?php
$id=$_GET['id'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result2=mysqli_query($con1,"Select * from tblpurchase2 where purchase_id='$id'");
while ($res=mysqli_fetch_assoc($result2)){
    $product=$res['product'];
    $result4=mysqli_query($con1,"Select * from tblinventory where inventory_id='$product'");
    $result5=mysqli_fetch_assoc($result4);
    $result6=$result5['inventory_qty']+$res['qty'];
    $result7=mysqli_query($con1,"Update tblinventory set inventory_qty='$result6' where inventory_id='$product'");
}
$result3=mysqli_query($con1,"Delete from tblpurchase2 where purchase_id='$id'");
if($result3){
    echo "1";
}
else{
    echo "0";
}
?>
