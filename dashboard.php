<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WEB - POS</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="#">System</a>
            <ul>
                <li><a href="users.php" target="_blank">User Creation</a></li>
                <li><a href="#">Assign Task</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </li>
        <li><a href="#">Inventory</a>
            <ul>
                <li><a href="inventory_category.php" target="_blank">Category</a></li>
                <li><a href="inventory_subcategory.php" target="_blank">Sub Category</a></li>
                <li><a href="packing.php" target="_blank">Packing</a></li>
                <li><a href="inventory.php" target="_blank">Inventory</a></li>
                <li><a href="inventoryprint.php" target="_blank">Product Report</a></li>
            </ul>
        </li>
        <li><a href="parties.php" target="_blank">Clients</a></li>
        <li><a href="#">Sales</a>
            <ul>
                <li><a href="sale_invoice.php" target="_blank">Invoice</a></li>
                <li><a href="sale_report.php" target="_blank">Report</a></li>
            </ul>
        </li>
        <li><a href="#">Purchase</a></li>
        <li><a href="#">Expense</a>
            <ul>
                <li><a href="expense_category.php" target="_blank">Category</a></li>
                <li><a href="expense.php" target="_blank">Voucher</a></li>
                <li><a href="expense_report.php" target="_blank">Report</a></li>
            </ul>
        </li>
    </ul>
    <div class="navbar">
        <p style="color: white;font-size: 16px">Logged in: </p>
        <p id="user" style="color: white;font-size: 16px;margin-left: 5px"></p>
        <p style="color: white;font-size: 16px; margin-left: 20px">Store: </p>
        <p id="storename" style="color: white;font-size: 16px;margin-left: 5px"></p>
    </div>
</nav>
<script>
    const username = localStorage.getItem("username");
    document.getElementById('user').innerText=username;
    storeName(username);

    function storeName(value){
        if (value=='superadmin'){
            document.getElementById('storename').innerHTML = localStorage.getItem('store');
        }else {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let myObj = this.responseText;
                    let myObj2 = myObj.replace(/^\s*[\r\n]/gm, "");
                    document.getElementById('storename').innerHTML = myObj2;
                    localStorage.setItem("store", myObj2);

                }
            };
            xmlhttp.open("GET", "apis/store_name.php?sec2increment1=" + value + "", true);
            xmlhttp.send();
        }
    }
</script>
</body>
</html>
