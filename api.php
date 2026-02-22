<?php
// api.php

// Le decimos al navegador que esta API devolverá datos en formato JSON
header("Content-Type: application/json");
// Permitimos que cualquier aplicación pueda consumir nuestra API
header("Access-Control-Allow-Origin: *");
// Definimos los métodos que nuestra API va a aceptar
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Incluimos la conexión a la base de datos
require 'conexion.php';

// Obtenemos qué método HTTP se está usando (GET, POST, PUT, DELETE)
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtenemos los datos que el usuario nos envía en el cuerpo (body) de la petición
// file_get_contents("php://input") lee el JSON crudo que nos envían
$datosRecibidos = json_decode(file_get_contents("php://input"), true);

// Usamos un 'switch' para decidir qué hacer según el método HTTP
switch ($metodo) {
    
    // ==========================================
    // MÉTODO GET: Leer datos (La 'R' de CRUD)
    // ==========================================
    case 'GET':
        // Preparamos la consulta para seleccionar todas las cervezas
        $sql = "SELECT * FROM cervezas";
        $stmt = $conexion->prepare($sql);
        // Ejecutamos la consulta
        $stmt->execute();
        // Guardamos todos los resultados en un arreglo (array)
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Imprimimos los resultados en formato JSON
        echo json_encode($resultados);
        break;

    // ==========================================
    // MÉTODO POST: Crear datos (La 'C' de CRUD)
    // ==========================================
    case 'POST':
        // Extraemos los datos del JSON recibido
        $nombre = $datosRecibidos['nombre'];
        $marca = $datosRecibidos['marca'];
        $tipo = $datosRecibidos['tipo'];
        $grado = $datosRecibidos['grado_alcoholico'];

        // Preparamos la consulta SQL para insertar. Usamos ':' como marcadores de posición por seguridad
        $sql = "INSERT INTO cervezas (nombre, marca, tipo, grado_alcoholico) VALUES (:nombre, :marca, :tipo, :grado)";
        $stmt = $conexion->prepare($sql);
        
        // Unimos los marcadores con las variables reales (esto evita ataques de Inyección SQL)
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':grado', $grado);
        
        // Si la consulta se ejecuta bien, enviamos un mensaje de éxito
        if ($stmt->execute()) {
            echo json_encode(["mensaje" => "Cerveza registrada con éxito"]);
        } else {
            echo json_encode(["mensaje" => "Error al registrar la cerveza"]);
        }
        break;

    // ==========================================
    // MÉTODO PUT: Actualizar datos (La 'U' de CRUD)
    // ==========================================
    case 'PUT':
        // Para actualizar, necesitamos saber el ID de la cerveza y los nuevos datos
        $id = $datosRecibidos['id'];
        $nombre = $datosRecibidos['nombre'];
        $marca = $datosRecibidos['marca'];
        $tipo = $datosRecibidos['tipo'];
        $grado = $datosRecibidos['grado_alcoholico'];

        // Preparamos la consulta de actualización (UPDATE)
        $sql = "UPDATE cervezas SET nombre = :nombre, marca = :marca, tipo = :tipo, grado_alcoholico = :grado WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        
        // Unimos los valores
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':grado', $grado);
        
        if ($stmt->execute()) {
            echo json_encode(["mensaje" => "Cerveza actualizada con éxito"]);
        } else {
            echo json_encode(["mensaje" => "Error al actualizar la cerveza"]);
        }
        break;

    // ==========================================
    // MÉTODO DELETE: Eliminar datos (La 'D' de CRUD)
    // ==========================================
    case 'DELETE':
        // Para eliminar, solo necesitamos el ID
        $id = $datosRecibidos['id'];

        // Preparamos la consulta de eliminación (DELETE)
        $sql = "DELETE FROM cervezas WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            echo json_encode(["mensaje" => "Cerveza eliminada con éxito"]);
        } else {
            echo json_encode(["mensaje" => "Error al eliminar la cerveza"]);
        }
        break;

    // Si envían un método que no conocemos
    default:
        echo json_encode(["mensaje" => "Método no soportado"]);
        break;
}
?>