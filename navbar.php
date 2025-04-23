<?php
session_start(); 
$rol = $_SESSION['rol'] ?? null;
?>

<nav style="background: #0077cc; padding: 10px; color: white;">
    <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 20px;">
        <li><a href="/index.php" style="color: white; text-decoration: none;">Inicio</a></li>

        <?php if ($rol === 'candidato'): ?>
            <li><a href="/Candidato/dashboard.php" style="color: white; text-decoration: none;">Panel Candidato</a></li>
            <li><a href="/Candidato/ofertas_disponibles.php" style="color: white; text-decoration: none;">Ver Ofertas</a></li>
            <li><a href="/Candidato/perfil.php" style="color: white; text-decoration: none;">Perfil</a></li>
        <?php elseif ($rol === 'empresa'): ?>
            <li><a href="/Empresa/dashboard.php" style="color: white; text-decoration: none;">Panel Empresa</a></li>
            <li><a href="/Empresa/crear_oferta.php" style="color: white; text-decoration: none;">Publicar Oferta</a></li>
            <li><a href="/Empresa/ver_ofertas.php" style="color: white; text-decoration: none;">Ver Ofertas</a></li>
            <li><a href="/Empresa/ver_postulantes.php" style="color: white; text-decoration: none;">Candidatos</a></li>
        <?php endif; ?>

        <li><a href="/logout.php" style="color: white; text-decoration: none;">Cerrar Sesión</a></li>
    </ul>
</nav>
