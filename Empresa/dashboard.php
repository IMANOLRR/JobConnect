<?php
include('../db.php');
include('../navbar.php');

$rol = $_SESSION['rol'] ?? null;

if ($rol !== 'empresa') {
    header('Location: /index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <h2 class="my-4">Bienvenido</h2>

            <!-- Sección de estadísticas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ofertas Publicadas</h5>
                            <p class="card-text">5 ofertas activas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Candidatos Aplicados</h5>
                            <p class="card-text">12 postulantes</p>
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
                            <p class="card-text">250 visitas esta semana</p>
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
                    <tr>
                        <td>Desarrollador Web</td>
                        <td>10/04/2025</td>
                        <td><a href="/Empresa/ver_postulantes.php?oferta_id=1" class="btn btn-primary btn-sm">Ver Postulantes</a></td>
                    </tr>
                    <tr>
                        <td>Analista de Datos</td>
                        <td>05/04/2025</td>
                        <td><a href="/Empresa/ver_postulantes.php?oferta_id=2" class="btn btn-primary btn-sm">Ver Postulantes</a></td>
                    </tr>
                    <tr>
                        <td>Community Manager</td>
                        <td>01/04/2025</td>
                        <td><a href="/Empresa/ver_postulantes.php?oferta_id=3" class="btn btn-primary btn-sm">Ver Postulantes</a></td>
                    </tr>
                </tbody>
            </table>

            <!-- Mensajes de éxito o error con SweetAlert -->
            <script>
                const params = new URLSearchParams(window.location.search);

                if (params.get("mensaje") === "oferta_publicada") {
                    Swal.fire("✅ ¡Oferta publicada!", "Tu oferta ha sido publicada correctamente.", "success");
                }

                if (params.get("mensaje") === "postulante_aceptado") {
                    Swal.fire("✅ ¡Candidato aceptado!", "Has aceptado al candidato correctamente.", "success");
                }
            </script>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
