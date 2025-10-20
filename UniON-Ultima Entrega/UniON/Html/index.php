<?php
session_start();
require_once("../php/connection.php");
$conn = connection(); // o conectar(), según tu archivo
if (!isset($_SESSION['UsuarioID'])) {
  echo "<p class='aviso'>Debés iniciar sesión para publicar en el foro.</p>";
  echo "<a href='html/login.html' class='boton-login'>Iniciar sesión</a>";
  return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>1er Grado</title>
  <link rel="stylesheet" href="index.css">
  <link rel="icon" href="img/index/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  <nav class="navbar">
    <div class="navbar-container">
      <div class="logo">
        <img src="img/index/logo.png" alt="Logo" />
      </div>
      <div class="menu">
        <button class="hover" onclick="location.href='#Cursos'">Cursos</button>
        <button class="hover" onclick="location.href='#Foro'">Foro</button>
        <button class="hover" onclick="location.href='#Comunicación'">Comunicación</button>
      </div>
      <div class="perfil">
        <a href="../php/index.html">
          <img src="img/index/perfil-logo.png" alt="Login" />
        </a>
      </div>
    </div>
  </nav>

  <div class="carousel-container">
    <div class="carousel-slide" id="carousel-slide">
      <img src="img/Carrusel/Escuela.jpg" alt="Imagen 1" />
      <img src="img/Carrusel/Escuela2.jpg" alt="Imagen 2" />
      <img src="img/Carrusel/Escuela3.jpg" alt="Imagen 3" />
    </div>
  </div>

  </div>
  <div class="institucional">
    Escuela Primaria N°23 D.E.20"
  </div>

  <div class="centro">
    <div class="bloque1">
      <section id="Cursos">
        <h2>Cursos</h2>
        <div class="grados">
          <div class="grados">

            <a href="../php/index.html" class="grado">1er Grado</a>
            <a href="../php/Cursos/segundo.php" class="grado">2do Grado</a>
            <a href="../php/Cursos/tercero.php" class="grado">3er Grado</a>
            <a href="../php/Cursos/cuarto.php" class="grado">4to Grado</a>
            <a href="../php/Cursos/quinto.php" class="grado">5to Grado</a>
            <a href="../php/Cursos/sexto.php" class="grado">6to Grado</a>
            <a href="../php/Cursos/septimo.php" class="grado">7mo Grado</a>

          </div>
          <?php
          if (session_status() === PHP_SESSION_NONE) {
            session_start();
          }
          require_once '../php/connection.php';

          $conn = connection();

          $usuarioID = $_SESSION['UsuarioID'] ?? null;

          if ($usuarioID) {
            $sql = "SELECT c.ID, c.nombre FROM cursos c
              JOIN login u ON u.Curso = c.ID
              WHERE u.ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $usuarioID);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
              echo "<a href='../php/Cursos/{$row['ID']}.php' class='grado'>{$row['nombre']}</a>";
            }
          } else {
            echo "<p>Iniciá sesión para ver tus cursos.</p>";
          }
          ?>
        </div>
      </section>
    </div>

    <div class="Comunicados">
      <div class="bloque2">
        <section id="Foro">



          <!-- 🔹 FORMULARIO DE ANUNCIO -->
          <form action="../php/anuncios/crear_anuncio.php" method="POST">
            <div class="tarjeta-anuncio">
              <div class="texto">
                <textarea name="contenido" class="input-anuncio" placeholder="Anuncia algo a la clase..."
                  required></textarea>
                <input type="hidden" name="usuarioID" value="<?php echo $_SESSION['UsuarioID'] ?? ''; ?>" />
                <input type="hidden" name="cursoID" value="0">
              </div>
              <button type="submit" class="btn-publicar">Publicar</button>
            </div>
          </form>

          <!-- 🔹 ANUNCIOS Y COMENTARIOS -->
          <div class="contenedor-anuncios">

            <?php
            $cursoID = 0; // Foro principal
            include("../php/mostrar_contenido.php");
            ?>


          </div>
      </div>
    </div>
  </div>

  <!-- 🔷 COMUNICACIÓN Y FOOTER -->
  <section id="Comunicación">
    <div class="contenido">
      <h2><i class="fas fa-map-marker-alt"></i> Dirreción</h2>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3281.803720729567!2d-58.501414523530364
      !3d-34.659659572934245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcc99a37e0595f%3A0x14f10
      de947a2fea2!2sEscuela%20primaria%20N%C2%B0%2023%20D.E.%2020!5e0!3m2!1ses-419!2sar!4v1755713948816!5m2!1ses-419!2sar"
        width="100%" height="450" style="border:0; margin: 0 auto;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <footer>
      <div class="contactos">
        <p class="titulo"> Contactos</p>
        <p><i class="fa-solid fa-phone"></i> 11999999</p>
        <p><i class="fa-solid fa-envelope"></i> consultas.ed23@gmail.com</p>
      </div>

      <div class="contactos">
        <p class="titulo">Síguenos</p>
        <p><i class="fa-brands fa-instagram"></i>Instagram </p>
      </div>

      <div class="contactos">
        <img src="Img/footer/Logo-footer.png" alt="Logo" class="logo">
      </div>

      <p>© 2025 - Todos los derechos reservados</p>
    </footer>

  </section>

  <script>
    const slide = document.getElementById('carousel-slide');
    let index = 0;
    setInterval(() => {
      index = (index + 1) % 3;
      slide.style.transform = `translateX(-${index * 100}%)`;
    }, 3000);
  </script>


  
</body>

</html>