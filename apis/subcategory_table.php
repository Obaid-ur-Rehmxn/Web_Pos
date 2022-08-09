<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblsubcategory where store='$store'");
if (mysqli_num_rows($result3)>0){?>
    <table class="styled-table" id="table">
        <thead>
        <tr>
            <th style="width: 20%">ID</th>
            <th style="width: 80%">SubCategory Name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($res=mysqli_fetch_array($result3)) {?>
            <tr onclick="document.getElementById('id').value = this.cells[0].innerHTML;
            document.getElementById('name').value = this.cells[1].innerHTML;
            getCategory(this.cells[0].innerHTML);">
                <?php
                echo '<td>'.$res['subcategory_id'].'</td>';
                echo '<td>'.$res['subcategory_name'].'</td>';?>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}else{?>
    <table class="styled-table" id="table">
        <thead>
        <tr>
            <th style="width: 20%">ID</th>
            <th style="width: 80%">SubCategory Name</th>
        </tr>
        </thead>
    </table>
    <?php
}
?>

