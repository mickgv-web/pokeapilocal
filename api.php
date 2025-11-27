<?php
header('Content-Type: application/json; charset=utf-8');

// Cargar JSON desde archivo
$json = file_get_contents('pokemon.json');
$data = json_decode($json, true);

// Si no hay parámetros, devolver todo
if (!isset($_GET['name'])) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// Buscar por nombre
$name = strtolower($_GET['name']);
$resultado = null;

foreach ($data['pokemon'] as $poke) {
    if (strtolower($poke['nombre']) === $name) {
        $resultado = $poke;
        break;
    }
}

// Devolver resultado o error si no se encuentra
if ($resultado) {
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        "error" => "Pokémon no encontrado",
        "buscado" => $name
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
