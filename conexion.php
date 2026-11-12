<?php
// Parámetros de conexión a la base de datos
$host = 'localhost';
$dbname = 'stockflow';
$username = 'root'; // Cambia esto si tu usuario de MySQL es diferente
$password = '';     // Cambia esto si tu base de datos tiene contraseña

try {
    // Creamos la conexión usando PDO con codificación UTF-8
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configuramos el modo de error de PDO para que lance excepciones (útil para detectar fallos)
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: Configurar el modo de recuperación por defecto como objetos o arreglos asociativos
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Mensaje de prueba (puedes descomentar la siguiente línea para verificar que conecta bien)
    // echo "¡Conexión exitosa a la base de datos!";

} catch (PDOException $e) {
    // Si hay un error en la conexión, detenemos la ejecución y mostramos el mensaje
    die("Error de conexión: " . $e->getMessage());
}
?>