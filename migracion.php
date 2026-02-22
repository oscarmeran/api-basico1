<?php
// migracion.php

// Incluimos nuestro archivo de conexión para poder hablar con la base de datos
require 'conexion.php';

// Escribimos la instrucción SQL para crear la tabla 'cervezas'
// Si la tabla ya existe, no hará nada (IF NOT EXISTS)
$sql = "CREATE TABLE IF NOT EXISTS cervezas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY, -- Un identificador único que crece solo
    nombre VARCHAR(100) NOT NULL,          -- El nombre de la cerveza (obligatorio)
    marca VARCHAR(100) NOT NULL,           -- La marca que la produce
    tipo VARCHAR(50),                      -- Tipo: IPA, Stout, Lager, etc.
    grado_alcoholico FLOAT                 -- Porcentaje de alcohol (admite decimales)
)";

try {
    // Preparamos y ejecutamos la instrucción SQL usando nuestra variable $conexion
    $conexion->exec($sql);
    echo "¡Migración exitosa! La tabla 'cervezas' ha sido creada correctamente.";
} catch(PDOException $e) {
    // Si ocurre un error al crear la tabla, lo mostramos
    echo "Error al crear la tabla: " . $e->getMessage();
}
?>