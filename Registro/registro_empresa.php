<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $tipo = 'empresa';

    // Validar si ya existe ese correo
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "❌ Este correo ya está registrado.";
    } else {
        $stmt->close();

        $insert = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena, tipo, direccion) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $nombre, $correo, $clave, $tipo, $direccion);

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
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Registro de Empresa</h2>
        <form method="POST" action="../Registro/registro_empresa.php">
            <input type="text" name="nombre" placeholder="Nombre completo" required><br>
            <input type="email" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br>
            <input type="text" name="direccion" placeholder="Dirección de la empresa" required><br>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="../Login/login.php">Inicia sesión</a></p>
    </div>
</body>
</html>
