<?php 
    include("connection.php");
    $con=connection();

    $ID=$_GET['ID'];

    $sql="SELECT * FROM login WHERE ID='$ID'";
    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style1.css" rel="stylesheet">
        <title>Editar usuarios</title>
        
    </head>
    <body>
        <div class="login-form">
            <form action="edit.php" method="POST">
                <input type="hidden" name="ID" value="<?= $row['ID']?>">
                <input type="text" name="Nombre" placeholder="Nombre" value="<?= $row['Nombre']?>">
                <input type="text" name="Apellido" placeholder="Apellido" value="<?= $row['Apellido']?>">
                <input type="text" name="Usuario" placeholder="Usuario" value="<?= $row['Usuario']?>">
                <input type="text" name="Contraseña" placeholder="Contraseña" value="<?= $row['Contraseña']?>">
                <input type="text" name="Rol" placeholder="Rol" value="<?= $row['Rol']?>">
                <input type="text" name="Curso" placeholder="Curso" value="<?= $row['Curso']?>">
                

                <input type="submit" value="Actualizar">
            </form>
        </div>
    </body>
</html>