<?php
if (!isset($id_anuncio)) return;

require_once("../connection.php");
$conn = connection();

$sql = "SELECT c.ID, u.nombre, u.apellido, c.contenido, c.fecha, c.usuario_id
        FROM comentarios c
        JOIN usuarios u ON c.usuario_id = u.ID
        WHERE c.ID_anuncio = ?
        ORDER BY c.fecha ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_anuncio);
$stmt->execute();
$comentarios = $stmt->get_result();

echo "<div class='comentarios'>";
if ($comentarios->num_rows > 0) {
    echo "<h4>Comentarios:</h4>";

while ($comentario = $comentarios->fetch_assoc()) {
  echo "<div class='comentario'>";
  echo "<p><strong>" . htmlspecialchars($comentario['nombre'] . ' ' . $comentario['apellido']) . "</strong> ";
  echo "<span>" . date('d/m/Y H:i', strtotime($comentario['fecha'])) . "</span></p>";
  echo "<p id='comentario_{$comentario['ID']}'>" . nl2br(htmlspecialchars($comentario['contenido'])) . "</p>";

  if (isset($_SESSION['UsuarioID']) && $_SESSION['UsuarioID'] == $comentario['usuario_id']) {
    echo "<button class='editar' data-id='{$comentario['ID']}'> Editar</button>";
    echo "<button class='eliminar' data-id='{$comentario['ID']}'> Eliminar</button>";
  }
  echo "</div>";
}
} else {
    echo "<p>No hay comentarios aún.</p>";
}
echo "</div>";
?>