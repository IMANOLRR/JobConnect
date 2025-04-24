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
    <link rel="stylesheet" href="../css/estilos.css"> <!-- Archivo CSS personalizado -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        form input:focus, form textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
        p {
            margin-top: 20px;
            font-size: 14px;
        }
        p a {
            color: #007bff;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
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
