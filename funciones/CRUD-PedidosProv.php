<?php

// EMITIR LISTADO con todos los pedidos a proveedores

function Listar_PedidosProveedores($conexion) {

    $Listado = array();

    $SQL = "SELECT pp.idPedido as ppIdPedido,
                   pp.fechaPedido as FechaPedido,
                   pp.fechaEntregaPedido as FechaEntrega,
                   pp.idProveedor as ppIdProveedor,
                   pp.idEstadoPedido as ppIdEstadoPedido,
                   pp.aclaracionesEstadoPedido as AclaracionesEstadoPedido,
                   pp.condicionesDeEntrega as CondicionesDeEntrega,
                   pp.totalPedido as TotalPedido,

                   dp.idDetallePedidoAProveedor as IdDetallePedido,
                   dp.idPedido as dpIdPedido,
                   dp.precioPorUnidad as PrecioPorUnidad,
                   dp.cantidadUnidades as CantidadUnidades,
                   dp.subtotal as Subtotal, 
                   dp.idRepuestoVehiculo as dpIdRepuesto,
                   dp.idProductoVehiculo as dpIdProducto,
                   dp.idAccesorioVehiculo as dpIdAccesorio,

                   r.idRepuesto as rIdRepuesto,
                   r.nombreRepuesto as NombreRepuesto,
                   r.descripcionRepuesto as DescripcionRepuesto,
                   r.idTipoInsumo as rIdTipoInsumo,

                   i.idTipoInsumo as iIdTipoInsumo,
                   i.tipoInsumo as TipoInsumo,

                   p.idProducto as pIdProducto,
                   p.nombreProducto as NombreProducto,
                   p.descripcionProducto as DescripcionProducto,
                   p.idTipoInsumo as pIdTipoInsumo, 

                   a.idAccesorio as aIdAccesorio,
                   a.nombreAccesorio as NombreAccesorio,
                   a.descripcionAccesorio as DescripcionAccesorio,
                   a.idTipoInsumo as aIdTipoInsumo,

                   pv.idProveedor as IdProveedor,
                   pv.nombreProveedor as NombreProveedor,
                   pv.mailProveedor as MailProveedor,
                   pv.direccionProveedor as DireccionProveedor,
                   pv.telefonoProveedor as TelProveedor,
                   pv.localidadProveedor as LocalidadProveedor,
                   pv.cuitProveedor as CuitProveedor,
                   pv.ivaProveedor as IvaProveedor,

                   e.idEstadoPedido as IdEstadoPedido, 
                   e.estadoPedido as EstadoPedido 
            FROM `pedido-a-proveedor` pp
            INNER JOIN `detalle-pedidoaproveedor` dp ON pp.idPedido = dp.idPedido
            LEFT JOIN `repuestos-vehiculos` r ON dp.idRepuestoVehiculo = r.idRepuesto
            LEFT JOIN `productos-vehiculo` p ON dp.idProductoVehiculo = p.idProducto
            LEFT JOIN `accesorios-vehiculos` a ON dp.idAccesorioVehiculo = a.idAccesorio
            LEFT JOIN `tipo-insumo` i ON (i.idTipoInsumo = r.idTipoInsumo OR i.idTipoInsumo = p.idTipoInsumo OR i.idTipoInsumo = a.idTipoInsumo)
            INNER JOIN `proveedores` pv ON pp.idProveedor = pv.idProveedor
            INNER JOIN `estados-pedidoaproveedor` e ON pp.idEstadoPedido = e.idEstadoPedido
            ORDER BY pp.fechaPedido DESC, pp.idPedido DESC, dp.idDetallePedidoAProveedor ASC; ";

    $rs = mysqli_query($conexion, $SQL);
        
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {

        $ppIdPedido = $data['ppIdPedido'];
        $dpIdDetalle = $data['IdDetallePedido'];

        // Verificar si ya existe el pedido
        if (!isset($Listado[$ppIdPedido])) {

            $Listado[$ppIdPedido] = array(
                'ppIdPedido' => $data['ppIdPedido'],
                'FechaPedido' => $data['FechaPedido'],
                'FechaEntrega' => $data['FechaEntrega'],

                'EstadoPedido' => $data['EstadoPedido'],
                'AclaracionesEstadoPedido' => $data['AclaracionesEstadoPedido'],
                'CondicionesDeEntrega' => $data['CondicionesDeEntrega'],

                'NombreProveedor' => $data['NombreProveedor'],
                'MailProveedor' => $data['MailProveedor'],
                'DireccionProveedor' => $data['DireccionProveedor'],
                'TelProveedor' => $data['TelProveedor'],
                'LocalidadProveedor' => $data['LocalidadProveedor'],
                'CuitProveedor' => $data['CuitProveedor'],
                'IvaProveedor' => $data['IvaProveedor'],

                'TotalPedido' => $data['TotalPedido'],
                'Detalles' => array()
            );
        }

        // Verificar si ya existe el detalle
        if (!isset($Listado[$ppIdPedido]['Detalles'][$dpIdDetalle])) {

            // Si es repuesto
            if ($data['iIdTipoInsumo'] == 1) {

                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => $data['rIdRepuesto'],
                    'NombreRepuesto' => $data['NombreRepuesto'],
                    'DescripcionRepuesto' => $data['DescripcionRepuesto'],
                    'IdProducto' => null,
                    'NombreProducto' => null,
                    'DescripcionProducto' => null,
                    'IdAccesorio' => null,
                    'NombreAccesorio' => null,
                    'DescripcionAccesorio' => null,
                    'TipoInsumo' => $data['TipoInsumo']
                );
            }

            // Si es producto
            elseif ($data['iIdTipoInsumo'] == 2) {
                
                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => null,
                    'NombreRepuesto' => null,
                    'DescripcionRepuesto' => null,
                    'IdProducto' => $data['pIdProducto'],
                    'NombreProducto' => $data['NombreProducto'],
                    'DescripcionProducto' => $data['DescripcionProducto'],
                    'IdAccesorio' => null,
                    'NombreAccesorio' => null,
                    'DescripcionAccesorio' => null,
                    'TipoInsumo' => $data['TipoInsumo']
                );
            }

            // Si es accesorio
            elseif ($data['iIdTipoInsumo'] == 3) {
                                 
                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => null,
                    'NombreRepuesto' => null,
                    'DescripcionRepuesto' => null,
                    'IdProducto' => null,
                    'NombreProducto' => null,
                    'DescripcionProducto' => null,
                    'IdAccesorio' => $data['aIdAccesorio'],
                    'NombreAccesorio' => $data['NombreAccesorio'],
                    'DescripcionAccesorio' => $data['DescripcionAccesorio'],
                    'TipoInsumo' => $data['TipoInsumo']
                );   
            } 

        }

        $i++;
    }

    return $Listado;
}




function Procesar_ConsultaPedidosProveedores() {

    $_GET['Identificador-Pedido'] = trim($_GET['Identificador-Pedido']);
    $_GET['Identificador-Pedido'] = strip_tags($_GET['Identificador-Pedido']);

    $_GET['Estado-Pedido'] = trim($_GET['Estado-Pedido']);
    $_GET['Estado-Pedido'] = strip_tags($_GET['Estado-Pedido']);

    $_GET['Nombre-Proveedor'] = trim($_GET['Nombre-Proveedor']);
    $_GET['Nombre-Proveedor'] = strip_tags($_GET['Nombre-Proveedor']);

    $_GET['CUIT-Proveedor'] = trim($_GET['CUIT-Proveedor']);
    $_GET['CUIT-Proveedor'] = strip_tags($_GET['CUIT-Proveedor']);

    $_GET['IVA-Proveedor'] = trim($_GET['IVA-Proveedor']);
    $_GET['IVA-Proveedor'] = strip_tags($_GET['IVA-Proveedor']);

    $_GET['Localidad-Proveedor'] = trim($_GET['Localidad-Proveedor']);
    $_GET['Localidad-Proveedor'] = strip_tags($_GET['Localidad-Proveedor']);

    $_GET['Direccion-Proveedor'] = trim($_GET['Direccion-Proveedor']);
    $_GET['Direccion-Proveedor'] = strip_tags($_GET['Direccion-Proveedor']);

    $_GET['Precio-Unitario'] = trim($_GET['Precio-Unitario']);
    $_GET['Precio-Unitario'] = strip_tags($_GET['Precio-Unitario']);

    $_GET['Cantidad-Producto'] = trim($_GET['Cantidad-Producto']);
    $_GET['Cantidad-Producto'] = strip_tags($_GET['Cantidad-Producto']);

    $_GET['MontoTotal-Pedido'] = trim($_GET['MontoTotal-Pedido']);
    $_GET['MontoTotal-Pedido'] = strip_tags($_GET['MontoTotal-Pedido']);

    $_GET['Tipo-Insumo'] = trim($_GET['Tipo-Insumo']);
    $_GET['Tipo-Insumo'] = strip_tags($_GET['Tipo-Insumo']);

    $_GET['Nombre-Insumo'] = trim($_GET['Nombre-Insumo']);
    $_GET['Nombre-Insumo'] = strip_tags($_GET['Nombre-Insumo']);

    $_GET['Descripcion-Insumo'] = trim($_GET['Descripcion-Insumo']);
    $_GET['Descripcion-Insumo'] = strip_tags($_GET['Descripcion-Insumo']);

    // Se cambia formato de las fechas:
    $fechaEspanol = $_GET['FechaPedido-Desde'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['FechaPedido-Desde'] = $fechaIngles;

    $fechaEspanol = $_GET['FechaPedido-Hasta'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['FechaPedido-Hasta'] = $fechaIngles;

    $fechaEspanol = $_GET['FechaEntrega-Desde'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['FechaEntrega-Desde'] = $fechaIngles;

    $fechaEspanol = $_GET['FechaEntrega-Hasta'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['FechaEntrega-Hasta'] = $fechaIngles;

}


function Consulta_PedidosAProveedor($identificadorPedido, $estadoPedido, $nombreProveedor, $cuitProveedor, $ivaProveedor, $localidadProveedor, $direccionProveedor, $precioUnitario, $cantidadProducto, $montoTotalPedido, $tipoInsumo, $nombreInsumo, $descripcionInsumo, $fechaPedidoDesde, $fechaPedidoHasta, $fechaEntregaDesde, $fechaEntregaHasta, $conexion) {

    if (empty($identificadorPedido)) {
        $identificadorPedido = "ZZZZZZ";
    }
    if (empty($estadoPedido)) {
        $estadoPedido = "9999999";
    }
    if (empty($cuitProveedor)) {
        $cuitProveedor = "&&&&&&";
    }
    if (empty($nombreProveedor)) {
        $nombreProveedor = "9999999";
    }
    if (empty($ivaProveedor)) {
        $ivaProveedor = "9999999999";
    }
    if (empty($localidadProveedor)) {
        $localidadProveedor = "9999999";
    }
    if (empty($direccionProveedor)) {
        $direccionProveedor = "9999999";
    }

    if (empty($precioUnitario)) {
        $precioUnitario = "0";
    }
    if (empty($cantidadProducto)) {
        $cantidadProducto = "0";
    }
    if (empty($montoTotalPedido)) {
        $montoTotalPedido = "0";
    }

    if (empty($tipoInsumo)) {
        $tipoInsumo = "9999999";
    }
    if (empty($nombreInsumo)) {
        $nombreInsumo = "9999999";
    }
    if (empty($descripcionInsumo)) {
        $descripcionInsumo = "9999999";
    }

    if (empty($fechaPedidoDesde)) {
        $fechaPedidoDesde = "ZZZZZZ";
    }
    if (empty($fechaPedidoHasta)) {
        $fechaPedidoHasta = "ZZZZZZ";
    }
    if (empty($fechaEntregaDesde)) {
        $fechaEntregaDesde = "ZZZZZZ";
    }
    if (empty($fechaEntregaHasta)) {
        $fechaEntregaHasta = "ZZZZZZ";
    }

    $Listado = array();

    $SQL = "SELECT pp.idPedido as ppIdPedido,
                   pp.fechaPedido as FechaPedido,
                   pp.fechaEntregaPedido as FechaEntrega,
                   pp.idProveedor as ppIdProveedor,
                   pp.idEstadoPedido as ppIdEstadoPedido,
                   pp.aclaracionesEstadoPedido as AclaracionesEstadoPedido,
                   pp.condicionesDeEntrega as CondicionesDeEntrega,
                   pp.totalPedido as TotalPedido,

                   dp.idDetallePedidoAProveedor as IdDetallePedido,
                   dp.idPedido as dpIdPedido,
                   dp.precioPorUnidad as PrecioPorUnidad,
                   dp.cantidadUnidades as CantidadUnidades,
                   dp.subtotal as Subtotal, 
                   dp.idRepuestoVehiculo as dpIdRepuesto,
                   dp.idProductoVehiculo as dpIdProducto,
                   dp.idAccesorioVehiculo as dpIdAccesorio,

                   r.idRepuesto as rIdRepuesto,
                   r.nombreRepuesto as NombreRepuesto,
                   r.descripcionRepuesto as DescripcionRepuesto,
                   r.idTipoInsumo as rIdTipoInsumo,

                   i.idTipoInsumo as iIdTipoInsumo,
                   i.tipoInsumo as TipoInsumo,

                   p.idProducto as pIdProducto,
                   p.nombreProducto as NombreProducto,
                   p.descripcionProducto as DescripcionProducto,
                   p.idTipoInsumo as pIdTipoInsumo, 

                   a.idAccesorio as aIdAccesorio,
                   a.nombreAccesorio as NombreAccesorio,
                   a.descripcionAccesorio as DescripcionAccesorio,
                   a.idTipoInsumo as aIdTipoInsumo,

                   pv.idProveedor as IdProveedor,
                   pv.nombreProveedor as NombreProveedor,
                   pv.mailProveedor as MailProveedor,
                   pv.direccionProveedor as DireccionProveedor,
                   pv.telefonoProveedor as TelProveedor,
                   pv.localidadProveedor as LocalidadProveedor,
                   pv.cuitProveedor as CuitProveedor,
                   pv.ivaProveedor as IvaProveedor,

                   e.idEstadoPedido as IdEstadoPedido, 
                   e.estadoPedido as EstadoPedido 
            FROM `pedido-a-proveedor` pp
            INNER JOIN `detalle-pedidoaproveedor` dp ON pp.idPedido = dp.idPedido
            LEFT JOIN `repuestos-vehiculos` r ON dp.idRepuestoVehiculo = r.idRepuesto
            LEFT JOIN `productos-vehiculo` p ON dp.idProductoVehiculo = p.idProducto
            LEFT JOIN `accesorios-vehiculos` a ON dp.idAccesorioVehiculo = a.idAccesorio
            LEFT JOIN `tipo-insumo` i ON (i.idTipoInsumo = r.idTipoInsumo OR i.idTipoInsumo = p.idTipoInsumo OR i.idTipoInsumo = a.idTipoInsumo)
            INNER JOIN `proveedores` pv ON pp.idProveedor = pv.idProveedor
            INNER JOIN `estados-pedidoaproveedor` e ON pp.idEstadoPedido = e.idEstadoPedido 

            WHERE (pp.idPedido = '$identificadorPedido%' 
                    OR pv.cuitProveedor LIKE '$cuitProveedor%' 
                    OR pv.nombreProveedor LIKE '$nombreProveedor%' 
                    OR pv.ivaProveedor LIKE '$ivaProveedor%' 
                    OR pv.localidadProveedor LIKE '$localidadProveedor%' 
                    OR pv.direccionProveedor LIKE '$direccionProveedor%' 
                    OR e.estadoPedido LIKE '$estadoPedido%' 
                    OR dp.precioPorUnidad <= '$precioUnitario' 
                    OR dp.cantidadUnidades = '$cantidadProducto' 
                    OR pp.totalPedido <= '$montoTotalPedido' 
                    OR i.tipoInsumo LIKE '$tipoInsumo%' 
                    OR (p.nombreProducto LIKE '%$nombreInsumo%' OR r.nombreRepuesto LIKE '%$nombreInsumo%' OR a.nombreAccesorio LIKE '%$nombreInsumo%') 
                    OR (p.descripcionProducto LIKE '%$descripcionInsumo%' OR r.descripcionRepuesto LIKE '%$descripcionInsumo%' OR a.descripcionAccesorio LIKE '%$descripcionInsumo%') 
                    OR (pp.fechaPedido BETWEEN '$fechaPedidoDesde%' AND '$fechaPedidoHasta%') 
                    OR (pp.fechaEntregaPedido BETWEEN '$fechaEntregaDesde%' AND '$fechaEntregaHasta%')) 
            ORDER BY pp.fechaPedido DESC, pp.idPedido DESC, dp.idDetallePedidoAProveedor ASC; ";

    $rs = mysqli_query($conexion, $SQL);
        
    // El resultado debe organizarse en una matriz, entonces lo recorro:
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {

        $ppIdPedido = $data['ppIdPedido'];
        $dpIdDetalle = $data['IdDetallePedido'];

        // Verificar si ya existe el pedido
        if (!isset($Listado[$ppIdPedido])) {

            $Listado[$ppIdPedido] = array(
                'ppIdPedido' => $data['ppIdPedido'],
                'FechaPedido' => $data['FechaPedido'],
                'FechaEntrega' => $data['FechaEntrega'],

                'EstadoPedido' => $data['EstadoPedido'],
                'AclaracionesEstadoPedido' => $data['AclaracionesEstadoPedido'],
                'CondicionesDeEntrega' => $data['CondicionesDeEntrega'],

                'NombreProveedor' => $data['NombreProveedor'],
                'MailProveedor' => $data['MailProveedor'],
                'DireccionProveedor' => $data['DireccionProveedor'],
                'TelProveedor' => $data['TelProveedor'],
                'LocalidadProveedor' => $data['LocalidadProveedor'],
                'CuitProveedor' => $data['CuitProveedor'],
                'IvaProveedor' => $data['IvaProveedor'],

                'TotalPedido' => $data['TotalPedido'],
                'Detalles' => array()
            );
        }

        // Verificar si ya existe el detalle
        if (!isset($Listado[$ppIdPedido]['Detalles'][$dpIdDetalle])) {

            // Si es repuesto
            if ($data['iIdTipoInsumo'] == 1) {

                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => $data['rIdRepuesto'],
                    'NombreRepuesto' => $data['NombreRepuesto'],
                    'DescripcionRepuesto' => $data['DescripcionRepuesto'],
                    'IdProducto' => null,
                    'NombreProducto' => null,
                    'DescripcionProducto' => null,
                    'IdAccesorio' => null,
                    'NombreAccesorio' => null,
                    'DescripcionAccesorio' => null,
                    'TipoInsumo' => $data['TipoInsumo']
                );
            }

            // Si es producto
            elseif ($data['iIdTipoInsumo'] == 2) {
                
                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => null,
                    'NombreRepuesto' => null,
                    'DescripcionRepuesto' => null,
                    'IdProducto' => $data['pIdProducto'],
                    'NombreProducto' => $data['NombreProducto'],
                    'DescripcionProducto' => $data['DescripcionProducto'],
                    'IdAccesorio' => null,
                    'NombreAccesorio' => null,
                    'DescripcionAccesorio' => null,
                    'TipoInsumo' => $data['TipoInsumo']
                );
            }

            // Si es accesorio
            elseif ($data['iIdTipoInsumo'] == 3) {
                                 
                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => null,
                    'NombreRepuesto' => null,
                    'DescripcionRepuesto' => null,
                    'IdProducto' => null,
                    'NombreProducto' => null,
                    'DescripcionProducto' => null,
                    'IdAccesorio' => $data['aIdAccesorio'],
                    'NombreAccesorio' => $data['NombreAccesorio'],
                    'DescripcionAccesorio' => $data['DescripcionAccesorio'],
                    'TipoInsumo' => $data['TipoInsumo']
                );   
            } 

        }

        $i++;
    }

    return $Listado;
}




// EMITIR LISTADO con todos los pedidos realizados a un proveedor particular
function Listar_PedidosProveedoresSegunProveedor($conexion, $idProveedorRecibido) {

    $idProveedor = $idProveedorRecibido;
    $Listado = array();

    $SQL = "SELECT pp.idPedido as ppIdPedido,
                   pp.fechaPedido as FechaPedido,
                   pp.fechaEntregaPedido as FechaEntrega,
                   pp.idProveedor as ppIdProveedor,
                   pp.idEstadoPedido as ppIdEstadoPedido,
                   pp.aclaracionesEstadoPedido as AclaracionesEstadoPedido,
                   pp.condicionesDeEntrega as CondicionesDeEntrega,
                   pp.totalPedido as TotalPedido,

                   dp.idDetallePedidoAProveedor as IdDetallePedido,
                   dp.idPedido as dpIdPedido,
                   dp.precioPorUnidad as PrecioPorUnidad,
                   dp.cantidadUnidades as CantidadUnidades,
                   dp.subtotal as Subtotal, 
                   dp.idRepuestoVehiculo as dpIdRepuesto,
                   dp.idProductoVehiculo as dpIdProducto,
                   dp.idAccesorioVehiculo as dpIdAccesorio,

                   r.idRepuesto as rIdRepuesto,
                   r.nombreRepuesto as NombreRepuesto,
                   r.descripcionRepuesto as DescripcionRepuesto,
                   r.idTipoInsumo as rIdTipoInsumo,

                   i.idTipoInsumo as iIdTipoInsumo,
                   i.tipoInsumo as TipoInsumo,

                   p.idProducto as pIdProducto,
                   p.nombreProducto as NombreProducto,
                   p.descripcionProducto as DescripcionProducto,
                   p.idTipoInsumo as pIdTipoInsumo, 

                   a.idAccesorio as aIdAccesorio,
                   a.nombreAccesorio as NombreAccesorio,
                   a.descripcionAccesorio as DescripcionAccesorio,
                   a.idTipoInsumo as aIdTipoInsumo,

                   pv.idProveedor as IdProveedor,
                   pv.nombreProveedor as NombreProveedor,
                   pv.mailProveedor as MailProveedor,
                   pv.direccionProveedor as DireccionProveedor,
                   pv.telefonoProveedor as TelProveedor,
                   pv.localidadProveedor as LocalidadProveedor,
                   pv.cuitProveedor as CuitProveedor,
                   pv.ivaProveedor as IvaProveedor,

                   e.idEstadoPedido as IdEstadoPedido, 
                   e.estadoPedido as EstadoPedido 
            FROM `pedido-a-proveedor` pp
            INNER JOIN `detalle-pedidoaproveedor` dp ON pp.idPedido = dp.idPedido
            LEFT JOIN `repuestos-vehiculos` r ON dp.idRepuestoVehiculo = r.idRepuesto
            LEFT JOIN `productos-vehiculo` p ON dp.idProductoVehiculo = p.idProducto
            LEFT JOIN `accesorios-vehiculos` a ON dp.idAccesorioVehiculo = a.idAccesorio
            LEFT JOIN `tipo-insumo` i ON (i.idTipoInsumo = r.idTipoInsumo OR i.idTipoInsumo = p.idTipoInsumo OR i.idTipoInsumo = a.idTipoInsumo)
            INNER JOIN `proveedores` pv ON pp.idProveedor = pv.idProveedor
            INNER JOIN `estados-pedidoaproveedor` e ON pp.idEstadoPedido = e.idEstadoPedido
            WHERE pp.idProveedor = $idProveedor 
            ORDER BY pp.fechaPedido DESC, pp.idPedido DESC, dp.idDetallePedidoAProveedor ASC; ";

    $rs = mysqli_query($conexion, $SQL);
        
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {

        $ppIdPedido = $data['ppIdPedido'];
        $dpIdDetalle = $data['IdDetallePedido'];

        // Verificar si ya existe el pedido
        if (!isset($Listado[$ppIdPedido])) {

            $Listado[$ppIdPedido] = array(
                'ppIdPedido' => $data['ppIdPedido'],
                'FechaPedido' => $data['FechaPedido'],
                'FechaEntrega' => $data['FechaEntrega'],

                'EstadoPedido' => $data['EstadoPedido'],
                'AclaracionesEstadoPedido' => $data['AclaracionesEstadoPedido'],
                'CondicionesDeEntrega' => $data['CondicionesDeEntrega'],

                'NombreProveedor' => $data['NombreProveedor'],
                'MailProveedor' => $data['MailProveedor'],
                'DireccionProveedor' => $data['DireccionProveedor'],
                'TelProveedor' => $data['TelProveedor'],
                'LocalidadProveedor' => $data['LocalidadProveedor'],
                'CuitProveedor' => $data['CuitProveedor'],
                'IvaProveedor' => $data['IvaProveedor'],

                'TotalPedido' => $data['TotalPedido'],
                'Detalles' => array()
            );
        }

        // Verificar si ya existe el detalle
        if (!isset($Listado[$ppIdPedido]['Detalles'][$dpIdDetalle])) {

            // Si es repuesto
            if ($data['iIdTipoInsumo'] == 1) {

                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => $data['rIdRepuesto'],
                    'NombreRepuesto' => $data['NombreRepuesto'],
                    'DescripcionRepuesto' => $data['DescripcionRepuesto'],
                    'IdProducto' => null,
                    'NombreProducto' => null,
                    'DescripcionProducto' => null,
                    'IdAccesorio' => null,
                    'NombreAccesorio' => null,
                    'DescripcionAccesorio' => null,
                    'TipoInsumo' => $data['TipoInsumo']
                );
            }

            // Si es producto
            elseif ($data['iIdTipoInsumo'] == 2) {
                
                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => null,
                    'NombreRepuesto' => null,
                    'DescripcionRepuesto' => null,
                    'IdProducto' => $data['pIdProducto'],
                    'NombreProducto' => $data['NombreProducto'],
                    'DescripcionProducto' => $data['DescripcionProducto'],
                    'IdAccesorio' => null,
                    'NombreAccesorio' => null,
                    'DescripcionAccesorio' => null,
                    'TipoInsumo' => $data['TipoInsumo']
                );
            }

            // Si es accesorio
            elseif ($data['iIdTipoInsumo'] == 3) {
                                 
                $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                    'IdDetallePedido' => $data['IdDetallePedido'],
                    'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                    'CantidadUnidades' => $data['CantidadUnidades'],
                    'Subtotal' => $data['Subtotal'],
                    'IdRepuesto' => null,
                    'NombreRepuesto' => null,
                    'DescripcionRepuesto' => null,
                    'IdProducto' => null,
                    'NombreProducto' => null,
                    'DescripcionProducto' => null,
                    'IdAccesorio' => $data['aIdAccesorio'],
                    'NombreAccesorio' => $data['NombreAccesorio'],
                    'DescripcionAccesorio' => $data['DescripcionAccesorio'],
                    'TipoInsumo' => $data['TipoInsumo']
                );   
            } 

        }

        $i++;
    }

    return $Listado;
}


?>