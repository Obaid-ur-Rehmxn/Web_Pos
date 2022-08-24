<?php
$pname=$_GET['sec2increment1'];
$category3=$_GET['category'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$category2=mysqli_query($con1,"Select * from tblcategory where store='$store' AND category_name='$category3'");
$category1=mysqli_fetch_assoc($category2);
$category=$category1['category_id'];
$result3 = mysqli_query($con1, "Select inventory_name as name,inventory_qty as quantity,saleprice,saledisc,saletax,purchaseprice,purchasedisc,purchasetax from tblinventory where store='$store' AND category='$category'");
$rows = array();
while($r = mysqli_fetch_assoc($result3)) {
    $rows[] = $r;
}
print json_encode($rows);
?>

