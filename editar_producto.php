<?php
session_start();
include 'conexion.php';

// Validar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

// Si se envió el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $categoria_id = $_POST['categoria_id'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $stock_minimo = $_POST['stock_minimo'];

    try {
        $sql = "UPDATE productos SET nombre = :nombre, categoria_id = :categoria_id, precio = :precio, stock = :stock, stock_minimo = :stock_minimo WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':categoria_id' => $categoria_id,
            ':precio' => $precio,
            ':stock' => $stock,
            ':stock_minimo' => $stock_minimo,
            ':id' => $id
        ]);

        header("Location: dashboard.php?exito=2");
        exit();
    } catch (PDOException $e) {
        $error = "Error al actualizar: " . $e->getMessage();
    }
}

// Consultar los datos actuales del producto
$stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) {
    header("Location: dashboard.php");
    exit();
}

// Consultar categorías para el select
$categorias = $conexion->query("SELECT * FROM categorias")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>StockFlow - Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
        <h4 class="text-secondary mb-3">Editar Producto</h4>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="editar_producto.php?id=<?php echo $id; ?>" method="POST">
            <div class="mb-2">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Categoría</label>
                <select class="form-select" name="categoria_id" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $producto['categoria_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Precio ($)</label>
                <input type="number" step="0.01" class="form-control" name="precio" value="<?php echo $producto['precio']; ?>" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Stock / Cantidad</label>
                <input type="number" class="form-control" name="stock" value="<?php echo $producto['stock']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock Mínimo</label>
                <input type="number" class="form-control" name="stock_minimo" value="<?php echo $producto['stock_minimo']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Actualizar Producto</button>
            <a href="dashboard.php" class="btn btn-secondary w-100">Cancelar</a>
        </form>
    </div>

</body>
</html>