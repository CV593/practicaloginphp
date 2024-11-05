<?php 
    include('cone.php'); 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['Username'];
        $password = $_POST['Pass'];
        if (!empty($username) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conexion->prepare("INSERT INTO usuario (Username, Pass) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);
            if ($stmt->execute()) {
                echo "Usuario creado exitosamente. Será redirigido al login en 5 segundos.";
                header("refresh:5;url=login.php");
                exit();
            } else {
                die("Query failed: " . $stmt->error);
            }
            $stmt->close();
        } else {
            echo "Por favor, complete todos los campos";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style/styles.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Crear Usuario</h1>
                </div>
                <div class="card-body">
                    <form action="crear.php" method="POST">
                        <div class="mb-3">
                            <label for="Username" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="Username" name="Username" placeholder="Usuario">
                        </div>
                        <div class="mb-3">
                            <label for="Pass" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="Pass" name="Pass" placeholder="Contraseña">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="login.php" class="btn btn-link">Volver al Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>