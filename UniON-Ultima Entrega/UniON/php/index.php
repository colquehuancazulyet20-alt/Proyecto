<?php
include("connection.php");
$con = connection();

$sql = "SELECT * FROM login";
$query = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style1.css" rel="stylesheet">
    <title>Users CRUD</title>
</head>

<body>
    <div class="fixed-top">
        <a href="../Html/index.html" class="close-button" title="Volver a la página principal">×</a>
    </div>
    <div class="login-form">
        <h1>Crear usuario</h1>
        <form action="insert_login.php" method="POST">
            <input type="text" name="Nombre" placeholder="Nombre">
            <input type="text" name="Apellido" placeholder="Apellido">
            <input type="email" name="Usuario" placeholder="Usuario">
            <input type="password" name="Contraseña" placeholder="Contraseña">
            <input type="text" name="Rol" placeholder="Rol (admin o tutor)">
            <input type="text" name="Curso" placeholder="Curso asignado (ej: curso1)">
            <input type="submit" value="Agregar">
        </form>
    </div>
    <div class="login-table">
        <h2>Usuarios registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Curso</th>

                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr class="lista">
                        <td><?= $row['ID'] ?></td>
                        <td><?= $row['Nombre'] ?></td>
                        <td><?= $row['Apellido'] ?></td>
                        <td><?= $row['Usuario'] ?></td>
                        <td><?= $row['Contraseña'] ?></td>
                        <td><?= $row['Rol'] ?></td>
                        <td><?= $row['Curso'] ?></td>


                        <td class="acciones">
                        <td> <a href="update.php?ID=<?= $row['ID'] ?>" class="login-table--edit">Editar</a></td>
                        <td> <a href="delete.php?ID=<?= $row['ID'] ?>" class="login-table--delete">Eliminar</a></td>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>