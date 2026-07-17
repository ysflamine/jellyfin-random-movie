<?php
/**
 * API Wrapper para Jellyfin
 * Obtiene una película aleatoria de la biblioteca especificada.
 */

header('Content-Type: application/json');

// Comprobar si el usuario ha configurado el archivo
if (!file_exists("config.php")) {
    echo json_encode(["error" => "Falta el archivo config.php. Revisa el README."]);
    exit;
}

require "config.php";

/**
 * Realiza la petición cURL al servidor de medios.
 */
function hacerPeticion($url) {
    $headers = [
        "X-Emby-Token: " . API_TOKEN, // Funciona en Emby[no comprobado] y Jellyfin
        "Accept: application/json"
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10); // Evita que se quede colgado

    $respuesta = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpCode !== 200 || !$respuesta) {
        return null;
    }

    return json_decode($respuesta, true);
}

/**
 * Obtiene el ID de una biblioteca por su nombre (ej: "Peliculas")
 */
function conseguirIdBiblioteca($nombre) {
    $url = SERVER_URL . "/Items";
    $datos = hacerPeticion($url);

    if (!$datos || !isset($datos["Items"])) return null;

    foreach ($datos["Items"] as $item) {
        if (strtolower($item["Name"]) === strtolower($nombre)) {
            return $item["Id"];
        }
    }
    return null;
}

/**
 * Extrae una película aleatoria de la biblioteca seleccionada
 */
function conseguirPeliculaAleatoria($idBiblioteca) {
    $url = SERVER_URL . "/Items?ParentId=" . $idBiblioteca . "&IncludeItemTypes=Movie&Recursive=true";
    $datos = hacerPeticion($url);

    if (!$datos || empty($datos["Items"])) return null;

    $indice = array_rand($datos["Items"]);
    return $datos["Items"][$indice];
}

// 1. Buscar biblioteca
$idBiblioteca = conseguirIdBiblioteca("Peliculas");

if ($idBiblioteca === null) {
    echo json_encode(["error" => "No se encontró la biblioteca o el servidor no responde."]);
    exit;
}

// 2. Buscar película
$pelicula = conseguirPeliculaAleatoria($idBiblioteca);

if ($pelicula === null) {
    echo json_encode(["error" => "No se encontraron películas en la biblioteca."]);
    exit;
}

// 3. Crear URL de la imagen y devolver respuesta
$imagen = SERVER_URL . "/Items/" . $pelicula["Id"] . "/Images/Primary";

echo json_encode([
    "nombre" => $pelicula["Name"],
    "imagen" => $imagen
]);