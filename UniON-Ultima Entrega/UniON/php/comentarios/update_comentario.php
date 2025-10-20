<?php
require_once(__DIR__ . "/../connection.php");
$conn = connection();

$ID = $_POST['id'] ?? null;
$Contenido = $_POST['contenido'] ?? null;

if (!$ID || !$Contenido) {
  echo "Datos incompletos.";
  exit;
}

// Usar prepared statement para seguridad
$stmt = $conn->prepare("UPDATE comentarios SET Contenido = ? WHERE ID = ?");
$stmt->bind_param("si", $Contenido, $ID);
$stmt->execute();

    header("Location: ../Cursos/" . $nombreCurso . ".php?mensaje=anuncio_ok");
exit;