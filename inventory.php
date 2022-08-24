<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblinventory')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
function checkDuplicate1($con,$name,$store){
    $isDuplicate=false;
    $check=mysqli_query($con,"Select * from tblinventory where store='$store'");
    while($res=mysqli_fetch_array($check)){
        if (strtolower(trim($name))==strtolower(trim($res['inventory_name']))){
            $isDuplicate=true;
            break;
        }
    }
    return $isDuplicate;
}
if (isset($_POST['save'])){
    $store_name=$_POST['name'];
    $store_contact=$_POST['store'];
    $inventory_barcode=$_POST['barcode'];
    $category=$_POST['category'];
    $subcategory=$_POST['subcategory'];
    $packing=$_POST['packing'];
    $inventory_qty=$_POST['quantity'];
    $inventory_minstock=$_POST['minstock'];
    $saleprice=$_POST['saleprice'];
    $purchaseprice=$_POST['purchaseprice'];
    $saledisc=$_POST['saledisc'];
    $purchasedisc=$_POST['purchasedisc'];
    $saletax=$_POST['saletax'];
    $purchasetax=$_POST['purchasetax'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    $categorya=mysqli_query($con,"Select * from tblcategory where category_name='$category' AND store='$storec'");
    $categoryb=mysqli_fetch_assoc($categorya);
    $categoryc=$categoryb['category_id'];
    $subcategorya=mysqli_query($con,"Select * from tblsubcategory where subcategory_name='$subcategory' AND store='$storec' AND category_id='$categoryc'");
    $subcategoryb=mysqli_fetch_assoc($subcategorya);
    $subcategoryc=$subcategoryb['subcategory_id'];
    $packinga=mysqli_query($con,"Select * from tblpacking where packing_name='$packing' AND store='$storec'");
    $packingb=mysqli_fetch_assoc($packinga);
    $packingc=$packingb['packing_id'];
    if (!(checkDuplicate1($con,$store_name,$storec))){
        $result3=mysqli_query($con,"Insert into tblinventory(inventory_name,store,inventory_barcode,category,subcategory,packing,inventory_qty,inventory_minstock,saleprice,purchaseprice,saledisc,purchasedisc,saletax,purchasetax) values('$store_name','$storec','$inventory_barcode','$categoryc','$subcategoryc','$packingc','$inventory_qty','$inventory_minstock','$saleprice','$purchaseprice','$saledisc','$purchasedisc','$saletax','$purchasetax')");
        if ($result3){
            echo "<script>alert('Data Added Successfully'); window.location.href='inventory.php';</script>";
        }
    }
    else{
        echo "<script>alert('Duplicate product detected. Kindly change the product name');window.location.href='inventory.php';</script>";
    }
}
if (isset($_POST['update'])){
    $id=$_POST['id'];
    $store_name=$_POST['name'];
    $store_contact=$_POST['store'];
    $inventory_barcode=$_POST['barcode'];
    $category=$_POST['category'];
    $subcategory=$_POST['subcategory'];
    $packing=$_POST['packing'];
    $inventory_qty=$_POST['quantity'];
    $inventory_minstock=$_POST['minstock'];
    $saleprice=$_POST['saleprice'];
    $purchaseprice=$_POST['purchaseprice'];
    $saledisc=$_POST['saledisc'];
    $purchasedisc=$_POST['purchasedisc'];
    $saletax=$_POST['saletax'];
    $purchasetax=$_POST['purchasetax'];
    $storea=mysqli_query($con,"Select * from tblstores where store_name='$store_contact'");
    $storeb=mysqli_fetch_assoc($storea);
    $storec=$storeb['store_id'];
    $categorya=mysqli_query($con,"Select * from tblcategory where category_name='$category' AND store='$storec'");
    $categoryb=mysqli_fetch_assoc($categorya);
    $categoryc=$categoryb['category_id'];
    $subcategorya=mysqli_query($con,"Select * from tblsubcategory where subcategory_name='$subcategory' AND store='$storec' AND category_id='$categoryc'");
    $subcategoryb=mysqli_fetch_assoc($subcategorya);
    $subcategoryc=$subcategoryb['subcategory_id'];
    $packinga=mysqli_query($con,"Select * from tblpacking where packing_name='$packing' AND store='$storec'");
    $packingb=mysqli_fetch_assoc($packinga);
    $packingc=$packingb['packing_id'];
    $result8=mysqli_query($con,"Update tblinventory set inventory_name='$store_name',store='$storec',inventory_barcode='$inventory_barcode',category='$categoryc',subcategory='$subcategoryc',packing='$packingc',inventory_qty='$inventory_qty',inventory_minstock='$inventory_minstock',saleprice='$saleprice',purchaseprice='$purchaseprice',saledisc='$saledisc',purchasedisc='$purchasedisc',saletax='$saletax',purchasetax='$purchasetax' where inventory_id='$id'");
    if ($result8){
        echo "<script>alert('Data Updated Successfully'); window.location.href='inventory.php';</script>";
    }
}
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result9=mysqli_query($con,"Delete from tblinventory where inventory_id='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='inventory.php';</script>";
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
    <title>INVENTORY</title>
    <link rel="stylesheet" href="css/stores.css">
</head>
<body>
<form action="inventory.php" method="POST" autocomplete="off" class="form">
    <div class="sec3">
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">id</label>
                    <input class="input1" type="text" name="id" id="id" readonly value="<?php echo $row;?>">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store</label>
                    <input class="input1" type="text" name="store" id="store" readonly>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Product Name</label>
                    <input class="input1" type="text" name="name" id="name" required>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Barcode</label>
                    <input class="input1" type="text" name="barcode" id="barcode" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Category</label>
                    <Select name="category" id="category" class="input1" onchange="getSubCategorySelect(localStorage.getItem('store'),this.value)"></Select>
                    </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">SubCategory</label>
                    <Select name="subcategory" id="subcategory" class="input1"></Select>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Packing</label>
                    <Select name="packing" id="packing" class="input1"></Select>
                </div>
            </div>
           <div class="col-3">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Quantity</label>
                    <input class="input2" type="text" name="quantity" id="quantity" required>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Min Stock</label>
                    <input class="input2" type="text" name="minstock" id="minstock" required>
                </div>
            </div>
           </div>
        </div>
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Sale Price</label>
                    <input class="input1" type="text" name="saleprice" id="saleprice" required>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Purchase Price</label>
                    <input class="input1" type="text" name="purchaseprice" id="purchaseprice" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div class="col-3">
                <div class="col-2">
                <div class="input-group">
                    <label class="label">Discount</label>
                    <input class="input2" type="text" name="saledisc" id="saledisc">
                </div>
                </div>
                <div class="col-2">
                <div class="input-group">
                    <label class="label">S.tax</label>
                    <input class="input2" type="text" name="saletax" id="saletax">
                </div>
                </div>
            </div>
            <div class="col-3">
                <div class="col-2">
                    <div class="input-group">
                        <label class="label">Discount</label>
                        <input class="input2" type="text" name="purchasedisc" id="purchasedisc">
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group">
                        <label class="label">S.tax</label>
                        <input class="input2" type="text" name="purchasetax" id="purchasetax">
                    </div>
                </div>
            </div>
        </div>
        <div class="buttons">
            <input type="submit" name="save" id="save" class="button" value="Save" style="background-color: #138913;border: 1px solid #138913;">
            <input type="submit" name="update" id="update" class="button" value="Update" style="background-color: orange;border: 1px solid orange;">
            <input type="submit" name="delete" id="delete" class="button" value="Delete" style="background-color: #e50a0a;border: 1px solid #e50a0a;">
        </div>
        </div>
        <div class="sec2">
            <div class="table2">
                <div class="table" id="table2">
                    <table class="styled-table" id="table">
                        <thead>
                        <tr>
                            <th style="width: 20%">ID</th>
                            <th style="width: 80%">Product Name</th>
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
    comboBox();
    getPackingSelect(localStorage.getItem("store"));

    function getTable(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                document.getElementById("table").innerHTML=myObj2;

            }
        };
        xmlhttp.open("GET","apis/inventory_table.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getCategorySelect(value){
        return new Promise((response)=>{
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);
                }
            };
            xmlhttp.open("GET","apis/invcategory_select.php?sec2increment1="+ value +"",true);
            xmlhttp.send();
        })
    }

    function getPackingSelect(value){
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    document.getElementById("packing").innerHTML=myObj2;
                }
            };
            xmlhttp.open("GET","apis/packing_select.php?sec2increment1="+ value +"",true);
            xmlhttp.send();
    }

    function getSubCategorySelect(value,value2){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                document.getElementById("subcategory").innerHTML=myObj2;

            }
        };
        xmlhttp.open("GET","apis/inventorysubcategory_select.php?sec2increment1="+ value +"&category="+value2,true);
        xmlhttp.send();
    }

    async function comboBox(){
        document.getElementById("category").innerHTML=await getCategorySelect(localStorage.getItem("store"));
        getSubCategorySelect(localStorage.getItem("store"),document.getElementById("category").value);
    }

    function getInventoryCategory(value){
        return new Promise((response)=>{
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);
                }
            };
            xmlhttp.open("GET","apis/getinventorycategory.php?sec2increment1="+ value +"",true);
            xmlhttp.send();
        })
    }

    function getInventorySubCategorySelect(value,value2){
        return new Promise((response)=>{
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);
                }
            };
            xmlhttp.open("GET","apis/getinventorysubcategoryselect.php?sec2increment1="+ value +"&category="+value2+"",true);
            xmlhttp.send();
        })
    }

    function getInventorySubCategory(value){
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    document.getElementById("subcategory").value=myObj2;
                }
            };
            xmlhttp.open("GET","apis/getinventorysubcategory.php?sec2increment1="+ value +"",true);
            xmlhttp.send();
    }

    function getalldata(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                let myObj3 = JSON.parse(myObj2);
                document.getElementById("barcode").value=myObj3['inventory_barcode'];
                document.getElementById("quantity").value=myObj3['inventory_qty'];
                document.getElementById("minstock").value=myObj3['inventory_minstock'];
                document.getElementById("saleprice").value=myObj3['saleprice'];
                document.getElementById("purchaseprice").value=myObj3['purchaseprice'];
                document.getElementById("saledisc").value=myObj3['saledisc'];
                document.getElementById("saletax").value=myObj3['saletax'];
                document.getElementById("purchasedisc").value=myObj3['purchasedisc'];
                document.getElementById("purchasetax").value=myObj3['purchasetax'];
            }
        };
        xmlhttp.open("GET","apis/getallinventorydata.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getPacking(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                document.getElementById("packing").value=myObj2;
            }
        };
        xmlhttp.open("GET","apis/getinventorypacking.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    async function getComboBox(value){
        let catgory=await getInventoryCategory(value);
        document.getElementById("category").value=catgory;
        document.getElementById('subcategory').innerHTML=await getInventorySubCategorySelect(localStorage.getItem("store"),catgory);
        getInventorySubCategory(value);
    }
</script>
</body>
</html>
