<?php
include('../db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $clave = $_POST['contrasena'];

    // Buscar el usuario por correo y tipo = 'candidato'
    $stmt = $conn->prepare("SELECT id, contrasena FROM usuarios WHERE correo = ? AND tipo = 'candidato'");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hash_clave);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($clave, $hash_clave)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['rol'] = 'candidato';

            header("Location: ../Candidato/dashboard.php?mensaje=login_exitoso");
            exit();
        } else {
            header("Location: login_candidato.php?mensaje=login_error");
            exit();
        }
    } else {
        header("Location: login_candidato.php?mensaje=login_error");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Candidato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white text-center">
                        <h4>🔐 Iniciar Sesión - Candidato</h4>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="../Login/login_candidato.php">
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" name="correo" id="correo" class="form-control" placeholder="ejemplo@correo.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Ingresar</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <p>¿No tienes cuenta? <a href="../index.php">Regístrate aquí</a></p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script de SweetAlert2 para mostrar mensajes -->
    <script>
        const params = new URLSearchParams(window.location.search);

        if (params.get("mensaje") === "registro_exitoso") {
            Swal.fire("✅ ¡Registro exitoso!", "Ya puedes iniciar sesión.", "success");
        }

        if (params.get("mensaje") === "correo_existente") {
            Swal.fire("❌ Error", "Ese correo ya está registrado.", "error");
        }

        if (params.get("mensaje") === "login_error") {
            Swal.fire("❌ Error", "Correo o contraseña incorrectos.", "error");
        }

        if (params.has("mensaje")) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>

</body>
</html>

