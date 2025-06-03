<?php
session_start();
require_once 'conn/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPedido = intval($_POST['idPedido']);
    
    // Conexión a la base de datos
    $conexion = ConexionBD();

    // Verificar si la devolución ya ha sido bloqueada
    $queryPedido = "SELECT aclaracionesEstadoPedido FROM `pedido-a-proveedor` WHERE idPedido = ?";
    $stmt = $conexion->prepare($queryPedido);
    $stmt->bind_param("i", $idPedido);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pedido = $resultado->fetch_assoc();

    if (strpos($pedido['aclaracionesEstadoPedido'], '[Bloqueado para devolución]') !== false) {
        echo "<script>alert('Este pedido ya tiene bloqueada la devolución.'); window.location.href = 'pedidosProveedores.php';</script>";
        exit();
    }

    // Crear un registro que indique que la modificación está bloqueada (sin cambiar el estado)
    $SQL_BloquearModificacion = "UPDATE `pedido-a-proveedor` SET aclaracionesEstadoPedido = CONCAT(aclaracionesEstadoPedido, ' [Bloqueado para devolución]') WHERE idPedido = ?";
    
    $stmt = $conexion->prepare($SQL_BloquearModificacion);
    if (!$stmt) {
        die("<script>alert('Error al bloquear la opción de devolución.'); window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';</script>");
    }

    $stmt->bind_param("i", $idPedido);
    if (!$stmt->execute()) {
        die("<script>alert('Error al deshabilitar el cambio de estado.'); window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';</script>");
    }

    $stmt->close();
    $conexion->close();

    // Redirigir con un mensaje de éxito
    echo "<script>alert('La opción de cambiar el estado a Devuelto ha sido bloqueada.'); window.location.href = 'pedidosProveedores.php?Identificador-Pedido={$idPedido}&Estado-Pedido=&Nombre-Proveedor=&CUIT-Proveedor=&IVA-Proveedor=&Localidad-Proveedor=&Direccion-Proveedor=&Precio-Unitario=&Cantidad-Producto=&MontoTotal-Pedido=&Tipo-Insumo=&Nombre-Insumo=&Descripcion-Insumo=&FechaPedido-Desde=&FechaPedido-Hasta=&FechaEntrega-Desde=&FechaEntrega-Hasta=&BotonFiltrar=FiltrandoPedidos';</script>";
    exit();
}
?>
