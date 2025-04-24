<?php
include '../navbar.php';
include '../db.php';


$rol = $_SESSION['rol'] ?? null;

if ($rol !== 'empresa') {
    header('Location: /index.php');
    exit();
}

// Obtener las estadísticas
$sql_ofertas = "SELECT COUNT(*) AS total_ofertas FROM ofertas WHERE empresa_id = ?";
$sql_postulantes = "SELECT COUNT(*) AS total_postulantes FROM candidatos WHERE id IN (SELECT id FROM ofertas WHERE empresa_id = ?)";

// Preparar y ejecutar consultas
$stmt_ofertas = $conn->prepare($sql_ofertas);
$stmt_postulantes = $conn->prepare($sql_postulantes);

$empresa_id = $_SESSION['empresa_id']; // Obtener ID de la empresa desde la sesión

$stmt_ofertas->bind_param("i", $empresa_id);
$stmt_postulantes->bind_param("i", $empresa_id);

$stmt_ofertas->execute();
$stmt_postulantes->execute();

$result_ofertas = $stmt_ofertas->get_result()->fetch_assoc();
$result_postulantes = $stmt_postulantes->get_result()->fetch_assoc();

$stmt_ofertas->close();
$stmt_postulantes->close();
// Cerrar conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>

<!-- Contenedor principal -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="/Empresa/dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="/Empresa/crear_oferta.php" class="list-group-item list-group-item-action">Crear Oferta</a>
                <a href="/Empresa/ver_ofertas.php" class="list-group-item list-group-item-action">Ver Ofertas Publicadas</a>
                <a href="/Empresa/ver_postulantes.php" class="list-group-item list-group-item-action">Ver Postulantes</a>
                <a href="/Empresa/estadisticas.php" class="list-group-item list-group-item-action">Estadísticas</a>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9">
            <h2 class="my-4">Bienvenido, [Nombre de la Empresa]</h2>

            <!-- Sección de estadísticas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ofertas Publicadas</h5>
                            <p class="card-text"><?= $result_ofertas['total_ofertas'] ?> ofertas activas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Candidatos Aplicados</h5>
                            <p class="card-text"><?= $result_postulantes['total_postulantes'] ?> postulantes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Candidatos Nuevos</h5>
                            <p class="card-text">3 nuevos postulantes hoy</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Visitas al Perfil</h5>
                            <p class="card-text"><?= $result_visitas['total_visitas'] ?> visitas esta semana</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de ofertas recientes -->
            <h3>Ofertas Recientes</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha de Publicación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener ofertas recientes desde la base de datos
                    include 'dbconnect.php';
                    $sql_ofertas_recientes = "SELECT * FROM ofertas WHERE empresa_id = ? ORDER BY fecha_publicacion DESC LIMIT 5";
                    $stmt = $conn->prepare($sql_ofertas_recientes);
                    $stmt->bind_param("i", $empresa_id);
                    $stmt->execute();
                    $result_ofertas_recientes = $stmt->get_result();
                    while ($oferta = $result_ofertas_recientes->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= $oferta['titulo'] ?></td>
                        <td><?= $oferta['fecha_publicacion'] ?></td>
                        <td><a href="/Empresa/ver_postulantes.php?oferta_id=<?= $oferta['id'] ?>" class="btn btn-primary btn-sm">Ver Postulantes</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
