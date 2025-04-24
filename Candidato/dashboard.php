<?php
include('../db.php');
include('../navbar.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario_id = $_SESSION['usuario_id'];
    
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $formacion = $_POST['formacion'];
    $experiencia = $_POST['experiencia'];
    $habilidades = $_POST['habilidades'];
    $idiomas = $_POST['idiomas'];
    $objetivo = $_POST['objetivo'];
    $logros = $_POST['logros'];
    $disponibilidad = $_POST['disponibilidad'];
    $redes = $_POST['redes'];
    $referencias = $_POST['referencias'];

    // Subida de archivos
    $cv_pdf = '';
    $foto = '';

    if (isset($_FILES['cv_pdf']) && $_FILES['cv_pdf']['error'] === 0) {
        $cv_nombre = time() . "_" . basename($_FILES['cv_pdf']['name']);
        $cv_ruta = "../Uploads/cvs/" . $cv_nombre;
        move_uploaded_file($_FILES['cv_pdf']['tmp_name'], $cv_ruta);
        $cv_pdf = $cv_nombre;
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto_nombre = time() . "_" . basename($_FILES['foto']['name']);
        $foto_ruta = "../Uploads/fotos/" . $foto_nombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_ruta);
        $foto = $foto_nombre;
    }

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO candidatos 
    (nombre, apellido, correo, telefono, direccion, ciudad, formacion, experiencia, habilidades, idiomas, objetivo, 
    logros, disponibilidad, redes, referencias, cv_pdf, foto) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssssssss", 
        $nombres, $apellidos, $correo, $telefono, $direccion, $ciudad, 
        $formacion, $experiencia, $habilidades, $idiomas, $objetivo, 
        $logros, $disponibilidad, $redes, $referencias, $cv_pdf, $foto);


    if ($stmt->execute()) {
        header("Location: ../Candidato/dashboard.php?mensaje=curriculum_guardado");
        exit();
    } else {
        echo "❌ Error al guardar el currículum.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            h1 {
                font-size: 24px;
            }
            p {
                font-size: 16px;
            }
        }
        @media (min-width: 601px) and (max-width: 900px) {
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 28px;
            }
            p {
                font-size: 18px;
            }
        }
        @media (min-width: 901px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 32px;
            }
            p {
                font-size: 20px;
            }
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container form input, .container form textarea, .container form select {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container form button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container form button:hover {
            background-color: #218838;
        }
        .container form label {
            margin-top: 10px;
            font-weight: bold;
        }
        .container form input[type="file"] {
            padding: 5px;
        }
        .container form textarea {
            resize: vertical;
        }
        .container form textarea[placeholder] {
            height: 100px;
        }
        .container form input[type="text"],
        .container form input[type="email"],
        .container form input[type="tel"],
        .container form input[type="url"] {
            width: 100%;
        }
        .container form input[type="text"]:focus,
        .container form input[type="email"]:focus,
        .container form input[type="tel"]:focus,
        .container form input[type="url"]:focus {
            border-color: #007BFF;
            outline: none;
        }
        .container form select:focus {
            border-color: #007BFF;
            outline: none;
        }
        .container form textarea:focus {
            border-color: #007BFF;
            outline: none;
        }
        .container form button:focus {
            outline: none;
        }
        .container form button:active {
            background-color: #1e7e34;
        }
        .container form input[type="file"] {
            border: none;
            padding: 0;
        }
        .container form input[type="file"]::file-selector-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .container form input[type="file"]::file-selector-button:hover {
            background-color: #0056b3;
        }
        .container form input[type="file"]::file-selector-button:focus {
            outline: none;
        }
        .container form input[type="file"]::file-selector-button:active {
            background-color: #0056b3;
        }
        .container form input[type="file"]::file-selector-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .container form input[type="file"]::file-selector-button:disabled:hover {
            background-color: #ccc;
        }
        .container form input[type="file"]::file-selector-button:disabled:active {
            background-color: #ccc;
        }
        .container form input[type="file"]::file-selector-button:disabled:focus {
            outline: none;
        }
        .container form input[type="file"]::file-selector-button:disabled:hover {
            background-color: #ccc;
        }
        .container form input[type="file"]::file-selector-button:disabled:active {
            background-color: #ccc;
        }
        .container form input[type="file"]::file-selector-button:disabled:focus {
            outline: none;
        }
        .container form input[type="file"]::file-selector-button:disabled:hover {
            background-color: #ccc;
        }
        .container form input[type="file"]::file-selector-button:disabled:active {
            background-color: #ccc;
        }
    </style>

</head>
<body>
    <div class="container">
        <h2>Completa tu Currículum</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="text" name="nombres" placeholder="Nombre(s)" required><br>
                <input type="text" name="apellidos" placeholder="Apellido(s)" required><br>
                <input type="email" name="correo" placeholder="Correo Electrónico" required><br>
                <input type="tel" name="telefono" placeholder="Teléfono" required><br>
                <input type="text" name="direccion" placeholder="Dirección" required><br>
                <input type="text" name="ciudad" placeholder="Ciudad / Provincia" required><br>
                <textarea name="formacion" placeholder="Formación Académica" required></textarea><br>
                <textarea name="experiencia" placeholder="Experiencia Laboral" required></textarea><br>
                <textarea name="habilidades" placeholder="Habilidades Clave" required></textarea><br>
                <input type="text" name="idiomas" placeholder="Idiomas" required><br>
                <textarea name="objetivo" placeholder="Objetivo Profesional / Resumen" required></textarea><br>
                <textarea name="logros" placeholder="Logros o Proyectos Destacados"></textarea><br>
                <select name="disponibilidad" required>
                    <option value="">Disponibilidad</option>
                    <option value="inmediata">Inmediata</option>
                    <option value="15_dias">En 15 días</option>
                    <option value="1_mes">En 1 mes</option>
                </select><br>
                <input type="url" name="redes" placeholder="Perfil de LinkedIn (opcional)"><br>
                <textarea name="referencias" placeholder="Referencias (opcional)"></textarea><br>

                <label>Subir CV en PDF</label>
                <input type="file" name="cv_pdf" accept="application/pdf"><br>

                <label>Subir Foto de Perfil</label>
                <input type="file" name="foto" accept="image/*"><br>

                <button type="submit">Guardar Currículum</button>
            </form>
        </div>
    </body>
</html>