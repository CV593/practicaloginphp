<?php
include('validacion.php');
include('cone.php'); 

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $username = $_POST['Username'];
        $password = $_POST['Pass'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("UPDATE usuario SET Username = ?, Pass = ? WHERE Id = ?");
        if ($stmt) {
            $stmt->bind_param("ssi", $username, $hashed_password, $id);
            if ($stmt->execute()) {
                $message = 'Registro actualizado correctamente.';
            } else {
                $message = 'Error al actualizar el registro.';
            }
            $stmt->close();
        } else {
            $message = 'Error al preparar la consulta.';
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conexion->prepare("DELETE FROM usuario WHERE Id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $message = 'Registro eliminado correctamente.';
            } else {
                $message = 'Error al eliminar el registro.';
            }
            $stmt->close();
        } else {
            $message = 'Error al preparar la consulta.';
        }
    }
}

$query = "SELECT * FROM usuario";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Lista de Usuarios</h1><br>
    <div class="text-end">
        <form action="logout.php" method="POST">
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?php echo $message; ?></div>
    <?php endif; ?>
    <?php
    if(mysqli_num_rows($result) > 0){
        echo "<table class='table table-bordered'>
            <thead class='thead-dark'>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Pass</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>";
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$row['Id']."</td>
                <td>".$row['Username']."</td>
                <td>".$row['Pass']."</td>
                <td>
                    <form action='index.php' method='POST' style='display:inline-block;'>
                        <input type='hidden' name='id' value='".$row['Id']."'>
                        <input type='text' class='form-control mb-2' name='Username' value='".$row['Username']."'>
                        <input type='password' class='form-control mb-2' name='Pass' placeholder='Nueva Contraseña'>
                        <button type='submit' name='update' class='btn btn-warning btn-sm'>Editar</button>
                    </form>
                    <form action='index.php' method='POST' style='display:inline-block;'>
                        <input type='hidden' name='id' value='".$row['Id']."'>
                        <button type='submit' name='delete' class='btn btn-danger btn-sm'>Eliminar</button>
                    </form>
                </td>
            </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning text-center'>No hay usuarios registrados.</div>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>