<?php

include("connection.php");
$con = connection();

$ID=$_GET["ID"];

$sql="DELETE FROM login WHERE ID='$ID'";
$query = mysqli_query($con, $sql);

$sql_check = "SELECT COUNT(*) as total FROM login";
$result = mysqli_query($con, $sql_check);
$data = mysqli_fetch_assoc($result);

if ($data['total'] == 0) {
    mysqli_query($con, "ALTER TABLE login AUTO_INCREMENT = 1");
}


if($query){
    Header("Location: index.php");
}else{

}

?>