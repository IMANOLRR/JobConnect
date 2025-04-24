<?php
include('../db.php');
include('../navbar.php');


$query = "SELECT o.id, o.titulo, o.descripcion, o.requisitos, o.fecha_publicacion, e.nombre AS empresa 
          FROM ofertas o 
          JOIN empresas e ON o.empresa_id = e.id";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ofertas Disponibles</title>
</head>
<body>
<?php if (isset($_GET['mensaje'])): ?>
    <p style="color: green;">
        <?php
            switch ($_GET['mensaje']) {
                case 'aplicacion_exitosa':
                    echo "✅ Has aplicado correctamente. Un reclutador revisará tu solicitud.";
                    break;
                case 'ya_aplicaste':
                    echo "⚠️ Ya has aplicado a esta oferta anteriormente.";
                    break;
            }
        ?>
    </p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ofertas Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h2 class="mb-4">📋 Ofertas Disponibles</h2>

  <?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
      <?= $_GET['mensaje'] === 'aplicacion_exitosa' ? '✅ Has aplicado correctamente. Un reclutador revisará tu solicitud.' :
          ($_GET['mensaje'] === 'ya_aplicaste' ? '⚠️ Ya has aplicado a esta oferta anteriormente.' : '') ?>
    </div>
  <?php endif; ?>

  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>Empresa</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Requisitos</th>
        <th>Fecha</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($fila = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= htmlspecialchars($fila['empresa']) ?></td>
          <td><?= htmlspecialchars($fila['titulo']) ?></td>
          <td><?= htmlspecialchars($fila['descripcion']) ?></td>
          <td><?= htmlspecialchars($fila['requisitos']) ?></td>
          <td><?= htmlspecialchars($fila['fecha_publicacion']) ?></td>
          <td>
            <form method="GET" action="aplicar_oferta.php">
              <input type="hidden" name="oferta_id" value="<?= $fila['id'] ?>">
              <button class="btn btn-success btn-sm" type="submit">📨 Aplicar</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>