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
            ORDER BY pp.fechaPedido, pp.idPedido, dp.idDetallePedidoAProveedor; ";

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

            $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle] = array(
                'IdDetallePedido' => $data['IdDetallePedido'],
                'PrecioPorUnidad' => $data['PrecioPorUnidad'],
                'CantidadUnidades' => $data['CantidadUnidades'],
                'Subtotal' => $data['Subtotal'],
                'Repuestos' => array(),
                'Productos' => array(),
                'Accesorios' => array()
            );
        }

        // Agregar datos de repuestos, productos y accesorios al detalle correspondiente

        if (!empty($data['IdRepuesto'])) {

            $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle]['Repuestos'] = array(
                'IdRepuesto' => $data['IdRepuesto'],
                'NombreRepuesto' => $data['NombreRepuesto'],
                'DescripcionRepuesto' => $data['DescripcionRepuesto'],
                'TipoInsumo' => $data['TipoInsumo']
            );
        }

        if (!empty($data['IdProducto'])) {

            $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle]['Productos'] = array(
                'IdProducto' => $data['IdProducto'],
                'NombreProducto' => $data['NombreProducto'],
                'DescripcionProducto' => $data['DescripcionProducto'],
                'TipoInsumo' => $data['TipoInsumo']
            );
        }

        if (!empty($data['IdAccesorio'])) {

            $Listado[$ppIdPedido]['Detalles'][$dpIdDetalle]['Accesorios'] = array(
                'IdAccesorio' => $data['IdAccesorio'],
                'NombreAccesorio' => $data['NombreAccesorio'],
                'DescripcionAccesorio' => $data['DescripcionAccesorio'],
                'TipoInsumo' => $data['TipoInsumo']
            );
        }

    }

    return $Listado;
}




function Procesar_ConsultaContratos() {

    $_GET['NumeroContrato'] = trim($_GET['NumeroContrato']);
    $_GET['NumeroContrato'] = strip_tags($_GET['NumeroContrato']);

    $_GET['MatriculaContrato'] = trim($_GET['MatriculaContrato']);
    $_GET['MatriculaContrato'] = strip_tags($_GET['MatriculaContrato']);

    $_GET['ApellidoContrato'] = trim($_GET['ApellidoContrato']);
    $_GET['ApellidoContrato'] = strip_tags($_GET['ApellidoContrato']);

    $_GET['NombreContrato'] = trim($_GET['NombreContrato']);
    $_GET['NombreContrato'] = strip_tags($_GET['NombreContrato']);

    $_GET['DocContrato'] = trim($_GET['DocContrato']);
    $_GET['DocContrato'] = strip_tags($_GET['DocContrato']);

    $_GET['EstadoContrato'] = trim($_GET['EstadoContrato']);
    $_GET['EstadoContrato'] = strip_tags($_GET['EstadoContrato']);

    $_GET['PrecioDiaContrato'] = trim($_GET['PrecioDiaContrato']);
    $_GET['PrecioDiaContrato'] = strip_tags($_GET['PrecioDiaContrato']);

    $_GET['CantidadDiasContrato'] = trim($_GET['CantidadDiasContrato']);
    $_GET['CantidadDiasContrato'] = strip_tags($_GET['CantidadDiasContrato']);

    $_GET['MontoTotalContrato'] = trim($_GET['MontoTotalContrato']);
    $_GET['MontoTotalContrato'] = strip_tags($_GET['MontoTotalContrato']);

    // Se cambia formato de las fechas:
    $fechaEspanol = $_GET['RetiroDesde'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['RetiroDesde'] = $fechaIngles;

    $fechaEspanol = $_GET['RetiroHasta'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['RetiroHasta'] = $fechaIngles;

    $fechaEspanol = $_GET['DevolucionDesde'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['DevolucionDesde'] = $fechaIngles;

    $fechaEspanol = $_GET['DevolucionHasta'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['DevolucionHasta'] = $fechaIngles;

}


function Consulta_Contratos($numContrato, $matricula, $apellido, $nombre, $dni, $estadoContrato, $precioDia, $cantidadDias, $montoTotal, $retiroDesde, $retiroHasta, $devolucionDesde, $devolucionHasta, $conexion) {

    if (empty($numContrato)) {
        $numContrato = "ZZZZZZ";
    }
    if (empty($matricula)) {
        $matricula = "&&&&&&";
    }
    if (empty($apellido)) {
        $apellido = "9999999";
    }
    if (empty($nombre)) {
        $nombre = "9999999";
    }
    if (empty($dni)) {
        $dni = "ZZZZZZ";
    }
    if (empty($estadoContrato)) {
        $estadoContrato = "9999999";
    }

    if (empty($precioDia)) {
        $precioDia = "0";
    }
    if (empty($cantidadDias)) {
        $cantidadDias = "0";
    }
    if (empty($montoTotal)) {
        $montoTotal = "0";
    }

    if (empty($retiroDesde)) {
        $retiroDesde = "ZZZZZZ";
    }
    if (empty($retiroHasta)) {
        $retiroHasta = "ZZZZZZ";
    }
    if (empty($devolucionDesde)) {
        $devolucionDesde = "ZZZZZZ";
    }
    if (empty($devolucionHasta)) {
        $devolucionHasta = "ZZZZZZ";
    }

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT ca.idContrato as caIdContrato, 
                    ca.fechaInicioContrato as caFechaInicioContrato, 
                    ca.fechaFinContrato as caFechaFinContrato, 
                    ca.idCliente as caIdCliente, 
                    ca.idVehiculo as caIdVehiculo, 
                    ca.idDetalleContrato as caIdDetalleContrato, 
                    ca.idEstadoContrato as caIdEstadoContrato, 

                    c.idCliente as cIdCliente, 
                    c.nombreCliente as cNombreCliente, 
                    c.apellidoCliente as cApellidoCliente, 
                    c.dniCliente as cDniCliente, 

                    v.idVehiculo as vIdVehiculo,
                    v.matricula as vMatricula,
                    v.idModelo as vIdModelo,
                    v.idGrupoVehiculo as vIdGrupoVehiculo,
                    v.idSucursal as vIdSucursal, 

                    m.idModelo as  mIdModelo,
                    m.nombreModelo as mNombreModelo,
                    g.idGrupo as gIdGrupo,
                    g.nombreGrupo as gNombreGrupo, 

                    s.idSucursal as sIdSucursal, 
                    s.direccionSucursal as sDireccionSucursal, 
                    s.ciudadSucursal as sCiudadSucursal, 

                    dc.idDetalleContrato as dcIdDetalleContrato, 
                    dc.precioPorDiaContrato as dcPrecioPorDiaContrato, 
                    dc.cantidadDiasContrato as dcCantidadDiasContrato, 
                    dc.montoTotalContrato as dcMontoTotalContrato,

                    ec.idEstadoContrato as ecIdEstadoContrato,
                    ec.estadoContrato as ecEstadoContrato 

            FROM `contratos-alquiler` ca, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g, `detalle-contratos` dc, `estados-contratos` ec, sucursales s 
            WHERE ca.idCliente = c.idCliente 
            AND ca.idVehiculo = v.idVehiculo  
            AND v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            AND v.idSucursal = s.idSucursal 
            AND ca.idDetalleContrato = dc.idDetalleContrato 
            AND ca.idEstadoContrato = ec.idEstadoContrato 
            AND (ca.idContrato = '$numContrato%' 
                OR v.matricula LIKE '$matricula%' 
                OR c.apellidoCliente LIKE '$apellido%' 
                OR c.nombreCliente LIKE '$nombre%' 
                OR c.dniCliente LIKE '$dni%' 
                OR ec.estadoContrato LIKE '$estadoContrato%' 
                OR dc.precioPorDiaContrato <= '$precioDia' 
                OR dc.cantidadDiasContrato = '$cantidadDias' 
                OR dc.montoTotalContrato <= '$montoTotal' 
                OR (ca.fechaInicioContrato BETWEEN '$retiroDesde%' AND '$retiroHasta%') 
                OR (ca.fechaFinContrato BETWEEN '$devolucionDesde%' AND '$devolucionHasta%')) 
            ORDER BY ca.fechaInicioContrato, ca.fechaFinContrato, c.apellidoCliente, c.nombreCliente, c.dniCliente; ";


    $rs = mysqli_query($conexion, $SQL);
        
    // El resultado debe organizarse en una matriz, entonces lo recorro:
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IdContrato'] = $data['caIdContrato'];
        $Listado[$i]['FechaInicioContrato'] = $data['caFechaInicioContrato'];
        $Listado[$i]['FechaFinContrato'] = $data['caFechaFinContrato'];

        $Listado[$i]['IdDetalleContrato'] = $data['caIdDetalleContrato'];
        $Listado[$i]['PrecioPorDiaContrato'] = $data['dcPrecioPorDiaContrato'];
        $Listado[$i]['CantidadDiasContrato'] = $data['dcCantidadDiasContrato'];
        $Listado[$i]['MontoTotalContrato'] = $data['dcMontoTotalContrato'];

        $Listado[$i]['IdEstadoContrato'] = $data['caIdEstadoContrato'];
        $Listado[$i]['EstadoContrato'] = $data['ecEstadoContrato'];

        $Listado[$i]['IdCliente'] = $data['caIdCliente'];
        $Listado[$i]['nombreCliente'] = $data['cNombreCliente'];
        $Listado[$i]['apellidoCliente'] = $data['cApellidoCliente'];
        $Listado[$i]['dniCliente'] = $data['cDniCliente'];

        $Listado[$i]['IdVehiculo'] = $data['caIdVehiculo'];
        $Listado[$i]['vehiculoMatricula'] = $data['vMatricula'];            
        $Listado[$i]['IdModelo'] = $data['vIdModelo'];
        $Listado[$i]['vehiculoModelo'] = $data['mNombreModelo'];
        $Listado[$i]['IdGrupoVehiculo'] = $data['vIdGrupoVehiculo'];
        $Listado[$i]['vehiculoGrupo'] = $data['gNombreGrupo'];
        
        $Listado[$i]['IdSucursal'] = $data['vIdSucursal'];
        $Listado[$i]['DireccionSucursal'] = $data['sDireccionSucursal'];
        $Listado[$i]['CiudadSucursal'] = $data['sCiudadSucursal'];
            
        $i++;
    }

    return $Listado;
}

?>