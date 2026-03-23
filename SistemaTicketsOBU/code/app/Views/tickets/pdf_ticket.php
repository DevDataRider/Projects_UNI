<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ticket PDF</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 20px;
      text-align: center;
    }

    h2 {
      margin-bottom: 10px;
      color: #2c3e50;
    }

    .info {
      margin: 10px 0;
      text-align: left;
    }

    .qr {
      margin-top: 20px;
    }

    .resaltado {
      font-weight: bold;
      color: #000;
    }

    .box {
      border: 1px dashed #888;
      padding: 10px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h2>🎟️ Ticket de Comedor</h2>

  <div class="info">
    <p><span class="resaltado">Nombre:</span> <?= esc(session('full_name')) ?></p>
    <p><span class="resaltado">Código Universitario:</span> <?= esc(session('university_code')) ?></p>
    <p><span class="resaltado">Fecha:</span> <?= esc($ticket['fecha']) ?></p>
    <p><span class="resaltado">Tipo de Comida:</span> <?= esc($ticket['tipo_comida_id']) ?></p>
    <p><span class="resaltado">Número de Orden:</span> <?= esc($nroOrden) ?></p>
  </div>

  <div class="qr">
    <img src="<?= $qr ?>" alt="Código QR" width="150">
  </div>

  <div class="box">
    Presenta este ticket al ingresar al comedor.<br>
    ¡Buen provecho!
  </div>
</body>
</html>
