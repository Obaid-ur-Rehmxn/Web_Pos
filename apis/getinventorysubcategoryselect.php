<?php
$pname=$_GET['sec2increment1'];
$category=$_GET['category'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblcategory where store='$store' AND category_name='$category'");
$result4=mysqli_fetch_assoc($result3);
$result5=$result4['category_id'];
$result6=mysqli_query($con1,"Select * from tblsubcategory where category_id='$result5' AND store='$store'");
if (mysqli_num_rows($result6)>0){
    while($res=mysqli_fetch_array($result6)){
        echo '<option value="'.$res['subcategory_name'].'">'.$res['subcategory_name'].'</option>';
    }
}
?>

