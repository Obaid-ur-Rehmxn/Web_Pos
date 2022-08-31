<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblinventory where store='$store'");
if (mysqli_num_rows($result3)>0){?>
        <thead>
        <tr>
            <th style="width: 15%">Barcode</th>
            <th style="width: 25%">Name</th>
            <th style="width: 12%">Category</th>
            <th style="width: 12%">SubCategory</th>
            <th style="width: 12%">Packing</th>
            <th style="width: 10%">Price</th>
            <th style="width: 7%">Disc%</th>
            <th style="width: 7%">S.Tax%</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($res=mysqli_fetch_array($result3)) {
            $category3=$res['category'];
            $result4 = mysqli_query($con1, "Select * from tblcategory where category_id='$category3'");
            $res4=mysqli_fetch_array($result4);
            $category=$res4['category_name'];
            $subcategory3=$res['subcategory'];
            $result5 = mysqli_query($con1, "Select * from tblsubcategory where subcategory_id='$subcategory3'");
            $res5=mysqli_fetch_array($result5);
            $subcategory=$res5['subcategory_name'];
            $packing3=$res['packing'];
            $result6 = mysqli_query($con1, "Select * from tblpacking where packing_id='$packing3'");
            $res6=mysqli_fetch_array($result6);
            $packing=$res6['packing_name'];
            ?>
            <tr>
                <?php
                echo '<td>'.$res['inventory_barcode'].'</td>';
                echo '<td>'.$res['inventory_name'].'</td>';
                echo '<td>'.$category.'</td>';
                echo '<td>'.$subcategory.'</td>';
                echo '<td>'.$packing.'</td>';
                echo '<td>'.$res['saleprice'].'</td>';
                echo '<td>'.$res['saledisc'].'</td>';
                echo '<td>'.$res['saletax'].'</td>';?>
            </tr>
            <?php
        }
        ?>
        </tbody>
    <?php
}else{?>
        <thead>
        <tr>
            <th style="width: 15%">Barcode</th>
            <th style="width: 25%">Name</th>
            <th style="width: 12%">Category</th>
            <th style="width: 12%">SubCategory</th>
            <th style="width: 12%">Packing</th>
            <th style="width: 10%">Price</th>
            <th style="width: 7%">Disc%</th>
            <th style="width: 7%">S.Tax%</th>
        </tr>
        </thead>
        <tbody></tbody>
    <?php
}
?>

