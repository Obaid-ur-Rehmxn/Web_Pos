<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblpacking where store='$store'");
if (mysqli_num_rows($result3)>0){
    while($res=mysqli_fetch_array($result3)){
        echo '<option value="'.$res['packing_name'].'">'.$res['packing_name'].'</option>';
    }
}
?>

