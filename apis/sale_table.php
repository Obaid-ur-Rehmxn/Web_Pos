<?php
$pname=$_GET['sec2increment1'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$store2=mysqli_query($con1,"Select * from tblstores where store_name='$pname'");
$store1=mysqli_fetch_assoc($store2);
$store=$store1['store_id'];
$result3 = mysqli_query($con1, "Select * from tblsales1 where store='$store'");
if (mysqli_num_rows($result3)>0){?>
    <table class="styled-table" id="table">
        <thead>
        <tr>
            <th style="width: 15%">ID</th>
            <th style="width: 30%">Date</th>
            <th style="width: 55%">Name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($res=mysqli_fetch_array($result3)) {
            $category3=$res['customer'];
            $result4 = mysqli_query($con1, "Select * from tblclient where client_id='$category3'");
            $res4=mysqli_fetch_array($result4);
            $category=$res4['client_name'];
            ?>
            <tr onclick="document.getElementById('id').value = this.cells[0].innerHTML;
            document.getElementById('date').value = this.cells[1].innerHTML;
             document.getElementById('name').value=this.cells[2].innerHTML;
                returnSale1Data(this.cells[0].innerHTML);
                returnTable(this.cells[0].innerHTML)">
                <?php
                echo '<td>'.$res['sales_id'].'</td>';
                echo '<td>'.$res['date'].'</td>';
                echo '<td>'.$category.'</td>';?>
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
            <th style="width: 15%">ID</th>
            <th style="width: 30%">Date</th>
            <th style="width: 55%">Name</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
    <?php
}
?>

