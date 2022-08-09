<?php
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$result=mysqli_query($con,"Select * from tblstores");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WEB - POS</title>
    <link rel="stylesheet" href="css/superdashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="stores.php" target="_blank">Store Creation</a></li>
        <li><a href="admin_users.php" target="_blank">User Creation</a></li>
        <li><a href="#">Assign Task</a></li>
        <li><a href="index.html">Logout</a></li>
    </ul>
</nav>
<div>
    <div class="table1">
        <div class="table2">
            <table style="border-collapse: collapse;width: 100%">
                <thead>
                <tr style="background-color: black">
                    <th style="color: white; text-align: center; padding: 20px 10px; width: 15%">Store id</th>
                    <th style="color: white; text-align: center; padding: 20px 10px; width: 35%">Store Name</th>
                    <th style="color: white; text-align: center; padding: 20px 10px; width: 45%">Store Address</th>
                    <th style="color: white; text-align: center; padding: 20px 10px; width: 5%"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($res=mysqli_fetch_array($result)){
                    ?>
                    <tr style="background-color: white">
                        <td style="text-align: center; padding: 20px 10px"><?php echo $res['store_id']; ?></td>
                        <td class="store_name" style="text-align: center; padding: 20px 10px"><?php echo $res['store_name']; ?></td>
                        <td style="text-align: center; padding: 20px 10px"><?php echo $res['store_address']; ?></td>
                        <td style="text-align: center; padding: 20px 10px"><i class="fa fa-eye select"></i></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(".select").click(function() {
        let val = $(this).closest('tr').find('.store_name').text();
        localStorage.setItem('store', val);
        window.location.href='dashboard.php';
    });
</script>
</body>
</html>
