<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblpurchase1')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result10=mysqli_query($con,"Delete from tblpurchase2 where purchase_id='$store_id'");
    $result9=mysqli_query($con,"Delete from tblpurchase1 where purchase_id='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='purchase_invoice.php';</script>";
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
    <title>Purchase Invoice</title>
    <link rel="stylesheet" href="css/expense.css">
    <link rel="stylesheet" href="css/saleprint.css">
</head>
<body>
<form action="purchase_invoice.php" method="POST" autocomplete="off" class="form">
    <div id="invoice-POS" class="abc1">

        <div id="mid">
            <div class="info">
                <h2 style="text-align: center;font-size: 1em;">Contact Info</h2>
                <p style="font-size: 0.7em" id="printid"></p>
                <p style="font-size: 0.7em" id="printdate"></p>
                <p style="font-size: 0.7em" id="printname"></p>
            </div>
        </div><!--End Invoice Mid-->

        <div id="bot">

            <div id="table7">
                <table id="table8" class="table8">
                    <thead>
                    <tr class="tabletitle">
                        <td style="width: 65%;padding: 5px 0 5px 15px;"><h3 style="font-size: 0.7em">Item</h3></td>
                        <td style="width: 10%;text-align: center"><h3 style="font-size: 0.7em">Qty</h3></td>
                        <td style="width: 20%;text-align: center"><h3 style="font-size: 0.7em">Net</h3></td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="abc">Total</td>
                        <td class="abc" id="total"></td>
                    </tr>

                </table>
            </div><!--End Table-->

            <div id="legalcopy">
                <p style="text-align: center"><strong style="font-size: 0.8em">Thank you for your business!</strong>
                </p>
            </div>

        </div><!--End InvoiceBot-->
    </div><!--End Invoice-->

    <div class="searchform1" id="searchform1">
            <span onclick="document.getElementById('searchform1').style.display='none'"
                  class="close" title="Close">&times;</span>
        <div class="field">
            <div class="field1">
                <div class="field5">
                    <p style="font-size: 13px">Category</p>
                    <Select name="category" id="category" class="input2" onchange="filterBySubcategory(localStorage.getItem('store'),this.value)"></Select>
                </div>
                <div class="field5" style="margin-left: 2%">
                    <p style="font-size: 13px">Sub Category</p>
                    <Select name="subcategory" id="subcategory" class="input2" onchange="myFunction1()">
                    </Select>
                </div>
            </div>
            <div class="field1">
                <div class="field6">
                    <p style="font-size: 13px">Name</p>
                    <input type="text" id="partysearch" name="partysearch" class="input2" onkeyup="myFunction()">
                </div>
            </div>
        </div>
        <div class="table6">
            <div class="table4" id="table5">
                <table class="styled-table1" id="table6">
                    <thead>
                    <tr>
                        <th style="width: 15%">Barcode</th>
                        <th style="width: 25%">Name</th>
                        <th style="width: 12%">Category</th>
                        <th style="width: 12%">SubCategory</th>
                        <th style="width: 12%">Packing</th>
                        <th style="width: 10%">Price</th>
                        <th style="width: 7%">Disc%</th>
                        <th style="width: 7%">S.Tax%</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="sec1">
        <div class="sec11">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Invoice id</label>
                    <input class="input" type="text" name="id" id="id" readonly value="<?php echo $row;?>">
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Store</label>
                    <input class="input" type="text" name="store" id="store" readonly>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Invoice Date</label>
                    <input class="input" type="date" name="date" id="date" required>
                </div>
            </div>
        </div>
        <div class="sec11">
            <div style="width: 73%">
                <div class="input-group">
                    <label class="label">Vendor Name</label>
                    <Select name="name" id="name" class="input"></Select>
                </div>
            </div>
        </div>
        <div class="table5">
            <div class="table4" id="table3">
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
            </div>
        </div>
        <div class="last1">
            <div class="last11">
                <div class="input-group1">
                    <label class="label">Total Amount</label>
                    <input class="input1" type="number" name="amount" id="amount" readonly>
                </div>
                <div class="input-group1">
                    <label class="label">Amount Paid</label>
                    <input class="input1" type="number" name="cash" id="cash" onkeyup="changeReturn()">
                </div>
                <div class="input-group1">
                    <label class="label">Return</label>
                    <input class="input1" type="number" name="change" id="change" readonly>
                </div>
            </div>
            <div class="last11">
                <div class="buttons1">
                    <input type="button" name="save" id="save" class="button1" value="Save" style="background-color: #138913;border: 1px solid #138913;" onclick="insertSale()">
                    <input type="button" name="update" id="update" class="button1" value="Update" style="background-color: orange;border: 1px solid orange;" onclick="updateExpense()">
                    <input type="button" name="print" id="print" class="button1" value="Print" style="background-color: dodgerblue;border: 1px solid dodgerblue;" onclick="printDiv()">
                    <input type="submit" name="delete" id="delete" class="button1" value="Delete" style="background-color: #e50a0a;border: 1px solid #e50a0a;">
                </div>
            </div>
        </div>
    </div>
    <div class="sec2">
        <div class="table2">
            <div class="table" id="table2">
                <table class="styled-table" id="table">
                    <thead>
                    <tr>
                        <th style="width: 15%">ID</th>
                        <th style="width: 30%">Date</th>
                        <th style="width: 55%">Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
<script src=" https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script>
    let jugaar;
    let today = new Date().toISOString().slice(0, 10)
    document.getElementById("date").value = today;
    document.getElementById('store').value = localStorage.getItem('store');
    emptyRow();
    getCustomerSelect(localStorage.getItem('store'));
    getComboBox(localStorage.getItem('store'));
    showtablethenanother();
    getTable(localStorage.getItem('store'));

    function getCustomerSelect(store) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let myObj1=this.responseText;
                let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                document.getElementById('name').innerHTML = myObj2;
            }
        };
        xhttp.open("GET", "apis/purchase_customerselect.php?store=" + store+"", true);
        xhttp.send();
    }

    function emptyRow(){
        let table = document.getElementById("table4").getElementsByTagName('tbody')[0];
        let count = (table.rows.length);
        let row = table.insertRow(count);
        let cell1 = row.insertCell(0);
        let cell2 = row.insertCell(1);
        let cell3 = row.insertCell(2);
        let cell4 = row.insertCell(3);
        let cell5 = row.insertCell(4);
        let cell6 = row.insertCell(5);
        let cell7 = row.insertCell(6);
        cell1.addEventListener("keydown", (e) => {
            if (e.code === "ControlLeft" || e.code === "ControlRight") {
                jugaar=cell1.innerHTML;
                document.getElementById('searchform1').style.display = 'block';
            }
            else if (e.code === "Delete") {
                if (cell1.innerHTML!="") {
                    row.remove();
                    totalAmount();
                }
            }
        });
        cell6.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                let price=parseInt(cell3.innerHTML);
                let disc=parseInt(cell4.innerHTML);
                let stax=parseInt(cell5.innerHTML);
                let onemore=(price+(price*(stax/100)));
                let qty=parseInt(cell6.innerHTML);
                let net=Math.round((onemore-(onemore*(disc/100)))*qty);
                cell7.innerHTML=net.toString();
                totalAmount();
                let count1 = (table.rows.length)-1;
                if (!((table.rows[count1].cells[0].innerHTML.trim()==="") || (table.rows[count1].cells[1].innerHTML.trim()==="") || (table.rows[count1].cells[6].innerHTML.trim()===""))) {
                    emptyRow();
                    table.rows[count+1].cells[0].focus();
                }
            }
        });
        cell1.contentEditable= true;
        cell3.contentEditable= true;
        cell4.contentEditable= true;
        cell5.contentEditable= true;
        cell6.contentEditable= true;
    }

    function totalAmount(){
        let table = document.getElementById("table4").getElementsByTagName('tbody')[0];
        let count = (table.rows.length);
        let amount = 0;
        for(let i=0;i<count;i++){
            let amount1 = table.rows[i].cells[6].innerHTML;
            if (amount1.trim()!=="") {
                amount += parseInt(amount1);
            }
        }
        document.getElementById('amount').value = amount;
    }

    function getTable(value){
        let xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function (){
            if (this.readyState==4 && this.status==200){
                let myObj1=this.responseText;
                let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                document.getElementById("table").innerHTML=myObj2;

            }
        };
        xmlhttp.open("GET","apis/purchase_table.php?sec2increment1="+ value +"",true);
        xmlhttp.send();
    }

    function getTable1(value){
        return new Promise((response)=> {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let myObj1 = this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);
                }
            };
            xmlhttp.open("GET", "apis/purchase_table1.php?sec2increment1=" + value + "", true);
            xmlhttp.send();
        });
    }

    function insertSale1(){
        return new Promise((response)=> {
            let date = document.getElementById('date').value;
            let store = document.getElementById('store').value;
            let customer = document.getElementById('name').value;
            let cash = document.getElementById('cash').value;
            let returncash = document.getElementById('change').value;
            let amount = document.getElementById('amount').value;
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);

                }
            };
            xmlhttp.open("GET","apis/insertpurchase1.php?date="+ date +"&store="+store+"&customer="+customer+"&cash="+cash+"&amount="+amount+"&returncash="+returncash+"",true);
            xmlhttp.send();
        });
    }

    function insertSale2(){
        return new Promise((response)=> {
            let id=document.getElementById('id').value;
            let myObj2="";
            let table = document.getElementById('table4').getElementsByTagName('tbody')[0];
            for (let j = 0; j < table.rows.length-1; j++) {
                let xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange=function (){
                    if (this.readyState==4 && this.status==200){
                        let myObj1=this.responseText;
                        myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    }
                };
                xmlhttp.open("GET","apis/insertpurchase2.php?id="+ id +"&product="+table.rows[j].cells[0].innerHTML+"&price="+table.rows[j].cells[2].innerHTML+"&disc="+table.rows[j].cells[3].innerHTML+"&stax="+table.rows[j].cells[4].innerHTML+"&qty="+table.rows[j].cells[5].innerHTML+"&net="+table.rows[j].cells[6].innerHTML+"",true);
                xmlhttp.send();
            }
            response("done");
        });
    }

    async function insertSale(){
        let inertexpense1 = await insertSale1();
        if (inertexpense1==="1") {
            let inertexpense2 = await insertSale2();
            alert("Invoice Inserted Successfully");
            location.reload();
        }
        else{
            alert("Some Error Occurred");
        }
    }

    function updateExpense1(){
        return new Promise((response)=> {
            let id = document.getElementById('id').value;
            let date = document.getElementById('date').value;
            let store = document.getElementById('store').value;
            let customer = document.getElementById('name').value;
            let cash = document.getElementById('cash').value;
            let returncash = document.getElementById('change').value;
            let amount = document.getElementById('amount').value;
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);

                }
            };
            xmlhttp.open("GET","apis/updatepurchase1.php?id="+id+"&date="+ date +"&store="+store+"&customer="+customer+"&cash="+cash+"&amount="+amount+"&returncash="+returncash+"",true);
            xmlhttp.send();
        });
    }

    function updateExpense2(){
        return new Promise((response)=> {
            let id = document.getElementById('id').value;
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function (){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);

                }
            };
            xmlhttp.open("GET","apis/updatepurchase2.php?id="+id+"",true);
            xmlhttp.send();
        });
    }

    async function updateExpense(){
        let updateexpense1 = await updateExpense1();
        if (updateexpense1==="1") {
            let updateexpense2 = await updateExpense2();
            if (updateexpense2 === "1") {
                await insertSale2();
                alert("Invoice Updated Successfully");
                location.reload();
            } else {
                alert("Some Error Occurred");
            }
        }
        else{
            alert("Some Error Occurred");
        }
    }

    function returnSale1Data(value){
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let myObj1=this.responseText;
                let myObj2 = JSON.parse(myObj1.replace(/^\s*[\r\n]/gm, ""));
                document.getElementById('amount').value = myObj2['amount'];
                document.getElementById('change').value = myObj2['returncash'];
                document.getElementById('cash').value = myObj2['cash'];

            }
        };
        xhttp.open("GET", "apis/returnpurchase1data.php?id="+ value+"", true);
        xhttp.send();
    }

    function returnTable1(value){
        return new Promise((response)=> {
            let xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function(){
                if (this.readyState==4 && this.status==200){
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    response(myObj2);

                }
            };
            xmlhttp.open("GET","apis/returnpurchasetable.php?id="+value+"",true);
            xmlhttp.send();
        });
    }

    async function returnTable(value){
        let table1 = await returnTable1(value);
        let table = document.getElementById('table3');
        table.innerHTML = table1;
        emptyRow();
    }

    function changeReturn(){
        let amount = document.getElementById('amount').value;
        if (amount === "") {
            amount="0";
        }
        let cash = document.getElementById('cash').value;
        let change = parseInt(cash) - parseInt(amount);
        document.getElementById('change').value = change;
    }

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue,input1,filter1,td1,txtValue1;
        input = document.getElementById("partysearch");
        filter = input.value.toUpperCase();
        input1 = document.getElementById("subcategory");
        filter1 = input1.value.toUpperCase();
        table = document.getElementById("table6");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            td1 = tr[i].getElementsByTagName("td")[3];
            if (td || td1) {
                txtValue = td.textContent || td.innerText;
                txtValue1 = td1.textContent.toUpperCase();
                if ((txtValue.toUpperCase().indexOf(filter) > -1) && (txtValue1==filter1)) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function myFunction1(){
        var input, filter, table, tr, td, i, txtValue;
        document.getElementById('partysearch').value="";
        input = document.getElementById("subcategory");
        filter = input.value.toUpperCase();
        table = document.getElementById("table6");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
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
            xmlhttp.open("GET","apis/salecategory_select.php?sec2increment1="+ value +"",true);
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
            xmlhttp.open("GET","apis/salesubcategoryselect.php?sec2increment1="+ value +"&category="+value2+"",true);
            xmlhttp.send();
        })
    }

    async function getComboBox(value){
        document.getElementById('category').innerHTML=await getCategorySelect(value);
        document.getElementById('subcategory').innerHTML=await getInventorySubCategorySelect(value,document.getElementById('category').value);
        myFunction1();
    }

    async function filterBySubcategory(value,value1){
        document.getElementById('subcategory').innerHTML=await getInventorySubCategorySelect(value,value1);
        myFunction1();
    }

    function jugaar2() {
        let table3 = document.getElementById('table6').getElementsByTagName('tbody')[0];
        for (let j = 0; j < table3.rows.length; j++) {
            table3.rows[j].onclick = function () {
                let table2 = document.getElementById('table4').getElementsByTagName('tbody')[0];
                for (let i = 0; i < table2.rows.length; i++) {
                    if (table2.rows[i].cells[0].innerHTML === jugaar) {
                        table2.rows[i].cells[0].innerHTML = table3.rows[j].cells[0].innerHTML;
                        table2.rows[i].cells[1].innerHTML = table3.rows[j].cells[1].innerHTML;
                        table2.rows[i].cells[2].innerHTML = table3.rows[j].cells[5].innerHTML;
                        table2.rows[i].cells[3].innerHTML = table3.rows[j].cells[6].innerHTML;
                        table2.rows[i].cells[4].innerHTML = table3.rows[j].cells[7].innerHTML;
                        document.getElementById('searchform1').style.display = "none";
                        table2.rows[i].cells[5].focus();
                    }
                }
            }
        }
    }

    async function showtablethenanother(){
        document.getElementById('table6').innerHTML=await getTable1(localStorage.getItem('store'));
        jugaar2();
    }

    function printDiv(){
        document.getElementById("printid").innerHTML="Invoice id: "+document.getElementById("id").value+"";
        document.getElementById("printdate").innerHTML="Date: "+document.getElementById("date").value+"";
        document.getElementById("printname").innerHTML="Vendor: "+document.getElementById("name").value+"";
        let table4=document.getElementById("table4").getElementsByTagName("tbody")[0];
        let table8=document.getElementById("table8").getElementsByTagName("tbody")[0];
        table8.innerHTML="";
        for(let i=0;i<table4.rows.length;i++) {
            if (table4.rows[i].cells[1].innerHTML != "") {
                let row = table8.insertRow(i);
                row.className = "service";
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);
                cell1.className = "itemtext1";
                cell2.className = "itemtext";
                cell3.className = "itemtext";
                cell1.innerHTML = table4.rows[i].cells[1].innerHTML;
                cell2.innerHTML = table4.rows[i].cells[5].innerHTML;
                cell3.innerHTML = table4.rows[i].cells[6].innerHTML;
            }
        }
        document.getElementById("total").innerHTML=document.getElementById("amount").value;
        printData();
    }

    function printData(){
        printJS({
            printable: "invoice-POS",
            type: "html",
            css: "css/saleprint.css",
        });
    }
</script>
</body>
</html>