<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result=mysqli_query($con,"Select * from tblusers");
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblusers')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
function checkDuplicate1($con,$name){
    $isDuplicate=false;
    $check=mysqli_query($con,"Select * from tblusers");
    while($res=mysqli_fetch_array($check)){
        if (strtolower(trim($name))==strtolower(trim($res['username']))){
            $isDuplicate=true;
            break;
        }
    }
    return $isDuplicate;
}
if (isset($_POST['save'])){
    $store_name=$_POST['name'];
    $store_address=$_POST['password'];
    $store_city=$_POST['role'];
    $store_contact=$_POST['store'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    if (!(checkDuplicate1($con,$store_name))){
        $result3=mysqli_query($con,"Insert into tblusers(username,password,role,store) VALUES ('$store_name','$store_address','$store_city','$storec')");
        if ($result3){
            echo "<script>alert('Data Added Successfully'); window.location.href='users.php';</script>";
        }
    }
    else{
        echo "<script>alert('Duplicate store detected. Kindly change the store name');window.location.href='users.php';</script>";
    }
}
if (isset($_POST['update'])){
    $store_id=$_POST['id'];
    $store_name=$_POST['name'];
    $store_address=$_POST['password'];
    $store_city=$_POST['role'];
    $store_contact=$_POST['store'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    $result8=mysqli_query($con,"Update tblusers Set username='$store_name',password='$store_address',role='$store_city',store='$storec' where userid='$store_id'");
    if ($result8){
        echo "<script>alert('Data Updated Successfully'); window.location.href='users.php';</script>";
    }
}
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result9=mysqli_query($con,"Delete from tblusers where userid='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='users.php';</script>";
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
<form action="users.php" method="POST" autocomplete="off" class="form">
    <div class="sec1">
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">User id</label>
                    <input class="input" type="text" name="id" id="id" readonly value="<?php echo $row;?>">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">User Name</label>
                    <input class="input" type="text" name="name" id="name" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">User Password</label>
                    <input class="input" type="text" name="password" id="password">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">User Role</label>
                    <Select class="input" id="role" name="role">
                        <option value="Admin">Admin</option>
                        <option value="Employee">Employee</option>
                    </Select>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store Assigned</label>
                    <input type="text" name="store" id="store" class="input">
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
                            <th style="width: 55%">User Name</th>
                            <th style="width: 30%">Role</th>
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

    function getPassword(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("password").value=myObj1;

            }
        };
        xmlhttp.open("GET","apis/admin_password.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getTable(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("table").innerHTML=myObj1;

            }
        };
        xmlhttp.open("GET","apis/user_table.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }
</script>
</body>
</html>
