<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>1er Grado</title>
  <link rel="stylesheet" href="../CSS/cursos/primero.css">
</head>

<body>


  <?php
  require_once(__DIR__ . "/connection.php");
  $conn = connection();

  $usuarioActualID = $_SESSION['UsuarioID'] ?? null;
  $editAnuncioID = $_GET['editar_anuncio'] ?? null;
  $editComentarioID = $_GET['editar_comentario'] ?? null;

  if (!isset($cursoID)) {
    $cursoID = 0;
  }

  $sql = "SELECT a.*, u.Nombre, u.Rol
        FROM anuncios a
        JOIN login u ON a.UsuarioID = u.ID
        WHERE a.cursoID = ?
        ORDER BY a.Fecha DESC";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $cursoID);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($anuncio = $result->fetch_assoc()) {
    echo "<div class='tarjeta-anuncio'>";

    // 🔹 Cabecera del anuncio
    echo "<div class='anuncio-header'>";
    echo "<span class='nombre-usuario'>" . htmlspecialchars($anuncio['Nombre']) . "</span> ";
    echo "<span class='rol-usuario'>(" . htmlspecialchars($anuncio['Rol']) . ")</span>";
    echo "<span class='fecha-anuncio'>" . date('d/m/Y H:i', strtotime($anuncio['Fecha'])) . "</span>";
    echo "</div>";

    // 🔹 Contenido o formulario de edición
    if ($editAnuncioID && $editAnuncioID == $anuncio['ID']) {
      echo "<form action='../anuncios/editar_anuncio.php' method='POST'>";
      echo "<input type='hidden' name='id' value='" . $anuncio['ID'] . "'>";
      echo "<textarea name='contenido' class='input-anuncio' required>" . htmlspecialchars($anuncio['Contenido']) . "</textarea>";
     echo " <div class='boton'>";
      echo "<button type='submit' class='guardar'>Guardar </button>";
      echo "<button type='button' class='cancelar' onclick='window.location.href=\"" . basename($_SERVER['PHP_SELF']) . "\"'>Cancelar</button>";
      echo "</div>";
      echo "</form>";
    } else {
      echo "<p id='mensaje_" . $anuncio['ID'] . "' class='contenido-anuncio'>" . nl2br(htmlspecialchars($anuncio['Contenido'])) . "</p>";

    }

    // 🔹 Botones de acción del anuncio
    if ($usuarioActualID && $usuarioActualID == $anuncio['UsuarioID']) {
      echo "<div class='acciones-anuncio'>";
      echo "<a href='?editar_anuncio=" . $anuncio['ID'] . "' class='editar' data-id='" . $anuncio['ID'] . "'>Editar</a>";

      echo "<a href='../anuncios/eliminar_anuncio.php?id=" . $anuncio['ID'] . "' class='eliminar'>Eliminar</a>";
      echo "</div>";
    }

    // 🔹 Comentarios
    $sqlComentarios = "SELECT c.*, u.Nombre AS usuario, u.Rol
                     FROM comentarios c
                     JOIN login u ON c.usuario_id = u.ID
                     WHERE c.id_anuncio = ?
                     ORDER BY c.fecha ASC";

    $stmtComentarios = $conn->prepare($sqlComentarios);
    $stmtComentarios->bind_param("i", $anuncio['ID']);
    $stmtComentarios->execute();
    $resultComentarios = $stmtComentarios->get_result();

    echo "<div class='comentarios'>";
    while ($comentario = $resultComentarios->fetch_assoc()) {
      echo "<div class='comentario'>";

      // 🔹 Cabecera del comentario
      echo "<div class='comentario-header'>";
      echo "<span class='nombre-usuario'>" . htmlspecialchars($comentario['usuario']) . "</span> ";
      echo "<span class='rol-usuario'>(" . htmlspecialchars($comentario['Rol']) . ")</span>";
      echo "<span class='fecha-comentario'>" . date('d/m/Y H:i', strtotime($comentario['fecha'])) . "</span>";
      echo "</div>";
           // echo"<div class='bloque-comentarios'>";
      // 🔹 Contenido o formulario de edición
      if ($editComentarioID && $editComentarioID == $comentario['ID']) {
        echo "<form action='../comentarios/editar_comentario.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $comentario['ID'] . "'>";
        echo "<textarea name='contenido' class='input-comentario' required>" . htmlspecialchars($comentario['contenido']) . "</textarea>";
        echo "<button type='submit' class='guardar'>Guardar </button>";
        echo "<button type='button' class='cancelar' onclick='window.location.href=\"" . basename($_SERVER['PHP_SELF']) . "\"'>Cancelar</button>";
        echo "</form>";
      // echo " </div>";
      } else {
        echo "<p class='comentario-contenido'>" . nl2br(htmlspecialchars($comentario['contenido'])) . "</p>";
      }

      // 🔹 Botones de acción del comentario
      if ($usuarioActualID && $usuarioActualID == $comentario['usuario_id']) {
        echo "<div class='acciones-comentario'>";
        echo "<a href='?editar_comentario=" . $comentario['ID'] . "' class='editar' data-id='" . $comentario['ID'] . "'>Editar</a>";
        echo "<a href='../comentarios/eliminar_comentario.php?id=" . $comentario['ID'] . "' class='eliminar'>Eliminar</a>";
        echo "</div>";
      }

      echo "</div>"; // cierre de comentario
    }
    echo "</div>"; // cierre de bloque comentarios
  
    // 🔹 Formulario para agregar comentario
    $origen = basename(dirname($_SERVER['SCRIPT_NAME']));
    $rutaComentario = ($origen === "Html") ? "../php/comentarios/crear_comentario.php" : "../../php/comentarios/crear_comentario.php";

    echo "<form action='$rutaComentario' method='POST' class='form-comentario'>";
    echo "<input type='hidden' name='id_anuncio' value='" . $anuncio['ID'] . "'>";
    echo "<input type='hidden' name='usuarioID' value='" . $usuarioActualID . "'>";
    echo "<textarea name='contenido' placeholder='Escribí tu comentario...' required></textarea>";
    echo "<button type='submit' class='boton-azul'>Comentar</button>";
    echo "</form>";

    echo "</div>"; // cierre de tarjeta-anuncio
  }
  ?>
  <script>
    document.querySelectorAll('.grado').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.grado').forEach(b => b.classList.remove('activo'));
    btn.classList.add('activo');
  });
});

  </script>
  <script>
    document.querySelectorAll('.editar').forEach(boton => {
      boton.addEventListener('click', () => {
        const id = boton.dataset.id;
        const mensaje = document.getElementById('mensaje_' + id);
        const textoOriginal = mensaje.innerText.trim();

        // Activar edición directa
        mensaje.setAttribute('contenteditable', 'true');
        mensaje.focus();

        // Insertar botones justo después del mensaje
        const contenedorBotones = document.createElement('div');
        contenedorBotones.id = 'botones_' + id;
        contenedorBotones.style.marginTop = '5px';
        contenedorBotones.innerHTML = `
        
        <button id="guardar_${id}" class="guardar"> Guardar</button>
        <button id="cancelar_${id}" class="cancelar"> Cancelar</button>
     
        `;
        mensaje.parentNode.insertBefore(contenedorBotones, mensaje.nextSibling);

        // Evento guardar
        document.getElementById('guardar_' + id).addEventListener('click', () => {
          const nuevoTexto = mensaje.innerText.trim();

          fetch('../anuncios/editar_anuncio.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&contenido=${encodeURIComponent(nuevoTexto)}`
          })
            .then(res => res.text())
            .then(data => {
              console.log("Respuesta del servidor:", data);
              const botones = document.getElementById('botones_' + id);

              if (data === "ok") {
                mensaje.innerText = nuevoTexto;
              } else {
                alert("Ocurrió un error al guardar.");
                mensaje.innerText = textoOriginal;
              }

              mensaje.removeAttribute('contenteditable');
              if (botones) botones.remove();
            });
        });

        // Evento cancelar
        document.getElementById('cancelar_' + id).addEventListener('click', () => {
          mensaje.innerText = textoOriginal;
          mensaje.removeAttribute('contenteditable');
          const botones = document.getElementById('botones_' + id);
          if (botones) botones.remove();
        });
      });
    });
  </script>

  <script>
    document.querySelectorAll('.editar-comentario').forEach(boton => {
      boton.addEventListener('click', () => {
        const id = boton.dataset.id;
        const comentario = document.getElementById('comentario_' + id);
        const textoOriginal = comentario.innerText.trim();

        comentario.setAttribute('contenteditable', 'true');
        comentario.focus();

        const contenedorBotones = document.createElement('div');
        contenedorBotones.id = 'botones_comentario_' + id;
        contenedorBotones.style.marginTop = '5px';
        contenedorBotones.innerHTML = `
        <button id="guardar_${id}" class="guardar"> Guardar</button>
        <button id="cancelar_${id}" class="cancelar"> Cancelar</button>
      `;
        comentario.parentNode.insertBefore(contenedorBotones, comentario.nextSibling);

        document.getElementById('guardar_comentario_' + id).addEventListener('click', () => {
          const nuevoTexto = comentario.innerText.trim();

          fetch('../../php/comentarios/editar_comentario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&contenido=${encodeURIComponent(nuevoTexto)}`
          })
            .then(res => res.text())
            .then(data => {
              const botones = document.getElementById('botones_comentario_' + id);

              if (data === "ok") {
                comentario.innerText = nuevoTexto;
              } else {
                alert("Ocurrió un error al guardar.");
                comentario.innerText = textoOriginal;
              }

              comentario.removeAttribute('contenteditable');
              if (botones) botones.remove();
            });
        });

        document.getElementById('cancelar_comentario_' + id).addEventListener('click', () => {
          comentario.innerText = textoOriginal;
          comentario.removeAttribute('contenteditable');
          const botones = document.getElementById('botones_comentario_' + id);
          if (botones) botones.remove();
        });
      });
    });
  </script>


</body>

</html>