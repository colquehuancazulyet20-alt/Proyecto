<?php

include("connection.php");
$con = connection();

if (!isset($_POST['ID'])) {
    echo "Error: No se recibió el ID.";
    exit();
}
$ID=$_POST["ID"];
$Nombre = $_POST['Nombre'];
$Apellido = $_POST['Apellido'];
$Usuario = $_POST['Usuario'];
$Contraseña = $_POST['Contraseña'];
$Rol = $_POST['Rol'];
$Curso = $_POST['Curso'];



$sql="UPDATE login SET Nombre='$Nombre', Apellido='$Apellido', Usuario='$Usuario', Contraseña='$Contraseña' , Rol='$Rol' , Curso='$Curso' WHERE ID='$ID'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: index.php");
}else{

}

?>