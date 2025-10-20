<?php
session_start();
require_once("../../php/connection.php");
$conn = connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $contenido = $_POST['contenido'] ?? '';
  $usuarioID = $_POST['usuarioID'] ?? '';
$cursoID = isset($_POST['cursoID']) ? intval($_POST['cursoID']) : 0;
  $fecha = date('Y-m-d H:i:s');

  if ($contenido && $usuarioID) {
    $sql = "INSERT INTO anuncios (Contenido, Fecha, UsuarioID, cursoID) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $contenido, $fecha, $usuarioID, $cursoID) ;
    $stmt->execute();

    $id_anuncio = $conn->insert_id;
    $_SESSION['ultimo_anuncio_id'] = $id_anuncio;

if ($cursoID == 0) {
  header("Location: ../../Html/index.php?mensaje=anuncio_ok");
  exit;
} else {
  // Buscar el nombre del curso
  $sqlCurso = "SELECT nombre FROM cursos WHERE ID = ?";
  $stmtCurso = $conn->prepare($sqlCurso);
  $stmtCurso->bind_param("i", $cursoID);
  $stmtCurso->execute();
  $resultadoCurso = $stmtCurso->get_result();

  if ($filaCurso = $resultadoCurso->fetch_assoc()) {
    $nombreCurso = $filaCurso['nombre'];
    header("Location: ../Cursos/" . $nombreCurso . ".php?mensaje=anuncio_ok");
    exit;
  } else {
    header("Location: ../Html/index.php");

  }
}
  }
}
?>

