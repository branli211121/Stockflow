<?php
session_start();
include 'conexion.php';

// Verificamos que se haya enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $categoria_id = $_POST['categoria_id'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $stock_minimo = $_POST['stock_minimo'];

    if (!empty($nombre) && !empty($categoria_id) && isset($precio) && isset($stock)) {
        try {
            $sql = "INSERT INTO productos (nombre, categoria_id, precio, stock, stock_minimo) 
                    VALUES (:nombre, :categoria_id, :precio, :stock, :stock_minimo)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre,
                ':categoria_id' => $categoria_id,
                ':precio' => $precio,
                ':stock' => $stock,
                ':stock_minimo' => $stock_minimo
            ]);

            // Redireccionamos con éxito
            header("Location: dashboard.php?exito=1");
            exit();

        } catch (PDOException $e) {
            die("Error al registrar el producto: " . $e->getMessage());
        }
    } else {
        die("Por favor, completa todos los campos requeridos.");
    }
}
?>