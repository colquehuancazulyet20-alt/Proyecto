<?php
session_start();
include 'connection.php'; //  Esto importa tu función

$conn = connection(); //  Esto la ejecuta y te da la conexión


if (!isset($_POST['Usuario']) || !isset($_POST['Contraseña'])) {
    echo " Faltan datos del formulario.";
    exit();
}
$Usuario = trim($_POST['Usuario']);
$Contraseña = trim($_POST['Contraseña']);

$sql = "SELECT * FROM login WHERE Usuario = ? AND Contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $Usuario, $Contraseña);
$stmt->execute();
$result = $stmt->get_result();


echo "Usuario ingresado: $Usuario<br>";
echo "Contraseña ingresada: $Contraseña<br>";

if ($row = $result->fetch_assoc()) {
    $_SESSION['UsuarioID'] = $row['ID']; // desde tabla usuarios
    $_SESSION['Usuario'] = $row['Usuario'];
    $_SESSION['Rol'] = strtolower(trim($row['Rol']));
    $_SESSION['Curso'] = $row['Curso'];

if($_SESSION['Rol'] === 'admin') {
    header("Location:../php/index.php");
    exit();

}else{
header("Location: Cursos/" . $_SESSION['Curso'] . ".php");
}
    exit();
} else {
    echo "❌ Usuario o contraseña incorrectos.";
}

$conn->close();
?>