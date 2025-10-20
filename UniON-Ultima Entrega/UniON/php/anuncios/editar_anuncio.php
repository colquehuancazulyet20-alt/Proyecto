<?php
session_start();
require_once(__DIR__ . "/../connection.php");
$conn = connection();

$id = $_POST['id'] ?? null;
$contenido = trim($_POST['contenido'] ?? '');
$usuario_id = $_SESSION['UsuarioID'] ?? null;

if (!$id || !$usuario_id || empty($contenido)) {
  echo "error";
  exit;
}
$stmt = $conn->prepare("SELECT UsuarioID FROM anuncios WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$anuncio = $result->fetch_assoc();

if (!$anuncio || $anuncio['UsuarioID'] != $usuario_id) {
  echo "sin_permiso";
  exit;
}

// Actualizar el contenido
$update = $conn->prepare("UPDATE anuncios SET Contenido = ? WHERE ID = ?");
$update->bind_param("si", $contenido, $id);
$update->execute();

// Obtener el curso asociado al anuncio
$stmtCurso = $conn->prepare("SELECT a.cursoID, c.nombre FROM anuncios a JOIN cursos c ON a.cursoID = c.ID WHERE a.ID = ?");
$stmtCurso->bind_param("i", $id);
$stmtCurso->execute();
$resultadoCurso = $stmtCurso->get_result();
$filaCurso = $resultadoCurso->fetch_assoc();

if ($filaCurso) {
  $nombreCurso = $filaCurso['nombre'];
  header("Location: ../Cursos/" . $nombreCurso . ".php?mensaje=anuncio_ok");
  exit;
} else {
  header("Location: ../Html/index.php");
}

?>
