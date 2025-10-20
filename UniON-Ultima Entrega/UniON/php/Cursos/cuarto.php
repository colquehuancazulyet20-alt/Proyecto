<?php
session_start();
require_once("../../php/connection.php");
$conn = connection(); // o conectar(), según tu archivo
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>1er Grado</title>
  <link rel="stylesheet" href="../../CSS/cursos/primero.css">
  <link rel="icon" href="../../html/img/index/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  <nav class="navbar">
    <div class="navbar-container">
      <div class="logo">
        <img src="../../html/img/index/logo.png" alt="Logo" />
      </div>
      <div class="menu">
        <button class="hover" onclick="location.href='#Cursos'">Cursos</button>
        <button><a href="../../html/index.php" class="hover">Foro</a></button>
        <button class="hover" onclick="location.href='#Comunicación'">Comunicación</button>
      </div>
      <div class="perfil">
        <a href="login.html">
          <img src="../../html/img/index/perfil-logo.png" alt="Login" />
        </a>
      </div>
    </div>
  </nav>

  <div class="banner-primero">
    <img src="../../img2/Cursos/Segundo/curso2.png" alt="2do Grado" />
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
  <a href="Cursos/primero.php" class="grado">1er Grado</a>
  <a href="Cursos/segundo.php" class="grado">2do Grado</a>
  <a href="Cursos/tercero.php" class="grado">3ro Grado</a>
  <a href="Cursos/cuarto.php" class="grado">4to Grado</a>
  <a href="Cursos/quinto.php" class="grado">5to Grado</a>
  <a href="Cursos/sexto.php" class="grado">6to Grado</a>
  <a href="Cursos/septimo.php" class="grado">7mo Grado</a>
</div>
        </div>
      </section>
    </div>

    <div class="Comunicados">
      <div class="bloque2">
        <section id="Foro">

        <?php
$cursoID = 4; // este número identifica al curso 
?>

           
            <form action="../anuncios/crear_anuncio.php" method="POST" >
              <div class="tarjeta-anuncio">
                <div class="texto">
                  <textarea name="contenido" class="input-anuncio" placeholder="Anuncia algo a la clase..."
                    required></textarea>
                  <input type="hidden" name="usuarioID" value="<?php echo $_SESSION['UsuarioID'] ?? ''; ?>" />
                  <input type="hidden" name="cursoID" value="<?php echo $cursoID; ?>">
                </div>
                <button type="submit" class="btn-publicar">Publicar</button>
              </div>
            </form>

            
            
            <!-- ANUNCIOS Y COMENTARIOS -->
            <?php
include("../../php/mostrar_contenido.php");

          ?>
      </div>
    </div>
</div>

    <!--  COMUNICACIÓN Y FOOTER -->
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
          <img src="../../html/Img/footer/Logo-footer.png" alt="Logo" class="logo">
        </div>

        <p>© 2025 - Todos los derechos reservados</p>
        </footer>
    </section>

   
</body>

</html>