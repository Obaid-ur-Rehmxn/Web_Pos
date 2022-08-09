
<?php
$username = $_GET['username'];
$password=$_GET['password'];
require_once('db.php');
$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$stmt=mysqli_query($con,"Select * from tblusers where username='$username'");
$pass=mysqli_fetch_assoc($stmt);
    if ($pass['password'] == $password) {
        $status=true;
    }
else{
    $status=false;
}
echo $status;
?>