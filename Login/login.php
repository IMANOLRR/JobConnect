<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            background: #f4f4f4;
            display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .btn-group a {
            display: block;
            margin: 10px 0;
            padding: 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn-group a:hover {
            background: #0056b3;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selecciona tu Rol</h2>
        <div class="btn-group">
            <a href="../Login/login_empresa.php">👤 Iniciar Sesión como Empresa</a>
            <a href="../Login/login_candidato.php">🏢Iniciar Sesión como Candidato</a>
        </div>
    </div>
</body>