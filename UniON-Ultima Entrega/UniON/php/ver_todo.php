<?php
require_once("connection.php");
$conn = connection();

$sql = "SELECT a.ID, a.Contenido, a.Fecha, u.nombre, u.apellido, u.rol
        FROM anuncios a 
        JOIN usuarios u ON a.UsuarioID = u.ID 
        ORDER BY a.ID DESC";

$result = $conn->query($sql);

echo "<h1> Lista de anuncios</h1>";

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<hr>";
    echo "<p><strong>ID:</strong> " . $row['ID'] . "</p>";
    echo "<p><strong>Publicado por:</strong> " . $row['nombre'] . " " . $row['apellido'] . " (" . $row['rol'] . ")</p>";
    echo "<p><strong>Fecha:</strong> " . date('d/m/Y H:i', strtotime($row['Fecha'])) . "</p>";
    echo "<p><strong>Contenido:</strong> " . htmlspecialchars($row['Contenido']) . "</p>";
  }
} else {
  echo "<p>No hay anuncios publicados.</p>";
}
?>
