<?php
session_start();
require_once("../../php/connection.php");
$conn = connection();

$id = $_GET['id'] ?? null;
$usuario_id = $_SESSION['UsuarioID'] ?? null;

if (!$id || !$usuario_id) {
  echo "Acceso inválido.";
  exit;
}

// Verificamos que el anuncio pertenezca al usuario
$stmt = $conn->prepare("SELECT UsuarioID, cursoID FROM anuncios WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$anuncio = $result->fetch_assoc();

if (!$anuncio || $anuncio['UsuarioID'] != $usuario_id) {
  echo "No tenés permiso para eliminar este anuncio.";
  exit;
}

// Eliminamos
$delete = $conn->prepare("DELETE FROM anuncios WHERE ID = ?");
$delete->bind_param("i", $id);
$delete->execute();

// Intentamos obtener el nombre del curso
$nombreCurso = null;
if (!empty($anuncio['cursoID'])) {
  $stmtCurso = $conn->prepare("SELECT nombre FROM cursos WHERE ID = ?");
  $stmtCurso->bind_param("i", $anuncio['cursoID']);
  $stmtCurso->execute();
  $resultCurso = $stmtCurso->get_result();
  $filaCurso = $resultCurso->fetch_assoc();
  $nombreCurso = $filaCurso['nombre'] ?? null;
}

// Redirigimos al curso si lo reconoce, o al foro si no
if ($nombreCurso) {
  header("Location: ../Cursos/" . $nombreCurso . ".php?mensaje=anuncio_eliminado");
} else {
  header("Location: ../../Html/index.php?mensaje=anuncio_eliminado");
}
exit;
?>
