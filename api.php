<?php
header('Content-Type: application/json; charset=utf-8');

// Cargar JSON desde archivo
$json = file_get_contents('pokemon.json');
$data = json_decode($json, true);

if ($json === false || $data === null) {
    echo json_encode(["error" => "No se pudo leer o decodificar el JSON"]);
    exit;
}

$pokemon = $data['pokemon'];

if (isset($_GET['name'])) {
    $name = strtolower($_GET['name']);
    $resultado = null;

    foreach ($pokemon as $poke) {
        if (strtolower($poke['nombre']) === $name) {
            $resultado = $poke;
            break;
        }
    }

    if ($resultado) {
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            "error" => "Pokémon no encontrado",
            "buscado" => $name
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    exit;
}

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit  = isset($_GET['limit']) ? intval($_GET['limit']) : count($pokemon);

$subset = array_slice($pokemon, $offset, $limit);

echo json_encode([
    "count" => count($pokemon),
    "offset" => $offset,
    "limit" => $limit,
    "results" => $subset
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
