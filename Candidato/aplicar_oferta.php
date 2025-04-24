<?php
include('../db.php');

session_start();

$usuario_id = $_SESSION['usuario_id'];

// Obtener el ID del candidato relacionado a este usuario
$stmt = $conn->prepare("SELECT id FROM candidatos WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($candidato_id);
$stmt->fetch();
$stmt->close();

if (!$candidato_id) {
    echo "❌ Debes completar tu perfil de candidato antes de aplicar.";
    exit();
}

if (!isset($_GET['oferta_id'])) {
    echo "❌ Oferta no especificada.";
    exit();
}

$oferta_id = $_GET['oferta_id'];

// Verificar si ya aplicó
$verificar = $conn->prepare("SELECT id FROM aplicaciones WHERE oferta_id = ? AND candidato_id = ?");
$verificar->bind_param("ii", $oferta_id, $candidato_id);
$verificar->execute();
$verificar->store_result();

if ($verificar->num_rows > 0) {
    echo "❗Ya has aplicado a esta oferta. Por favor espera la respuesta.";
} else {
    $insertar = $conn->prepare("INSERT INTO aplicaciones (oferta_id, candidato_id) VALUES (?, ?)");
    $insertar->bind_param("ii", $oferta_id, $candidato_id);
    if ($insertar->execute()) {
        echo "✅ Has aplicado correctamente. La empresa revisará tu solicitud.";
    } else {
        echo "❌ Error al aplicar: " . $conn->error;
    }
    $insertar->close();
}

$verificar->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Candidato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>