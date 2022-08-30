<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblclient')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
function checkDuplicate1($con,$name,$store){
    $isDuplicate=false;
    $check=mysqli_query($con,"Select * from tblclient where store='$store'");
    while($res=mysqli_fetch_array($check)){
        if (strtolower(trim($name))==strtolower(trim($res['client_name']))){
            $isDuplicate=true;
            break;
        }
    }
    return $isDuplicate;
}
if (isset($_POST['save'])){
    $store_name=$_POST['name'];
    $mno=$_POST['mno'];
    $address=$_POST['address'];
    $wno=$_POST['wno'];
    $cnic=$_POST['cnic'];
    $customer=isset($_POST['customer']);
    $vendor=isset($_POST['vendor']);
    $store_contact=$_POST['store'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    if (!(checkDuplicate1($con,$store_name,$storec))){
        $result3=mysqli_query($con,"Insert into tblclient(client_name,mno,address,wno,cnic,customer,vendor,store) values('$store_name','$mno','$address','$wno','$cnic','$customer','$vendor','$storec')");
        if ($result3){
            echo "<script>alert('Data Added Successfully'); window.location.href='parties.php';</script>";
        }
    }
    else{
        echo "<script>alert('Duplicate client detected. Kindly change the client name');window.location.href='parties.php';</script>";
    }
}
if (isset($_POST['update'])){
    $store_id=$_POST['id'];
    $store_name=$_POST['name'];
    $mno=$_POST['mno'];
    $address=$_POST['address'];
    $wno=$_POST['wno'];
    $cnic=$_POST['cnic'];
    $customer=isset($_POST['customer']);
    $vendor=isset($_POST['vendor']);
    $store_contact=$_POST['store'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
        $result8=mysqli_query($con,"Update tblclient set client_name='$store_name',mno='$mno',address='$address',wno='$wno',cnic='$cnic',customer='$customer',vendor='$vendor',store='$storec' where client_id='$store_id'");
        if ($result8){
            echo "<script>alert('Data Updated Successfully'); window.location.href='parties.php';</script>";
        }
}
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result9=mysqli_query($con,"Delete from tblclient where client_id='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='parties.php';</script>";
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
    <title>CLIENTS</title>
    <link rel="stylesheet" href="css/stores.css">
</head>
<body>
<form action="parties.php" method="POST" autocomplete="off" class="form">
    <div class="sec4">
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Client id</label>
                    <input class="input" type="text" name="id" id="id" readonly value="<?php echo $row;?>">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Client Name</label>
                    <input class="input" type="text" name="name" id="name" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Mobile no</label>
                    <input class="input" type="number" name="mno" id="mno">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Whatsapp no</label>
                    <input class="input" type="number" name="wno" id="wno">
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="full">
                <div class="input-group">
                    <label class="label">Address</label>
                    <input class="input" style="width: 92%" type="text" name="address" id="address">
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">NTN/CNIC</label>
                    <input class="input" type="text" name="cnic" id="cnic">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store</label>
                    <input class="input" type="text" name="store" id="store" readonly>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div style="display: flex;align-items: center; margin: 10px 0">
                    <input style="margin: 0 5px" type="checkbox" name="customer" id="customer">
                    <label class="label">Customer</label>
                </div>
            </div>
            <div class="col-2">
                <div style="display: flex;align-items: center">
                    <input style="margin: 0 5px" type="checkbox" name="vendor" id="vendor">
                    <label class="label">Vendor</label>
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
                            <th style="width: 80%">Client Name</th>
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
        xmlhttp.open("GET","apis/client_table.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getAllData(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                let myObj2 = JSON.parse(myObj1.replace(/^\s*[\r\n]/gm, ""));
                console.log(myObj2);
                document.getElementById("mno").value=myObj2['mno'];
                document.getElementById("wno").value=myObj2['wno'];
                document.getElementById("address").value=myObj2['address'];
                document.getElementById("cnic").value=myObj2['cnic'];
                if(myObj2['customer']==1){
                    document.getElementById("customer").checked=true;
                }
                else{
                    document.getElementById("customer").checked=false;
                }
                if(myObj2['vendor']==1){
                    document.getElementById("vendor").checked=true;
                }
                else{
                    document.getElementById("vendor").checked=false;
                }
            }
        };
        xmlhttp.open("GET","apis/client_alldata.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }
</script>
</body>
</html>
