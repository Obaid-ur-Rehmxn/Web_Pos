<?php
$pname=$_GET['sec2increment1'];
$category=$_GET['category'];
$from=$_GET['from'];
$to=$_GET['to'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$category2=mysqli_query($con1,"Select * from tblexpensecategory where store='$store' AND category_name='$category'");
$category1=mysqli_fetch_assoc($category2);
$category3=$category1['category_id'];
$result3 = mysqli_query($con1, "Select expense_id as vno,expense_date as date,expense_amount as amount from tblexpense1 where store='$store' AND category='$category3' AND expense_date between '$from' AND '$to'");
$rows = array();
$i= 0;
while($r = mysqli_fetch_assoc($result3)) {
    $rows[$i][0] = $r['vno'];
    $rows[$i][1] = $r['date'];
    $rows[$i][2] = $category;
    $rows[$i][3] = $r['amount'];
    $i++;
}
print json_encode($rows);
?>

