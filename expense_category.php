<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result=mysqli_query($con,"Select * from tblcategory");
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblexpensecategory')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
function checkDuplicate1($con,$name,$store){
    $isDuplicate=false;
    $check=mysqli_query($con,"Select * from tblexpensecategory where store='$store'");
    while($res=mysqli_fetch_array($check)){
        if (strtolower(trim($name))==strtolower(trim($res['category_name']))){
            $isDuplicate=true;
            break;
        }
    }
    return $isDuplicate;
}
if (isset($_POST['save'])){
    $store_name=$_POST['name'];
    $type=$_POST['type'];
    $store_contact=$_POST['store'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    if (!(checkDuplicate1($con,$store_name,$storec))){
        $result3=mysqli_query($con,"Insert into tblexpensecategory(category_name,category_type,store) values('$store_name','$type','$storec')");
        if ($result3){
            echo "<script>alert('Data Added Successfully'); window.location.href='expense_category.php';</script>";
        }
    }
    else{
        echo "<script>alert('Duplicate category detected. Kindly change the category name');window.location.href='expense_category.php';</script>";
    }
}
if (isset($_POST['update'])){
    $store_id=$_POST['id'];
    $store_name=$_POST['name'];
    $type=$_POST['type'];
    $store_contact=$_POST['store'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
        $result8=mysqli_query($con,"Update tblexpensecategory set category_name='$store_name',category_type='$type',store='$storec' where category_id='$store_id'");
        if ($result8){
            echo "<script>alert('Data Updated Successfully'); window.location.href='expense_category.php';</script>";
        }
}
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result9=mysqli_query($con,"Delete from tblexpensecategory where category_id='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='expense_category.php';</script>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CATEGORY</title>
    <link rel="stylesheet" href="css/stores.css">
</head>
<body>
<form action="expense_category.php" method="POST" autocomplete="off" class="form">
    <div class="sec1">
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Category id</label>
                    <input class="input" type="text" name="id" id="id" readonly value="<?php echo $row;?>">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Category Name</label>
                    <input class="input" type="text" name="name" id="name" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Expense Type</label>
                    <Select name="type" id="type" class="input">
                        <option value="General Expense">General Expense</option>
                        <option value="Other Expense">Other Expense</option>
                        <option value="Sales Expense">Sales Expense</option>
                        <option value="Purchase Expense">Purchase Expense</option>
                        <option value="Utilities">Utilities</option>
                    </Select>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store</label>
                    <input class="input" type="text" name="store" id="store" readonly>
                </div>
            </div>
        </div>
        <div class="buttons">
            <input type="submit" name="save" id="save" class="button" value="Save" style="background-color: #138913;border: 1px solid #138913;">
            <input type="submit" name="update" id="update" class="button" value="Update" style="background-color: orange;border: 1px solid orange;">
            <input type="submit" name="delete" id="delete" class="button" value="Delete" style="background-color: #e50a0a;border: 1px solid #e50a0a;">
        </div>
        <div class="sec2">
            <div class="table2">
                <div class="table" id="table2">
                    <table class="styled-table" id="table">
                        <thead>
                        <tr>
                            <th style="width: 15%">ID</th>
                            <th style="width: 50%">Category Name</th>
                            <th style="width: 35%">Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</form>
<script>
    document.getElementById('store').value=localStorage.getItem("store");
    getTable(localStorage.getItem("store"));

    function getTable(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("table").innerHTML=myObj1;

            }
        };
        xmlhttp.open("GET","apis/expensecategory_table.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }
</script>
</body>
</html>
