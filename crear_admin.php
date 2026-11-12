<?php
include 'conexion.php';

$nombre = "Administrador";
$email = "admin@stockflow.com";
$password_plano = "123456"; // Contraseña temporal para pruebas
$rol = "admin";

// Generamos un hash seguro con la función oficial de PHP
$password_hash = password_hash($password_plano, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':password' => $password_hash,
        ':rol' => $rol
    ]);
    echo "¡Usuario administrador creado con éxito!<br>";
    echo "Correo: <b>admin@stockflow.com</b><br>";
    echo "Contraseña: <b>123456</b><br>";
    echo "<a href='login.php'>Ir al Login</a>";
} catch (PDOException $e) {
    echo "Error (quizás el correo ya está registrado): " . $e->getMessage();
}
?>