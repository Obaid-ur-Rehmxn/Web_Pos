<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result2=mysqli_query($con,"Select Auto_increment as id from information_schema.Tables where (TABLE_name='tblexpense1')");
$count=mysqli_fetch_assoc($result2);
$row=$count['id'];
if (isset($_POST['delete'])){
    $store_id=$_POST['id'];
    $result10=mysqli_query($con,"Delete from tblexpense2 where expense_id='$store_id'");
    $result9=mysqli_query($con,"Delete from tblexpense1 where expense_id='$store_id'");
    if ($result9){
        echo "<script>alert('Data Deleted Successfully'); window.location.href='expense.php';</script>";
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
    <title>Expense</title>
    <link rel="stylesheet" href="css/expense.css">
</head>
<body>
    <form action="expense.php" method="POST" autocomplete="off" class="form">
        <div class="sec1">
            <div class="sec11">
                <div class="col-2">
                    <div class="input-group">
                        <label class="label">Expense id</label>
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
                        <label class="label">Expense Date</label>
                        <input class="input" type="date" name="date" id="date" required>
                    </div>
                </div>
            </div>
            <div class="sec11">
                <div class="col-2">
                    <div class="input-group">
                        <label class="label">Expense Type</label>
                        <Select name="type" id="type" class="input" onchange="getCategory(localStorage.getItem('store'),this.value)">
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
                        <label class="label">Expense Category</label>
                        <Select name="category" id="category" class="input"></Select>
                    </div>
                </div>
            </div>
            <div class="table3">
                <div class="table4" id="table3">
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
                </div>
            </div>
            <div class="last">
                <div class="input-group1">
                    <label class="label">Total Amount</label>
                    <input class="input" type="text" name="amount" id="amount" readonly>
                </div>
                <div class="buttons">
                    <input type="button" name="save" id="save" class="button" value="Save" style="background-color: #138913;border: 1px solid #138913;" onclick="insertExpense()">
                    <input type="button" name="update" id="update" class="button" value="Update" style="background-color: orange;border: 1px solid orange;" onclick="updateExpense()">
                    <input type="submit" name="delete" id="delete" class="button" value="Delete" style="background-color: #e50a0a;border: 1px solid #e50a0a;">
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
                            <th style="width: 55%">Category</th>
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
        let today = new Date().toISOString().slice(0, 10)
        document.getElementById("date").value = today;
        document.getElementById('store').value = localStorage.getItem('store');
        emptyRow();
        getCategory(localStorage.getItem('store'),document.getElementById('type').value);
        getTable(localStorage.getItem('store'));

        function getCategory(store,type) {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    document.getElementById('category').innerHTML = myObj2;
                }
            };
            xhttp.open("GET", "apis/expense_categoryselect.php?store=" + store+"&type="+type+"", true);
            xhttp.send();
        }

        function emptyRow(){
            let table = document.getElementById("table4").getElementsByTagName('tbody')[0];
            let count = (table.rows.length);
            let row = table.insertRow(count);
            let cell1 = row.insertCell(0);
            let cell2 = row.insertCell(1);
            cell2.addEventListener("keypress", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    totalAmount();
                    let count1 = (table.rows.length)-1;
                        if (!((table.rows[count1].cells[0].innerHTML.trim()==="") || (table.rows[count1].cells[1].innerHTML.trim()===""))) {
                            emptyRow();
                            table.rows[count+1].cells[0].focus();
                        }
                    }
                });
            cell1.contentEditable= true;
            cell2.contentEditable= true;
        }

        function totalAmount(){
            let table = document.getElementById("table4").getElementsByTagName('tbody')[0];
            let count = (table.rows.length);
            let amount = 0;
            for(let i=0;i<count;i++){
                let amount1 = table.rows[i].cells[1].innerHTML;
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
            xmlhttp.open("GET","apis/expense_table.php?sec2increment1="+ value +"",true);
            xmlhttp.send();
        }

        function insertExpense1(){
            return new Promise((response)=> {
                let date = document.getElementById('date').value;
                let store = document.getElementById('store').value;
                let type = document.getElementById('type').value;
                let category = document.getElementById('category').value;
                let amount = document.getElementById('amount').value;
                let xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange=function (){
                    if (this.readyState==4 && this.status==200){
                        let myObj1=this.responseText;
                        let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                        response(myObj2);

                    }
                };
                xmlhttp.open("GET","apis/insertexpense1.php?date="+ date +"&store="+store+"&type="+type+"&category="+category+"&amount="+amount+"",true);
                xmlhttp.send();
            });
        }

        function insertExpense2(){
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
                    xmlhttp.open("GET","apis/insertexpense2.php?id="+ id +"&narration="+table.rows[j].cells[0].innerHTML+"&amount="+table.rows[j].cells[1].innerHTML+"",true);
                    xmlhttp.send();
                }
                response("done");
            });
        }

        async function insertExpense(){
            let inertexpense1 = await insertExpense1();
            if (inertexpense1==="1") {
                let inertexpense2 = await insertExpense2();
                    alert("Expense Inserted Successfully");
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
                let type = document.getElementById('type').value;
                let category = document.getElementById('category').value;
                let amount = document.getElementById('amount').value;
                let xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange=function (){
                    if (this.readyState==4 && this.status==200){
                        let myObj1=this.responseText;
                        let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                        response(myObj2);

                    }
                };
                xmlhttp.open("GET","apis/updateexpense1.php?date="+ date +"&store="+store+"&type="+type+"&category="+category+"&amount="+amount+"&id="+id+"",true);
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
                xmlhttp.open("GET","apis/updateexpense2.php?id="+id+"",true);
                xmlhttp.send();
            });
        }

        async function updateExpense(){
            let updateexpense1 = await updateExpense1();
            if (updateexpense1==="1") {
                let updateexpense2 = await updateExpense2();
                if (updateexpense2 === "1") {
                    await insertExpense2();
                    alert("Expense Updated Successfully");
                    location.reload();
                } else {
                    alert("Some Error Occurred");
                }
            }
            else{
                    alert("Some Error Occurred");
                }
        }

        function returnType(){
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
                xmlhttp.open("GET","apis/returnType.php?id="+id+"",true);
                xmlhttp.send();
            });
        }

        function returnCategorySelect(value) {
            return new Promise((response) => {
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let myObj1=this.responseText;
                        let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                        response(myObj2);
                    }
                };
                xhttp.open("GET", "apis/expense_categoryselect.php?store=" + localStorage.getItem('store')+"&type="+value+"", true);
                xhttp.send();
            });
        }

        async function returnCategory(value) {
            let type = await returnType();
            let category = await returnCategorySelect(type);
            document.getElementById('category').innerHTML = category;
            document.getElementById('category').value = value;
        }

        function returnAmount(value){
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let myObj1=this.responseText;
                    let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                    document.getElementById('amount').value = myObj2;
                }
            };
            xhttp.open("GET", "apis/returnamount.php?id="+ value+"", true);
            xhttp.send();
        }

        function returnTable1(value){
            return new Promise((response)=> {
                let xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange=function (){
                    if (this.readyState==4 && this.status==200){
                        let myObj1=this.responseText;
                        let myObj2 = myObj1.replace(/^\s*[\r\n]/gm, "");
                        response(myObj2);

                    }
                };
                xmlhttp.open("GET","apis/returntable1.php?id="+value+"",true);
                xmlhttp.send();
            });
        }

        async function returnTable(value){
            let table1 = await returnTable1(value);
            let table = document.getElementById('table3');
            table.innerHTML = table1;
            emptyRow();
        }
    </script>
</body>
</html>