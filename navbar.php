<?php
session_start(); 
$rol = $_SESSION['rol'] ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0077cc;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">Job Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Inicio</a>
                </li>

                <?php if ($rol === 'candidato'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Candidato/dashboard.php">Panel Candidato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Candidato/ofertas_disponibles.php">Ver Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Candidato/perfil.php">Perfil</a>
                    </li>
                <?php elseif ($rol === 'empresa'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Empresa/dashboard.php">Panel Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Empresa/crear_oferta.php">Publicar Oferta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Empresa/ver_ofertas.php">Ver Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Empresa/ver_postulantes.php">Candidatos</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Enlazamos Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
