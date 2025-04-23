<?php
include('../db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $clave = $_POST['contrasena'];

    // Buscar el usuario por correo y tipo = 'empresa'
    $stmt = $conn->prepare("SELECT id, contrasena FROM usuarios WHERE correo = ? AND tipo = 'empresa'");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hash_clave);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($clave, $hash_clave)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['rol'] = 'empresa';

            header("Location: ../Empresa/dashboard.php");
            exit();
        } else {
            echo "❌ Contraseña incorrecta.";
        }
    } else {
        echo "❌ El usuario no está registrado o no es una empresa.";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión como Empresa</h2>
        <form method="POST" action="../Login/login_empresa.php">
            <input type="email" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br>
            <button type="submit" <a href="../Empresa/dashboard.php">Ingresar</a></button>
        </form>
        <p>¿No tienes cuenta? <a href="../index.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
