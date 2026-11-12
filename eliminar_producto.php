<?php
session_start();
include 'conexion.php';

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID por la URL
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // Preparar y ejecutar la consulta de borrado
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Redirigir de regreso al panel con éxito
        header("Location: dashboard.php?exito=3");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar el producto: " . $e->getMessage());
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>