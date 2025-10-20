<?php
include("connection.php");
$con = connection();

$Nombre = $_POST['Nombre'];
$Apellido = $_POST['Apellido'];
$Usuario = $_POST['Usuario'];
$Contraseña = $_POST['Contraseña'];
$Rol = $_POST['Rol'];
$Curso = $_POST['Curso'];

$sql = "INSERT INTO login (Nombre, Apellido, Usuario, Contraseña, Rol, Curso) VALUES ('$Nombre', '$Apellido', '$Usuario', '$Contraseña', '$Rol', '$Curso')";
$query = mysqli_query($con, $sql);

// Obtener el ID recién creado
$id_login = mysqli_insert_id($con);

// Insertar en usuarios
$sql_usuarios = "INSERT INTO usuarios (ID, Nombre, Apellido, Rol, Curso) 
                 VALUES ('$id_login', '$Nombre', '$Apellido', '$Rol', '$Curso')";
$query_usuarios = mysqli_query($con, $sql_usuarios);


if($query){
    Header("Location: index.php");
}else{

}
if (!$query) {
    echo "Error: " . mysqli_error($con);
}

?>