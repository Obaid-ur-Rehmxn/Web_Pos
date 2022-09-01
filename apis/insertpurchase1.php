<?php
$store=$_GET['store'];
$date=$_GET['date'];
$customer=$_GET['customer'];
$cash=$_GET['cash'];
$amount=$_GET['amount'];
$returncash=$_GET['returncash'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$store'");
$store1=mysqli_fetch_assoc($store2);
$store3=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblclient where store='$store3' AND client_name='$customer' AND  vendor=1");
$result4=mysqli_fetch_assoc($result3);
$customer3=$result4['client_id'];
$result5=mysqli_query($con1,"Insert into tblpurchase1(store,purchase_date,vendor,cash,amount,returncash) values('$store3','$date','$customer3','$cash','$amount','$returncash')");
if($result5){
    echo "1";
}
else{
    echo "0";
}
?>
