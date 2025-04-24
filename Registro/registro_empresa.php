<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $tipo = 'empresa';

    // Validar si ya existe ese correo en la tabla empresas
    $stmt = $conn->prepare("SELECT id FROM empresas WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "❌ Este correo ya está registrado.";
    } else {
        $stmt->close();

        // Insertar los datos en la tabla empresas
        $insert = $conn->prepare("INSERT INTO empresas (nombre, correo, contrasena, direccion) VALUES (?, ?, ?, ?)");
        $insert->bind_param("ssss", $nombre, $correo, $clave, $direccion);

        if ($insert->execute()) {
            echo "✅ Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: ../login/login.php");
            exit();
        } else {
            echo "❌ Error al registrar la empresa.";
        }

        $insert->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white text-center">
                        <h4>🏢 Registro de Empresa</h4>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="../Registro/registro_empresa.php">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la empresa</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección de la empresa</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">✅ Registrar Empresa</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <p>¿Ya tienes cuenta? <a href="../Login/login.php">Inicia sesión</a></p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>