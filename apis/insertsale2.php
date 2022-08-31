<?php
$id=$_GET['id'];
$product=$_GET['product'];
$qty=$_GET['qty'];
$price=$_GET['price'];
$disc=$_GET['disc'];
$stax=$_GET['stax'];
$net=$_GET['net'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$product1 = mysqli_query($con1, "Select * from tblinventory where inventory_barcode='$product'");
$product2=mysqli_fetch_assoc($product1);
$product3=$product2['inventory_id'];
$result3=mysqli_query($con1,"Insert into tblsales2(sales_id,product,qty,price,disc,stax,net) values('$id','$product3','$qty','$price','$disc','$stax','$net')");
$result4=mysqli_query($con1,"Update tblinventory set inventory_qty=inventory_qty-'$qty' where inventory_id='$product3'");
if($result3){
    echo "1";
}
else{
    echo "0";
}
?>
