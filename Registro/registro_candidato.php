<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $tipo = 'candidato';

    // Validar si ya existe ese correo
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "❌ Este correo ya está registrado.";
    } else {
        $stmt->close();

        $insert = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena, tipo) VALUES (?, ?, ?, ?)");
        $insert->bind_param("ssss", $nombre, $correo, $clave, $tipo);

        if ($insert->execute()) {
            echo "✅ Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: ../login/login.php");
            exit();
        } else {
            echo "❌ Error al registrar el candidato.";
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
    <title>Registro de Candidato</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Registro de Candidato</h2>
        <form method="POST" action="../Registro/registro_candidato.php">
            <input type="text" name="nombre" placeholder="Nombre completo" required><br>
            <input type="email" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="../Login/login.php">Inicia sesión</a></p>
    </div>
</body>
</html>
