<?php
$id=$_GET['id'];
require_once('./../db.php');
$con1 = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result3 = mysqli_query($con1, "Select * from tblexpense2 where expense_id='$id'");
if (mysqli_num_rows($result3)==0){?>
    <table class="styled-table1" id="table4">
        <thead>
        <tr>
            <th style="width: 70%">Narration</th>
            <th style="width: 30%">Amount</th>
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
            <th style="width: 70%">Narration</th>
            <th style="width: 30%">Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($res=mysqli_fetch_array($result3)) {?>
            <tr>
                <?php
                echo '<td contenteditable="true">'.$res['narration'].'</td>';?>
                <td contenteditable="true" onkeypress="if (event.key === 'Enter') {
                event.preventDefault();
                totalAmount();
                let count1 = (document.getElementById('table4').rows.length)-1;
                if (!((document.getElementById('table4').rows[count1].cells[0].innerHTML.trim()==='') || (document.getElementById('table4').rows[count1].cells[1].innerHTML.trim()===''))) {
                emptyRow();
                document.getElementById('table4').rows[count+1].cells[0].focus();
                }
                }"><?php echo $res['amount']?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>