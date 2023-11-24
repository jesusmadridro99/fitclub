<!-- Div con el contenido de cada producto -->
<div class="card border-primary mb-3 div_pro_2" style="width:250px;">
    <div class="card-header">
        <?php echo $producto['nombre']; ?>
    </div>
    <div class="card-body" style="background-color:rgb(253, 237, 237)">
        <div style="height:200px;
                    border-radius:10px;
                    width:200px;
                    background-image:url(<?php echo $producto['imagen'] ?>);
                    background-size: cover;
                    background-repeat: no-repeat;
                    margin:5px;">
        </div>
        <hr>
        <h6 class="card-title">
            <?php echo $producto["precio"] ?> €
        </h6>
        
        <?php if (isset($_SESSION['rol']) == ["usuario"]) { ?>
            <hr>
            <?php if ($_SESSION["rol"] == "usuario") { ?>

                <a class="btn btn-lg btn-primary" style="font-size:15px;" type="button"
                    href="ListarProducto.php?carrito=<?php echo $producto['cod_producto'] ?>">Añadir al carrito</a>
                <br>
                
            <?php }
            if ($_SESSION['rol'] == 'admin') { ?>

                <a class="btn btn-primary" style="font-size:15px; margin-top:7px"
                    href="javascript: comprobarEliminar(<?php echo $producto['cod_producto'] ?>)">Borrar</a>

                <a class="btn btn-primary" style="font-size:15px; margin-top:7px"
                    href="javascript: modificar(<?php echo $producto['cod_producto'] ?>)">Modificar</a>

            <?php }
        }
        ?>

    </div>
</div>