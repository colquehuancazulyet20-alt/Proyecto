<?php
require_once("../../php/connection.php");
$conn = connection();

$sql = "SELECT  a.ID,  a.Contenido, a.Fecha, u.nombre, u.apellido, u.rol, a.UsuarioID,
        FROM anuncios WHERE cursoID=?
        JOIN usuarios u ON a.UsuarioID = u.ID 
        ORDER BY a.ID DESC";

$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='anuncio'>";

echo "<p>ID: " . $row['ID'] . "</p>"; // correcto

  echo "<div class='info'>";
  echo "<div class='encabesado'>";
echo "<h2> Comunicado</h2>";

echo "<p>Publicado por " . htmlspecialchars($row['nombre']) . " " . htmlspecialchars($row['apellido']) .
             " el " . date('d/m/Y H:i', strtotime($row['Fecha'])) . "</p>";
        echo "</div><hr>";
        echo "<div class='texto'><p>" . nl2br(htmlspecialchars($row['Contenido'])) . "</p></div>";

  // Guardar el ID del anuncio en sesión para usarlo en comentarios
$_SESSION['ultimo_anuncio_id'] = $row['ID'];

    if (isset($_SESSION['UsuarioID']) && $_SESSION['UsuarioID'] == $row['UsuarioID']) {
            echo "<div class='acciones'>";
            echo "<span class='toggle-opciones' onclick='mostrarOpciones(this)'>⚙️</span>";
            echo "<div class='opciones' style='display:none;'>";
            echo "<a href='../anuncios/editar_anuncio.php?id=" . $row['ID'] . "'> Editar</a>";
            echo "<a href='../anuncios/eliminar_anuncio.php?id=" . $row['ID'] . "' onclick='return confirm(\"¿Eliminar este anuncio?\")'>🗑️ Eliminar</a>";
            echo "</div>";
            echo "</div>";
        }

        echo "</div><br>";
    }
} else {
    echo "<p>No hay anuncios publicados aún.</p>";
}
?>