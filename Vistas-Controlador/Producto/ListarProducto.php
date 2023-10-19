<?php

include("../../Repositorio/ProductoRepository.php");
include("../../Repositorio/CategoriaRepository.php");
include("../../Utiles/Includes/Header.php");


$categoriaSistemas = findAllCategoria();

if (isset($_GET["orden"])) {
    if ($_GET['orden'] == "alfaAZ") {
        $orden = "nombre ASC";
    } else if ($_GET['orden'] == "alfaZA") {
        $orden = "nombre DESC";
    } else if ($_GET['orden'] == "precio<>") {
        $orden = "precio ASC";
    } else if ($_GET['orden'] == "precio><") {
        $orden = "precio DESC";
    } else {
        $orden = "nombre ASC";
    }

} else {
    $_SESSION['productos'] = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitClub - Productos</title>

    <link rel="stylesheet" href="../../Utiles/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../Utiles/css/Fitclub.css">

    <style>
        body {
            font-family: 'Roboto Condensed';
        }
    </style>
</head>

<body>

    <legend class="mt-2" style="padding-left:15%; font-size:40px">Productos</legend>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>
    <?php
    if ($_SESSION['rol'] == 'admin') { ?>
        <button class="btn btn-lg btn-primary" style="font-size:15px; margin-top:7px" type="button">Crear</button>
        <button class="btn btn-lg btn-primary" style="font-size:15px; margin-top:7px" type="button">Borrar</button>
    <?php } ?>
    <hr style="width:95%;">
    <br>

    <div class="div_pro_1">
        <form action="listarProducto.php" method="POST">
            <fieldset class="form-group">
                <legend class="mt-4">Categorias</legend>
                <hr>
                <?php foreach ($categoriaSistemas as $categoria) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?php echo $categoria['cod_cat']; ?>"
                            name="check[]">
                        <label class="form-check-label" for="check">
                            <?php echo $categoria['nombre']; ?>
                        </label>
                    </div>
                <?php } ?>
                <br>
                <input type="submit" class="btn btn-primary" style="font-size:17px" value="Buscar" />
            </fieldset>
        </form>
    </div>


    <div style="float:right">
        <div class="dropdown">
            <button class="btn btn-dark" style="margin-right: 100px;">Ordenar por:</button>
            <div class="dropdown-content">
                <a href="ListarProducto.php?orden=alfaAZ">Nombre, A a Z</a>
                <a href="ListarProducto.php?orden=alfaZA">Nombre, Z a A</a>
                <a href="ListarProducto.php?orden=precio<>">Precio: de más bajo a más alto</a>
                <a href="ListarProducto.php?orden=precio><">Precio: de más alto a más bajo</a>
                <a href="ListarProducto.php?orden=relevancia">Relevancia</a>
            </div>
        </div>
    </div>

    <br>
    <br>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form action="CrearActualizarProducto.php?cod_producto=" method="POST">

                        <label for="nombre">Nombre: </label>
                        <input id="nombre" class="form-control" required type="text" name="nombre" value="<?php if (isset($nombre))
                            echo $nombre; ?>" /><br>

                        <label for="descripcion">Descripción: </label>
                        <input id="descripcion" class="form-control" required type="text" name="descripcion" value="<?php if (isset($descripcion))
                            echo $descripcion; ?>" /><br>

                        <label for="precio">Precio: </label>
                        <input id="precio" class="form-control" required type="number" name="precio" value="<?php if (isset($precio))
                            echo $precio; ?>" /><br>

                        <label for="imagen">Imagen URL: </label>
                        <input id="imagen" class="form-control" required type="text" name="imagen"
                            value="<?php if (isset($imagen))
                                echo $imagen; ?>" /><br>

                        <label for="cod_cat">Categoria: </label>
                        <select name="cod_cat">
                            <?php foreach ($categoriaSistemas as $categoria) { ?>
                                <option value="<?php echo $categoria["cod_cat"] ?>">
                                    <?php echo $categoria["nombre"] ?>
                                </option>
                            <?php } ?>
                        </select>

                        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                    </form>
                
            </div>
        </div>
    </div>

    <?php

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        $_POST['check'] = [];
        foreach ($categoriaSistemas as $cat) {
            array_push($_POST['check'], $cat['cod_cat']);
        }
    }

    if (isset($_GET["orden"])) {
        $productoSistemas = findProductoByIDOrdered($_SESSION['productos'], $orden);
        foreach ($productoSistemas as $producto) {
            include('producto.php');
        }

    } else {
        $i = 0;
        foreach ($_POST['check'] as $seleccion) {
            $productoSistemas = findProductoByCategoria($seleccion);
            foreach ($productoSistemas as $producto) {
                $_SESSION['productos'][$i] = $producto["cod_producto"];
                $i += 1;
                include('producto.php');
            }
        }
    }

    ?>

    <script>
        function carrito() {
            alert('Producto añadido al carrito');
        }

    </script>
    <script src="../../Utiles/Includes/javascript.js" crossorigin="anonymous"></script>

</body>

</html>