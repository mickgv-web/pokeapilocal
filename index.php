<?php
// Leer el JSON local
$json = file_get_contents('pokemon.json');
$data = json_decode($json, true);

// Tomar los 10 primeros
$primeros = array_slice($data['pokemon'], 0, 10);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pokédex</title>
  <link rel="stylesheet" href="css/style.css">
  <script type="module" src="js/script.js"></script>
</head>
<body>
  <h1>Pokédex</h1>
  <div id="pokemonGrid" class="grid">
    <?php foreach ($primeros as $poke): ?>
      <div class="card">
        <h3>#<?= $poke['id'] ?> <?= htmlspecialchars($poke['nombre']) ?></h3>
        <p><strong>Tipos:</strong>
          <?php foreach ($poke['tipo'] as $tipo): ?>
            <span class="badge <?= strtolower($tipo) ?>"><?= htmlspecialchars($tipo) ?></span>
          <?php endforeach; ?>
        </p>
        <p><strong>Altura:</strong> <?= $poke['altura'] ?> m</p>
        <p><strong>Peso:</strong> <?= $poke['peso'] ?> kg</p>
      </div>
    <?php endforeach; ?>
  </div>

  <p id="status"></p>
</body>
</html>
