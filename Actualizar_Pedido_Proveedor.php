<?php

session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Datos tomados para modificar el pedido

    $idPedido = $_POST['idPedido'];
    $fechaPedido = $_POST['fechaPedido'];
    $fechaEntrega = $_POST['fechaEntregaPedido'];
    $idProveedor = $_POST['idProveedor'];

    $idEstadoPedido = $_POST['idEstadoPedido']; // id del estado del pedido
    $aclaracionesEstadoPedido = $_POST['aclaracionesEstadoPedido'];
    $condicionesDeEntrega = $_POST['condicionesDeEntrega'];

    // Validaciones básicas

    $errores = [];

    if (empty($fechaPedido) || empty($idProveedor)) {
        $errores[] = "No se puede realizar la actualización porque faltan datos obligatorios del pedido";
    }

    // Si hay errores, redirigir con el mensaje de error
    if (!empty($errores)) {
        $mensaje = implode(' ', $errores);
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';
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
                window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';
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
                window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';
            </script>";
            exit();
        }
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


    // Inicializar conexión
    $conexion = ConexionBD();


    // Update del registro en la tabla "PEDIDO". No necesitamos hacer update del detalle porque no se cambian artículos, montos, etc.
    $SQL_UpdatePedido = "UPDATE `pedido-a-proveedor` SET fechaEntregaPedido  = ?, 
                                                  idEstadoPedido  = ?, 
                                                  aclaracionesEstadoPedido  = ?, 
                                                  condicionesDeEntrega  = ?
                                            WHERE idPedido = ? ";
    
    $stmtPedido = $conexion->prepare($SQL_UpdatePedido);

    // validacion para confirmar que prepare() sea exitoso antes de proceder. Si no se realiza y la consulta prepare() llegara a fallar, podría causar error silencioso 
    if (!$stmtPedido) {
        die("<script>alert('Fallo al actualizar el pedido de ID {$idPedido}.'); window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';</script>");
    }

    $stmtPedido->bind_param("sissi", $fechaEntregaIngles, $idEstadoPedido, $aclaracionesEstadoPedido, $condicionesDeEntrega, $idPedido);

    if (!$stmtPedido->execute()) {
        die("<script>alert('Error al actualizar el pedido de ID {$idPedido}.'); window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';</script>");
    }

    // Cerrar las conexiones
    $stmtPedido->close();
    $conexion->close();

    // Redirigir exitosamente con un mensaje
    $mensaje = "Pedido modificado exitosamente. ID del pedido: {$idPedido}.";
    echo "<script> 
        alert('$mensaje');
        window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';
    </script>";
    exit();    
}

?>
