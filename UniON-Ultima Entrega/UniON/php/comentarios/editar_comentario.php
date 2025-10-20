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

// Verificamos que el comentario pertenezca al usuario
$stmt = $conn->prepare("SELECT usuario_id, id_anuncio FROM comentarios WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$comentario = $result->fetch_assoc();

if (!$comentario || $comentario['usuario_id'] != $usuario_id) {
  echo "sin_permiso";
  exit;
}

// Actualizamos el contenido
$update = $conn->prepare("UPDATE comentarios SET contenido = ? WHERE ID = ?");
$update->bind_param("si", $contenido, $id);
$update->execute();

// Obtener el curso desde el anuncio relacionado
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
  header("Location: ../Cursos/" . $nombreCurso . ".php?mensaje=comentario_ok");
  exit;
} else {
  header("Location: ../Html/index.php");
  exit;
}
?>
