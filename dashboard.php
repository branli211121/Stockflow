<?php
session_start();
include 'conexion.php';

// Si el usuario no ha iniciado sesión, lo redirigimos al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Consultamos los productos uniendo la tabla de productos con la de categorías (Usando INNER JOIN)
try {
    $sql = "SELECT p.*, c.nombre AS categoria_nombre 
            FROM productos p 
            INNER JOIN categorias c ON p.categoria_id = c.id 
            ORDER BY p.id DESC";
    $stmt = $conexion->query($sql);
    $productos = $stmt->fetchAll();

    // Consultamos también las categorías para usarlas en el formulario de registro
    $stmt_cat = $conexion->query("SELECT * FROM categorias");
    $categorias = $stmt_cat->fetchAll();

} catch (PDOException $e) {
    $error_bd = "Error al cargar los datos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow - Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Barra de navegación superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">StockFlow</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container mt-4">
        
        <?php if (isset($_GET['exito'])): ?>
            <?php if ($_GET['exito'] == 1): ?>
                <div class="alert alert-success">¡Producto agregado correctamente!</div>
            <?php elseif ($_GET['exito'] == 2): ?>
                <div class="alert alert-success">¡Producto actualizado correctamente!</div>
            <?php elseif ($_GET['exito'] == 3): ?>
                <div class="alert alert-success">¡Producto eliminado correctamente!</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="row">
            <!-- Formulario para agregar producto -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3">
                    <h5 class="text-secondary mb-3">Agregar Nuevo Producto</h5>
                    <form action="agregar_producto.php" method="POST">
                        <div class="mb-2">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-sm" name="nombre" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Categoría</label>
                            <select class="form-select form-select-sm" name="categoria_id" required>
                                <option value="">Selecciona...</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Precio ($)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="precio" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Stock / Cantidad</label>
                            <input type="number" class="form-control form-control-sm" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Mínimo (Alerta)</label>
                            <input type="number" class="form-control form-control-sm" name="stock_minimo" value="5" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Guardar Producto</button>
                    </form>
                </div>
            </div>

            <!-- Tabla de inventario -->
            <div class="col-md-8">
                <div class="card shadow-sm p-3">
                    <h5 class="text-secondary mb-3">Inventario Actual</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($productos)): ?>
                                    <?php foreach ($productos as $prod): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($prod['nombre']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($prod['categoria_nombre']); ?></td>
                                            <td>$<?php echo number_format($prod['precio'], 2); ?></td>
                                            <td><?php echo $prod['stock']; ?></td>
                                            <td>
                                                <?php if ($prod['stock'] <= $prod['stock_minimo']): ?>
                                                    <span class="badge bg-danger">Bajo Stock</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Óptimo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="editar_producto.php?id=<?php echo $prod['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                                <a href="eliminar_producto.php?id=<?php echo $prod['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No hay productos registrados.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>