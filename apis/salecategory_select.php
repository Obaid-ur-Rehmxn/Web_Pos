<?php
$store=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$store'");
$store1=mysqli_fetch_assoc($store2);
$store3=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblcategory where store='$store3'");
if (mysqli_num_rows($result3)>0){
    while($res=mysqli_fetch_array($result3)){
        echo '<option value="'.$res['category_name'].'">'.$res['category_name'].'</option>';
    }
}
?>

