<?php
include '../navbar.php';
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil Candidato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2131;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>👤 Perfil Candidato</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../Candidato/perfil.php">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="experiencia" class="form-label">Experiencia laboral</label>
                                <textarea name="experiencia" id="experiencia" rows="4" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="educacion" class="form-label">Educación</label>
                                <textarea name="educacion" id="educacion" rows="4" class="form-control"></textarea>
                            </div>

                            <button type="submit" name='guardar' value='guardar' class='btn btn-primary'>Guardar Cambios</button>
                        </form>

                        <?php if (isset($_GET['mensaje'])): ?>
                        <p style='color: green;'>
                            <?php
                            switch ($_GET['mensaje']) {
                                case 'perfil_actualizado':
                                    echo "✅ Tu perfil ha sido actualizado correctamente.";
                                    break;
                                case 'error_actualizacion':
                                    echo "❌ Hubo un error al actualizar tu perfil. Por favor, intenta nuevamente.";
                                    break;
                                case 'error_conexion':
                                    echo "❌ Error de conexión a la base de datos. Por favor, intenta nuevamente más tarde.";
                                    break;
                                default:
                                    echo "❌ Ocurrió un error inesperado.";
                                    break;
                            }
                            ?>
                        </p>
                        <?php endif; ?>
                        
                        <div class="text-center mt-4">
                            <a href="../Login/login.php" class="btn btn-secondary">Cerrar Sesión</a>
                            <a href="../index.php" class="btn btn-danger">Volver al Inicio</a>