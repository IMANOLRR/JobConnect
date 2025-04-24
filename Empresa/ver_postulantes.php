<?php
include('../db.php');
include('../navbar.php');

$query = "SELECT c.id, c.nombre, c.apellido, c.direccion, c.telefono, c.correo 
          FROM candidatos c"; // La consulta ahora solo selecciona los postulantes

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Postulantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container mt-4">
  <h2 class="mb-4">📋 Postulantes Registrados</h2>

  <?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
      <?= $_GET['mensaje'] === 'aplicacion_exitosa' ? '✅ Has aplicado correctamente. Un reclutador revisará tu solicitud.' :
          ($_GET['mensaje'] === 'ya_aplicaste' ? '⚠️ Ya has aplicado a esta oferta anteriormente.' : '') ?>
    </div>
  <?php endif; ?>

  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Correo</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($fila = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= htmlspecialchars($fila['nombre']) ?></td>
          <td><?= htmlspecialchars($fila['apellido']) ?></td>
          <td><?= htmlspecialchars($fila['direccion']) ?></td>
          <td><?= htmlspecialchars($fila['telefono']) ?></td>
          <td><?= htmlspecialchars($fila['correo']) ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>
