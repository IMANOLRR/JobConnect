<?php
include('../db.php');
include('../navbar.php');

if (!isset($_SESSION['empresa_id']) || $_SESSION['rol'] !== 'empresa') {
    header("Location: ../Login/login_empresa.php");
    exit();
}

$empresa_id = $_SESSION['empresa_id'];

$query = "
    SELECT id, titulo, descripcion, requisitos, fecha_publicacion 
    FROM ofertas 
    WHERE empresa_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ofertas Publicadas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        a {
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        table td a {
            color: #28a745;
            font-size: 16px;
        }
        table td a:hover {
            text-decoration: underline;
        }
        p {
            margin-top: 20px;
            font-size: 14px;
        }
        p a {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📄 Ofertas Publicadas</h2>
        <a href="../Empresa/crear_oferta.php" class="btn btn-primary">➕ Crear nueva oferta</a>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Requisitos</th>
                    <th>Fecha de Publicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['titulo']) ?></td>
                        <td><?= htmlspecialchars($fila['descripcion']) ?></td>
                        <td><?= htmlspecialchars($fila['requisitos']) ?></td>
                        <td><?= htmlspecialchars($fila['fecha_publicacion']) ?></td>
                        <td>
                            <a href="editar_oferta.php?id=<?= $fila['id'] ?>">✏️ Editar</a> |
                            <a href="eliminar_oferta.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta oferta?')">🗑️ Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <p><a href="dashboard.php">⬅ Volver al Panel</a></p>
    </div>
</body>
</html>
