<?php
$id=$_GET['id'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3 = mysqli_query($con1, "Select * from tblpurchase2 where purchase_id='$id'");
if (mysqli_num_rows($result3)==0){?>
    <table class="styled-table1" id="table4">
        <thead>
        <tr>
            <th style="width: 20%">Barcode</th>
            <th style="width: 30%">Name</th>
            <th style="width: 11%">Price</th>
            <th style="width: 9%">Disc%</th>
            <th style="width: 9%">S.Tax%</th>
            <th style="width: 9%">Qty</th>
            <th style="width: 12%">Net</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <?php
}else{?>
    <table class="styled-table1" id="table4">
        <thead>
        <tr>
            <th style="width: 20%">Barcode</th>
            <th style="width: 30%">Name</th>
            <th style="width: 11%">Price</th>
            <th style="width: 9%">Disc%</th>
            <th style="width: 9%">S.Tax%</th>
            <th style="width: 9%">Qty</th>
            <th style="width: 12%">Net</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        while ($res=mysqli_fetch_array($result3)) {
            $product=$res['product'];
            $result1=mysqli_query($con1,"Select * from tblinventory where inventory_id='$product'");
            $res1=mysqli_fetch_array($result1);
            $barcode=$res1['inventory_barcode'];
            $name=$res1['inventory_name'];
            ?>
            <tr>
                <td contenteditable="true" onkeydown="if (e.code === 'ControlLeft' || e.code === 'ControlRight') {
                    jugaar=document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].cells[0].innerHTML;
                    document.getElementById('searchform1').style.display = 'block';
                    }
                    else if (e.code === 'Delete') {
                    if (document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].cells[0].innerHTML!='') {
                    document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].remove();
                    totalAmount();
                    }
                    }"><?php echo $barcode?></td>
                <?php
                echo '<td>'.$name.'</td>';
                echo '<td contenteditable="true">'.$res['price'].'</td>';
                echo '<td contenteditable="true">'.$res['disc'].'</td>';
                echo '<td contenteditable="true">'.$res['stax'].'</td>';?>
                <td contenteditable="true" onkeypress="if (event.key === 'Enter') {
                    event.preventDefault();
                    let price=parseInt(document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].cells[2].innerHTML);
                    let disc=parseInt(document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].cells[3].innerHTML);
                    let stax=parseInt(document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].cells[4].innerHTML);
                    let onemore=(price+(price*(stax/100)));
                    let qty=parseInt(document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].cells[5].innerHTML);
                    let net=Math.round((onemore-(onemore*(disc/100)))*qty);
                    document.getElementById('table4').getElementsByTagName('tbody')[0].rows[<?php echo $i ?>].cells[6].innerHTML=net.toString();
                    totalAmount();
                    let count1 = (document.getElementById('table4').rows.length)-1;
                    if (!((document.getElementById('table4').rows[count1].cells[0].innerHTML.trim()==='') || (document.getElementById('table4').rows[count1].cells[1].innerHTML.trim()==='') || (document.getElementById('table4').rows[count1].cells[6].innerHTML.trim()===''))) {
                    emptyRow();
                    document.getElementById('table4').rows[count+1].cells[0].focus();
                    }
                    }"><?php echo $res['qty']?></td>
                <?php
                echo '<td>'.$res['net'].'</td>';
                ?>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>