<?php

session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Datos principales de la tabla "pedido"
    $fechaPedido = $_POST['fechapedido'];
    $fechaEntrega = $_POST['fechaentrega'];
    $idProveedor = $_POST['idProveedor'];
    $idEstadoPedido = 1;    // Valor predeterminado para "Estado del Pedido"
    $aclaracionesEstadoPedido = $_POST['aclaracionesestadopedido'];
    $condicionesDeEntrega = $_POST['condicionesdeentrega'];

    // Datos de la tabla "detalle" (insumos)
    $idTiposInsumos = $_POST['tipoInsumo']; // Array de tipos de insumos
    $nombresInsumos = $_POST['nombreInsumo']; // Array de nombres
    $descripcionesInsumos = $_POST['descripcionInsumo']; // Array de descripciones
    $preciosUnidad = $_POST['precioUnidad']; // Array de precios unitarios
    $cantidades = $_POST['cantidad']; // Array de cantidades
    $subtotales = $_POST['subtotal']; // Array de subtotales


    // Validaciones básicas

    $errores = [];

    if (empty($fechaPedido) || empty($idProveedor)) {
        $errores[] = "Faltan datos obligatorios del pedido";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'pedidosProveedores.php';
        </script>";
        exit();
    }


    // Validaciones de fechas
    if (!empty($fechaPedido) && !empty($fechaEntrega)) {
        $fechaPedidoObj = new DateTime($fechaPedido);
        $fechaEntregaObj = new DateTime($fechaEntrega);

        $fechaPedidoValidacion = $fechaPedidoObj->format('Y-m-d');
        $fechaEntregaValidacion = $fechaEntregaObj->format('Y-m-d');
        $fechaPedidoValidacion = new DateTime($fechaPedidoValidacion);
        $fechaEntregaValidacion = new DateTime($fechaEntregaValidacion);            

        // Verificar que la fecha de entrega no sea anterior a la fecha de pedido
        if ($fechaEntregaObj < $fechaPedidoObj) {
            $errores[] = "La fecha de entrega no puede ser anterior a la fecha de pedido.";

            $mensaje = implode(' ', $errores);
            echo "<script> 
                alert('$mensaje');
                window.location.href = 'pedidosProveedores.php';
            </script>";
            exit();
        }

        // Verificar que la diferencia entre fechas no supere 6 meses
        $intervalo = $fechaPedidoValidacion->diff($fechaEntregaValidacion);
        if ($intervalo->days > 180) { 
            $errores[] = "La fecha de entrega no puede superar 6 meses de diferencia con la fecha de pedido.";

            $mensaje = implode(' ', $errores);
            echo "<script> 
                alert('$mensaje');
                window.location.href = 'pedidosProveedores.php';
            </script>";
            exit();
        }
    }


    // Validación de cantidad de artículos
    if (empty($idTiposInsumos) || count($idTiposInsumos) == 0) {
        $errores[] = "Debe agregar al menos un artículo al pedido.";
    }

    // Si no se agregó ningún artículo, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'pedidosProveedores.php';
        </script>";
        exit();
    }




    // Procesamiento de las fechas
    $fechaEspanol = date_parse($fechaPedido);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaPedidoIngles = "$year-$mo-$day";
    
    if (!empty($fechaEntrega)) {
        $fechaEspanol = date_parse($fechaEntrega);
        $year = $fechaEspanol['year'];
        $mo = $fechaEspanol['month'];
        $day = $fechaEspanol['day'];
        $fechaEntregaIngles = "$year-$mo-$day";
    }

    // Procesamiento de campos
    $aclaracionesEstadoPedido = strip_tags($aclaracionesEstadoPedido);  // eliminando HTML tags para evitar inyección de código malicioso
    $aclaracionesEstadoPedido = trim($aclaracionesEstadoPedido); // eliminando espacios innecesarios

    $condicionesDeEntrega = strip_tags($condicionesDeEntrega);
    $condicionesDeEntrega = trim($condicionesDeEntrega);

    foreach ($nombresInsumos as &$nombre) {
        $nombre = strip_tags(trim($nombre));
    }
    foreach ($descripcionesInsumos as &$descripcion) {
        $descripcion = strip_tags(trim($descripcion));
    }


    // Inicializar conexión
    $conexion = ConexionBD();
    $conexion->begin_transaction();  // Inicialización de la transacción

    try {
        // .......... DB QUERIES ................

        // Insertar el registro principal en la tabla "PEDIDO"

        $sqlPedido = "INSERT INTO `pedido-a-proveedor` (fechaPedido, 
                                                        fechaEntregaPedido, 
                                                        idProveedor, 
                                                        idEstadoPedido, 
                                                        aclaracionesEstadoPedido, 
                                                        condicionesDeEntrega, 
                                                        totalPedido) 
                    VALUES (?, ?, ?, ?, ?, ?, ?); ";
        
        $stmtPedido = $conexion->prepare($sqlPedido);

        // validacion para confirmar que prepare() sea exitoso antes de proceder. Si no se realiza y la consulta prepare() llegara a fallar, podría causar error silencioso 
        if (!$stmtPedido) {
            throw new Exception("Fallo al preparar la consulta para insertar el pedido: " . $conexion->error);
        }

        // Calcular el monto total del pedido sumando los subtotales
        $montoTotal = array_sum($subtotales);

        $stmtPedido->bind_param("ssiissd", $fechaPedidoIngles, $fechaEntregaIngles, $idProveedor, $idEstadoPedido, $aclaracionesEstadoPedido, $condicionesDeEntrega, $montoTotal);
        $stmtPedido->execute();

        // Obtener el ID del pedido recién insertado para usarlo en la tabla "detalle"
        $idPedido = $conexion->insert_id;

        // ----------------------------------

        // Insertar los registros en la tabla "DETALLE" (y en las tablas de "insumos")

        $sqlDetalle = "INSERT INTO `detalle-pedidoaproveedor` (idPedido, 
                                                                idRepuestoVehiculo, 
                                                                idProductoVehiculo, 
                                                                idAccesorioVehiculo, 
                                                                cantidadUnidades, 
                                                                precioPorUnidad, 
                                                                subtotal) 
                    VALUES (?, ?, ?, ?, ?, ?, ?); ";
        
        $stmtDetalle = $conexion->prepare($sqlDetalle);

        // validacion para confirmar que prepare() sea exitoso antes de proceder. Si no se realiza y la consulta prepare() llegara a fallar, podría causar error silencioso 
        if (!$stmtDetalle) {
            throw new Exception("Fallo al preparar la consulta para insertar el detalle del pedido: " . $conexion->error);
        }

        for ($i = 0; $i < count($idTiposInsumos); $i++) {


            // Antes de continuar con la inserción en el "detalle", hago un insert en la tabla correspondiente de insumos y capturo la clave primaria
            $idRepuesto = null;
            $idProducto = null;
            $idAccesorio = null;
            $estadoInsumo = "Aún no recibido";

            if ($idTiposInsumos[$i] == '1') {

                if (empty($nombresInsumos[$i]) || empty($cantidades[$i]) || empty($preciosUnidad[$i])) {
                    throw new Exception("Datos incompletos en la fila $i del detalle.");
                }
                
                $sqlInsert_Repuesto = "INSERT INTO `repuestos-vehiculos` (nombreRepuesto,
                                                                        descripcionRepuesto,
                                                                        cantidadEnDeposito,
                                                                        precioRepuesto,
                                                                        estadoRepuesto, 
                                                                        idTipoInsumo,
                                                                        idProveedor) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?); ";

                $stmtRepuesto = $conexion->prepare($sqlInsert_Repuesto);

                $stmtRepuesto->bind_param("ssidsii", $nombresInsumos[$i], $descripcionesInsumos[$i], $cantidades[$i], $preciosUnidad[$i], $estadoInsumo, $idTiposInsumos[$i], $idProveedor);

                if (!$stmtRepuesto->execute()) {
                    die("Error al insertar el repuesto: " . $stmtRepuesto->error);
                }

                // Obtener el ID del repuesto recién insertado en la tabla "repuestos-vehiculos", para usarlo en la tabla "detalle"
                $idRepuesto = $conexion->insert_id; 
                $stmtRepuesto->close();     
            } 
            
            elseif ($idTiposInsumos[$i] == '2') {

                if (empty($nombresInsumos[$i]) || empty($cantidades[$i]) || empty($preciosUnidad[$i])) {
                    throw new Exception("Datos incompletos en la fila $i del detalle.");
                }

                $sqlInsert_Producto = "INSERT INTO `productos-vehiculo` (nombreProducto,
                                                                        descripcionProducto,
                                                                        cantidadEnDeposito,
                                                                        precioProducto, 
                                                                        estadoProducto,
                                                                        idTipoInsumo,
                                                                        idProveedor) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?); ";

                $stmtProducto = $conexion->prepare($sqlInsert_Producto);

                $stmtProducto->bind_param("ssidsii", $nombresInsumos[$i], $descripcionesInsumos[$i], $cantidades[$i], $preciosUnidad[$i], $estadoInsumo, $idTiposInsumos[$i], $idProveedor);

                if (!$stmtProducto->execute()) {
                    die("Error al insertar el producto: " . $stmtProducto->error);
                }

                // Obtener el ID del producto recién insertado en la tabla "productos-vehiculo", para usarlo en la tabla "detalle"
                $idProducto = $conexion->insert_id;
                $stmtProducto->close();
            } 
            
            elseif ($idTiposInsumos[$i] == '3') {

                if (empty($nombresInsumos[$i]) || empty($cantidades[$i]) || empty($preciosUnidad[$i])) {
                    throw new Exception("Datos incompletos en la fila $i del detalle.");
                }

                $sqlInsert_Accesorio = "INSERT INTO `accesorios-vehiculos` (nombreAccesorio,
                                                                            descripcionAccesorio,
                                                                            cantidadEnDeposito,
                                                                            precioAccesorio, 
                                                                            estadoAccesorio,
                                                                            idTipoInsumo,
                                                                            idProveedor) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?); ";

                $stmtAccesorio = $conexion->prepare($sqlInsert_Accesorio);

                $stmtAccesorio->bind_param("ssidsii", $nombresInsumos[$i], $descripcionesInsumos[$i], $cantidades[$i], $preciosUnidad[$i], $estadoInsumo, $idTiposInsumos[$i], $idProveedor);

                if (!$stmtAccesorio->execute()) {
                    die("Error al insertar el accesorio: " . $stmtAccesorio->error);
                }
                
                // Obtener el ID del accesorio recién insertado en la tabla "accesorios-vehiculos", para usarlo en la tabla "detalle"
                $idAccesorio = $conexion->insert_id;
                $stmtAccesorio->close();
            }


            // Ahora sí, podemos insertar el detalle en la base de datos

            $stmtDetalle->bind_param("iiiiidd", $idPedido, $idRepuesto, $idProducto, $idAccesorio, $cantidades[$i], $preciosUnidad[$i], $subtotales[$i]);

            if (!$stmtDetalle->execute()) {
                die("Error al insertar el detalle: " . $stmtDetalle->error);
            }
        }

        $conexion->commit(); // Confirmar todas las inserciones acumuladas durante la transacción. Es decir, se ejecuta la transacción inicializada con "begin_transaction()"
        
        // Cerrar las conexiones
        $stmtPedido->close();
        $stmtDetalle->close();
        $conexion->close();


        // Redirigir con un mensaje
        $mensaje = "Pedido registrado correctamente. ID del pedido: {$idPedido}.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';
        </script>";
        exit();
    }
    catch (Exception $e) {
        $conexion->rollback(); // // Revertir en caso de fallo 
        error_log("Error en algún punto de la transacción: " . $e->getMessage());
    }
    
}

?>
