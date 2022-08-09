<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblsubcategory')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
function checkDuplicate1($con,$name,$store,$category){
    $isDuplicate=false;
    $check=mysqli_query($con,"Select * from tblsubcategory where store='$store' AND category_id='$category'");
    while($res=mysqli_fetch_array($check)){
        if (strtolower(trim($name))==strtolower(trim($res['subcategory_name']))){
            $isDuplicate=true;
            break;
        }
    }
    return $isDuplicate;
}
if (isset($_POST['save'])){
    $store_name=$_POST['name'];
    $store_contact=$_POST['store'];
    $category=$_POST['category'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    $categorya=mysqli_query($con,"Select * from tblcategory where category_name='$category' AND store='$storec'");
    $categoryb=mysqli_fetch_assoc($storea);
    $categoryc=$storeb['category_id'];
    if (!(checkDuplicate1($con,$store_name,$storec,$categoryc))){
        $result3=mysqli_query($con,"Insert into tblsubcategory(subcategory_name,category_id,store) VALUES ('$store_name','$categoryc','$storec')");
        if ($result3){
            echo "<script>alert('Data Added Successfully'); window.location.href='inventory_subcategory.php';</script>";
        }
    }
    else{
        echo "<script>alert('Duplicate subcategory detected. Kindly change the subcategory name');window.location.href='inventory_subcategory.php';</script>";
    }
}
if (isset($_POST['update'])){
    $store_id=$_POST['id'];
    $store_name=$_POST['name'];
    $store_contact=$_POST['store'];
    $category=$_POST['category'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    $categorya=mysqli_query($con,"Select * from tblcategory where category_name='$category' AND store='$storec'");
    $categoryb=mysqli_fetch_assoc($storea);
    $categoryc=$storeb['category_id'];
        $result8=mysqli_query($con,"Update tblsubcategory set subcategory_name='$store_name',store='$storec',category_id='$categoryc' where subcategory_id='$store_id'");
        if ($result8){
            echo "<script>alert('Data Updated Successfully'); window.location.href='inventory_subcategory.php';</script>";
        }
}
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result9=mysqli_query($con,"Delete from tblsubcategory where subcategory_id='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='inventory_subcategory.php';</script>";
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
    <title>WEB - POS</title>
    <link rel="stylesheet" href="css/stores.css">
</head>
<body>
<form action="inventory_subcategory.php" method="POST" autocomplete="off" class="form">
    <div class="sec1">
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">SubCategory id</label>
                    <input class="input" type="text" name="id" id="id" readonly value="<?php echo $row;?>">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">SubCategory Name</label>
                    <input class="input" type="text" name="name" id="name" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Category</label>
                    <Select name="category" id="category" class="input"></Select>
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
                            <th style="width: 20%">ID</th>
                            <th style="width: 80%">Category Name</th>
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
    getCategorySelect(localStorage.getItem("store"));

    function getTable(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("table").innerHTML=myObj1;

            }
        };
        xmlhttp.open("GET","apis/subcategory_table.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getCategorySelect(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("category").innerHTML=myObj1;

            }
        };
        xmlhttp.open("GET","apis/subcategory_select.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getCategory(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("category").value=myObj1;

            }
        };
        xmlhttp.open("GET","apis/category.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }
</script>
</body>
</html>
