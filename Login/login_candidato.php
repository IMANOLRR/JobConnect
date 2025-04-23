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
    <link rel="stylesheet" href="../css/estilos.css">
    
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión como Candidato</h2>
        <form method="POST" action="../Login/login_candidato.php">
            <input type="email" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br>
            <button type="submit" <a href="../Candidato/dashboard.php">Ingresar</a></button>
        </form>
        <p>¿No tienes cuenta? <a href="../index.php">Regístrate aquí</a></p>
    </div>
    <!-- SweetAlert2 + Script para mensajes -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // Limpiar la URL para que no se repita el mensaje al recargar
        if (params.has("mensaje")) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
</body>
</html>
