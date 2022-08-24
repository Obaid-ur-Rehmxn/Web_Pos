<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result=mysqli_query($con,"Select * from tblstores");
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblstores')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
function checkDuplicate1($con,$name){
    $isDuplicate=false;
    $check=mysqli_query($con,"Select * from tblstores");
    while($res=mysqli_fetch_array($check)){
        if (strtolower(trim($name))==strtolower(trim($res['store_name']))){
            $isDuplicate=true;
            break;
        }
    }
    return $isDuplicate;
}
if (isset($_POST['save'])){
    $store_name=$_POST['name'];
    $store_address=$_POST['address'];
    $store_city=$_POST['city'];
    $store_contact=$_POST['contact'];
    $store_ntn=$_POST['ntn'];

    if (!(checkDuplicate1($con,$store_name))){
        $result3=mysqli_query($con,"Insert into tblstores(store_name,store_address,store_city,store_contact,store_ntn) VALUES ('$store_name','$store_address','$store_city','$store_contact','$store_ntn')");
        if ($result3){
            echo "<script>alert('Data Added Successfully'); window.location.href='stores.php';</script>";
        }
    }
    else{
        echo "<script>alert('Duplicate store detected. Kindly change the store name');window.location.href='stores.php';</script>";
    }
}
if (isset($_POST['update'])){
    $store_id=$_POST['id'];
    $store_name=$_POST['name'];
    $store_address=$_POST['address'];
    $store_city=$_POST['city'];
    $store_contact=$_POST['contact'];
    $store_ntn=$_POST['ntn'];
    $result8=mysqli_query($con,"Update tblstores Set store_name='$store_name',store_address='$store_address',store_city='$store_city',store_contact='$store_city',store_ntn='$store_ntn' where store_id='$store_id'");
    if ($result8){
        echo "<script>alert('Data Updated Successfully'); window.location.href='stores.php';</script>";
    }
}
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result9=mysqli_query($con,"Delete from tblstores where store_id='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='stores.php';</script>";
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
    <title>STORES</title>
    <link rel="stylesheet" href="css/stores.css">
</head>
<body>
<form action="stores.php" method="POST" autocomplete="off" class="form">
    <div class="sec1">
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store id</label>
                    <input class="input" type="text" name="id" id="id" readonly value="<?php echo $row;?>">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store Name</label>
                    <input class="input" type="text" name="name" id="name" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store Address</label>
                    <input class="input" type="text" name="address" id="address">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store City</label>
                    <input class="input" type="text" name="city" id="city">
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store Contact</label>
                    <input class="input" type="text" name="contact" id="contact">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store NTN</label>
                    <input class="input" type="text" name="ntn" id="ntn">
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
                            <th style="width: 15%">Store ID</th>
                            <th style="width: 85%">Store Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($res=mysqli_fetch_array($result)) {
                            echo '<tr>';
                            echo '<td>'.$res['store_id'].'</td>';
                            echo '<td>'.$res['store_name'].'</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</form>
<script>
    let table = document.getElementById('table').getElementsByTagName('tbody')[0];

    for (let i = 0; i < table.rows.length; i++) {
        table.rows[i].onclick = function () {
            document.getElementById("id").value = this.cells[0].innerHTML;
            document.getElementById("name").value = this.cells[1].innerHTML;
            getAddress(this.cells[0].innerHTML);
            getCity(this.cells[0].innerHTML);
            getContact(this.cells[0].innerHTML);
            getNTN(this.cells[0].innerHTML);
        };
    }

    function getAddress(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("address").value=myObj1;

            }
        };
        xmlhttp.open("GET","apis/store_address.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getCity(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("city").value=myObj1;

            }
        };
        xmlhttp.open("GET","apis/store_city.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getContact(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("contact").value=myObj1;

            }
        };
        xmlhttp.open("GET","apis/store_contact.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getNTN(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                document.getElementById("ntn").value=myObj1;

            }
        };
        xmlhttp.open("GET","apis/store_ntn.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }
</script>
</body>
</html>
