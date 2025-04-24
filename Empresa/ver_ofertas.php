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
</head>
<body>
    <div class="container">
        <h2>📄 Ofertas Publicadas</h2>
        <a href="../Empresa/crear_oferta.php">➕ Crear nueva oferta</a>
        <table border="1">
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
