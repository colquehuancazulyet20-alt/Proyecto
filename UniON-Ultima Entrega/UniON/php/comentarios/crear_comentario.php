<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("../../php/connection.php");
$conn = connection();

// Variables recibidas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$contenido = $_POST['contenido'] ?? '';
 $usuarioID = $_POST['usuarioID'] ?? '';
  $id_anuncio = $_POST['id_anuncio'] ?? '';
  $fecha = date('Y-m-d H:i:s');

// Validación básica
if (empty($contenido) || $usuarioID === null || !is_numeric($id_anuncio)) {
echo "<p>Error: datos incompletos o sesión inválida.</p>";
  exit;
}

  if ($contenido && $usuarioID && $id_anuncio) {
    $sql = "INSERT INTO comentarios (contenido, fecha, usuario_id, id_anuncio) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $contenido, $fecha, $usuarioID, $id_anuncio);
    $stmt->execute();
  }}

// Obtener el curso al que pertenece el anuncio
$consulta = $conn->prepare("SELECT cursoID FROM anuncios WHERE ID = ?");
$consulta->bind_param("i", $id_anuncio);
$consulta->execute();
$resultado = $consulta->get_result();
$cursoID = 0;

if ($fila = $resultado->fetch_assoc()) {
  $cursoID = $fila['cursoID'];
}
$consulta->close();

//  Redirigir al curso correspondiente
if ($cursoID == 0) {
  // Foro general
  header("../../Html/index.php");
} else {
  // Cursos específicos (1 = primero, 2 = segundo, etc.)
  $nombresCursos = [
    1 => "primero",
    2 => "segundo",
    3 => "tercero",
    4 => "cuarto",
    5 => "quinto",
    6 => "sexto",
    7 => "septimo"
  ];

  $nombreCurso = $nombresCursos[$cursoID] ?? "primero"; // por si algo falla
    header("Location: " . $_SERVER['HTTP_REFERER']);}
exit;
?>
