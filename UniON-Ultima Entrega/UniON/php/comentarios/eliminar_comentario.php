<?php
session_start();
require_once(__DIR__ . "/../connection.php");
$conn = connection();

$id = $_GET['id'] ?? null;
$usuario_id = $_SESSION['UsuarioID'] ?? null;

if (!$id || !$usuario_id) {
  echo "Acceso inválido.";
  exit;
}

// Verificar autoría y obtener id_anuncio
$stmt = $conn->prepare("SELECT usuario_id, id_anuncio FROM comentarios WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$comentario = $result->fetch_assoc();

if (!$comentario || $comentario['usuario_id'] != $usuario_id) {
  echo "No tenés permiso para eliminar este comentario.";
  exit;
}

// Eliminar comentario
$delete = $conn->prepare("DELETE FROM comentarios WHERE ID = ?");
$delete->bind_param("i", $id);
$delete->execute();

// Obtener curso desde el anuncio relacionado
$stmtCurso = $conn->prepare("SELECT c.nombre 
                             FROM cursos c 
                             JOIN anuncios a ON a.cursoID = c.ID 
                             WHERE a.ID = ?");
$stmtCurso->bind_param("i", $comentario['id_anuncio']);
$stmtCurso->execute();
$resultCurso = $stmtCurso->get_result();
$filaCurso = $resultCurso->fetch_assoc();

if ($filaCurso) {
  $nombreCurso = $filaCurso['nombre'];
  header("Location: ../Cursos/" . $nombreCurso . ".php?mensaje=comentario_eliminado");
} else {
  header("Location: ../../Html/index.php?mensaje=comentario_eliminado");
}
exit;
?>
