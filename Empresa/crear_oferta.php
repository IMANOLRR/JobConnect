<?php
include('../db.php');
include('../navbar.php');


// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $requisitos = $_POST['requisitos'];
    $empresa_id = $_SESSION['empresa_id'];

    echo "Empresa ID: " . $_SESSION['empresa_id'];
    $stmt = $conn->prepare("INSERT INTO ofertas (titulo, descripcion, requisitos, empresa_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $descripcion, $requisitos, $empresa_id);


    if ($stmt->execute()) {
        header("Location: ../Empresa/ver_ofertas.php?mensaje=oferta_publicada");
        exit();
    } else {
        echo "❌ Error al publicar la oferta: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Oferta</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>
    <div class="container">
        <h2>📢 Publicar Nueva Oferta de Empleo</h2>
        <form method="POST" action="../Empresa/crear_oferta.php">
            <input type="text" name="titulo" placeholder="Título del puesto" required><br>
            <textarea name="descripcion" placeholder="Descripción del puesto" required></textarea><br>
            <textarea name="requisitos" placeholder="Requisitos del puesto" required></textarea><br>
            <button type="submit">Publicar Oferta</button>
        </form>
        <p><a href="dashboard.php">⬅ Volver al Panel</a></p>
    </div>
</body>
</html>
