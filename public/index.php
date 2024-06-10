<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header("Content-Type: application/json");

$artworks = [
    ["id" => 1, "title" => "Artwork 1", "description" => "Description of artwork 1"],
    ["id" => 2, "title" => "Artwork 2", "description" => "Description of artwork 2"],
    // Ajoutez plus d'œuvres ici
];

echo json_encode($artworks);
