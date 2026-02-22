<?php
// esta es la etiqueta primordial de php, todo proyecto comienza así.

//definimos la base dedatos
//cuando empieza con $ eso es una variable

$host = "localhost"; //servidor local, para que conecte con XAMPP
$user = "root"; //El usuario por defecto de XAMPP 
$contrasena = ""; //Por defecto, ya que XAMPP no tiene contraseña
$base_datos = "api_cervezas"; //El nombre de la base de datos que creamos

//try catch sirve para intentar algo y si no funciona, catch hace algo, si funciona, sigue
//el código
try {
    // Intenta crear una nueva conexión usando PDO
    // PDO requiere: tipo de base (mysql), host y nombre de la base de datos
    $conexion = new PDO ("mysql:host=$host;dbname=$base_datos;charset=utf8", $user, $contrasena);

    // Configuramos PDO para que nos muestre los errores si algo sale mal
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    //Si falla la conexion, atrapamos el error y mostramos el mensaje
    echo "Error de conexion: " . $e->getMessage();
    //Detenemos la ejecucion del codigo
    die();
}
//para cerrar la etiqueta de php, mismo simbolo
?>
