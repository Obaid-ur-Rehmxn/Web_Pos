<?php
$store=$_GET['store'];
$date=$_GET['date'];
$type=$_GET['type'];
$category=$_GET['category'];
$amount=$_GET['amount'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$store'");
$store1=mysqli_fetch_assoc($store2);
$store3=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblexpensecategory where store='$store3' AND category_type='$type' AND category_name='$category'");
$result4=mysqli_fetch_assoc($result3);
$category3=$result4['category_id'];
$result5=mysqli_query($con1,"Insert into tblexpense1 (store,category,expense_date,expense_amount,type) values ('$store3','$category3','$date','$amount','$type')");
if($result5){
    echo "1";
}
else{
    echo "0";
}
?>
