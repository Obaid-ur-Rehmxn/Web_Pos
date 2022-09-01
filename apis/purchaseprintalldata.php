<?php
$pname=$_GET['sec2increment1'];
$from=$_GET['from'];
$to=$_GET['to'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$result3 = mysqli_query($con1, "Select purchase_id as pino,purchase_date as date,amount as amount,cash as payment,returncash as returncash,vendor as vendor from tblpurchase1 where store='$store' AND purchase_date between '$from' AND '$to'");
$rows = array();
$i= 0;
while($r = mysqli_fetch_assoc($result3)) {
    $rows[$i][0] = $r['pino'];
    $rows[$i][1] = $r['date'];
    $customer=$r['vendor'];
    $name2=mysqli_query($con1,"Select * from tblclient where client_id='$customer'");
    $name1=mysqli_fetch_assoc($name2);
    $rows[$i][2] = $name1['client_name'];
    $rows[$i][3] = $r['amount'];
    $rows[$i][4] = $r['payment'];
    $rows[$i][5] = $r['returncash'];
    $i++;
}
print json_encode($rows);
?>

