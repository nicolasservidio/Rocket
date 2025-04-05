<?php

// EMITIR LISTADO con todas las entregas de vehículos
function Listar_Entregas($conexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT e.idEntrega as eIdEntrega,
                   e.fechaEntrega as eFechaEntrega,
                   e.horaEntrega as eHoraEntrega,
                   e.idCliente as eIdCliente,
                   e.idContrato as eIdContrato,

                   c.idContrato as cIdContrato, 
                   c.fechaInicioContrato as cFechaInicioContrato, 
                   c.fechaFinContrato as cFechaFinContrato, 
                   c.fechaEntrega as cFechaEntrega, 
                   c.fechaDevolucion as cFechaDevolucion, 
                   c.idCliente as cIdCliente, 
                   c.idVehiculo as cIdVehiculo, 
                   c.idVendedor as cIdVendedor, 
                   c.idDetalleContrato as cIdDetalleContrato, 
                   c.idEstadoContrato as cIdEstadoContrato,

                   cl.idCliente as clIdCliente,
                   cl.nombreCliente as clNombreCliente,
                   cl.apellidoCliente as clApellidoCliente,
                   cl.dniCliente as clDniCliente,

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
            FROM `entregas-vehiculos` e, `contratos-alquiler` c, clientes cl, vehiculos v, modelos m, `grupos-vehiculos` g, `detalle-contratos` dc, `estados-contratos` ec, sucursales s   
            WHERE e.idCliente = cl.idCliente 
            AND e.idContrato = c.idContrato 
            AND c.idCliente = cl.idCliente 
            AND c.idVehiculo = v.idVehiculo 
            AND v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            AND v.idSucursal = s.idSucursal 
            AND c.idDetalleContrato = dc.idDetalleContrato
            AND c.idEstadoContrato = ec.idEstadoContrato 
            ORDER BY e.fechaEntrega, e.horaEntrega, cl.apellidoCliente, cl.nombreCliente, cl.dniCliente; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
    $rs = mysqli_query($conexion, $SQL);
        
    //3) el resultado deberá organizarse en una matriz, entonces lo recorro
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdEntrega'] = $data['eIdEntrega'];
            $Listado[$i]['FechaEntrega'] = $data['eFechaEntrega'];
            $Listado[$i]['HoraEntrega'] = $data['eHoraEntrega'];

            $Listado[$i]['IdContrato'] = $data['eIdContrato'];
            $Listado[$i]['FechaInicioContrato'] = $data['cFechaInicioContrato'];
            $Listado[$i]['FechaFinContrato'] = $data['cFechaFinContrato'];
            $Listado[$i]['IdDetalleContrato'] = $data['cIdDetalleContrato'];
            $Listado[$i]['PrecioPorDiaContrato'] = $data['dcPrecioPorDiaContrato'];
            $Listado[$i]['CantidadDiasContrato'] = $data['dcCantidadDiasContrato'];
            $Listado[$i]['MontoTotalContrato'] = $data['dcMontoTotalContrato'];
            $Listado[$i]['IdEstadoContrato'] = $data['cIdEstadoContrato'];
            $Listado[$i]['EstadoContrato'] = $data['ecEstadoContrato'];

            $Listado[$i]['IdCliente'] = $data['eIdCliente'];
            $Listado[$i]['nombreCliente'] = $data['clNombreCliente'];
            $Listado[$i]['apellidoCliente'] = $data['clApellidoCliente'];
            $Listado[$i]['dniCliente'] = $data['clDniCliente'];

            $Listado[$i]['IdVehiculo'] = $data['cIdVehiculo'];
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


function Procesar_ConsultaEntregas() {

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

    // Se cambia formato de las fechas:
    $fechaEspanol = $_GET['EntregaDesde'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['EntregaDesde'] = $fechaIngles;

    $fechaEspanol = $_GET['EntregaHasta'];
    $fechaEspanol = date_parse($fechaEspanol);
    $year = $fechaEspanol['year'];
    $mo = $fechaEspanol['month'];
    $day = $fechaEspanol['day'];
    $fechaIngles = "$year/$mo/$day";
    $_GET['EntregaHasta'] = $fechaIngles;

}


function Consulta_Entregas($numContrato, $matricula, $apellido, $nombre, $dni, $entregaDesde, $entregaHasta, $conexion) {

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

    if (empty($entregaDesde)) {
        $entregaDesde = "ZZZZZZ";
    }
    if (empty($entregaHasta)) {
        $entregaHasta = "ZZZZZZ";
    }

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT e.idEntrega as eIdEntrega,
                   e.fechaEntrega as eFechaEntrega,
                   e.horaEntrega as eHoraEntrega,
                   e.idCliente as eIdCliente,
                   e.idContrato as eIdContrato,

                    ca.idContrato as caIdContrato, 
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

            FROM `entregas-vehiculos` e, `contratos-alquiler` ca, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g, `detalle-contratos` dc, `estados-contratos` ec, sucursales s 
            WHERE e.idCliente = c.idCliente 
            AND e.idContrato = ca.idContrato 
            AND ca.idCliente = c.idCliente 
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
                OR (e.fechaEntrega BETWEEN '$entregaDesde%' AND '$entregaHasta%')) 
            ORDER BY e.fechaEntrega, e.horaEntrega, c.apellidoCliente, c.nombreCliente, c.dniCliente; ";


    $rs = mysqli_query($conexion, $SQL);
        
    // El resultado debe organizarse en una matriz, entonces lo recorro:
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IdEntrega'] = $data['eIdEntrega'];
        $Listado[$i]['FechaEntrega'] = $data['eFechaEntrega'];
        $Listado[$i]['HoraEntrega'] = $data['eHoraEntrega'];

        $Listado[$i]['IdContrato'] = $data['eIdContrato'];
        $Listado[$i]['FechaInicioContrato'] = $data['caFechaInicioContrato'];
        $Listado[$i]['FechaFinContrato'] = $data['caFechaFinContrato'];

        $Listado[$i]['IdDetalleContrato'] = $data['caIdDetalleContrato'];
        $Listado[$i]['PrecioPorDiaContrato'] = $data['dcPrecioPorDiaContrato'];
        $Listado[$i]['CantidadDiasContrato'] = $data['dcCantidadDiasContrato'];
        $Listado[$i]['MontoTotalContrato'] = $data['dcMontoTotalContrato'];

        $Listado[$i]['IdEstadoContrato'] = $data['caIdEstadoContrato'];
        $Listado[$i]['EstadoContrato'] = $data['ecEstadoContrato'];

        $Listado[$i]['IdCliente'] = $data['eIdCliente'];
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


// EMITIR LISTADO con todas las entregas de vehículos asociadas a un cliente
function Listar_EntregasSegunCliente($idCliente, $conexion) {

    $IdCliente = $idCliente;
    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT e.idEntrega as eIdEntrega,
                   e.fechaEntrega as eFechaEntrega,
                   e.horaEntrega as eHoraEntrega,
                   e.idCliente as eIdCliente,
                   e.idContrato as eIdContrato,

                   c.idContrato as cIdContrato, 
                   c.fechaInicioContrato as cFechaInicioContrato, 
                   c.fechaFinContrato as cFechaFinContrato, 
                   c.fechaEntrega as cFechaEntrega, 
                   c.fechaDevolucion as cFechaDevolucion, 
                   c.idCliente as cIdCliente, 
                   c.idVehiculo as cIdVehiculo, 
                   c.idVendedor as cIdVendedor, 
                   c.idDetalleContrato as cIdDetalleContrato, 
                   c.idEstadoContrato as cIdEstadoContrato,

                   cl.idCliente as clIdCliente,
                   cl.nombreCliente as clNombreCliente,
                   cl.apellidoCliente as clApellidoCliente,
                   cl.dniCliente as clDniCliente,

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
            FROM `entregas-vehiculos` e, `contratos-alquiler` c, clientes cl, vehiculos v, modelos m, `grupos-vehiculos` g, `detalle-contratos` dc, `estados-contratos` ec, sucursales s   
            WHERE e.idCliente = cl.idCliente 
            AND e.idContrato = c.idContrato 
            AND c.idCliente = cl.idCliente 
            AND c.idVehiculo = v.idVehiculo 
            AND v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            AND v.idSucursal = s.idSucursal 
            AND c.idDetalleContrato = dc.idDetalleContrato
            AND c.idEstadoContrato = ec.idEstadoContrato 
            AND e.idCliente = $IdCliente 
            ORDER BY e.fechaEntrega, e.horaEntrega, cl.apellidoCliente, cl.nombreCliente, cl.dniCliente; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
    $rs = mysqli_query($conexion, $SQL);
        
    //3) el resultado deberá organizarse en una matriz, entonces lo recorro
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdEntrega'] = $data['eIdEntrega'];
            $Listado[$i]['FechaEntrega'] = $data['eFechaEntrega'];
            $Listado[$i]['HoraEntrega'] = $data['eHoraEntrega'];

            $Listado[$i]['IdContrato'] = $data['eIdContrato'];
            $Listado[$i]['FechaInicioContrato'] = $data['cFechaInicioContrato'];
            $Listado[$i]['FechaFinContrato'] = $data['cFechaFinContrato'];
            $Listado[$i]['IdDetalleContrato'] = $data['cIdDetalleContrato'];
            $Listado[$i]['PrecioPorDiaContrato'] = $data['dcPrecioPorDiaContrato'];
            $Listado[$i]['CantidadDiasContrato'] = $data['dcCantidadDiasContrato'];
            $Listado[$i]['MontoTotalContrato'] = $data['dcMontoTotalContrato'];
            $Listado[$i]['IdEstadoContrato'] = $data['cIdEstadoContrato'];
            $Listado[$i]['EstadoContrato'] = $data['ecEstadoContrato'];

            $Listado[$i]['IdCliente'] = $data['eIdCliente'];
            $Listado[$i]['nombreCliente'] = $data['clNombreCliente'];
            $Listado[$i]['apellidoCliente'] = $data['clApellidoCliente'];
            $Listado[$i]['dniCliente'] = $data['clDniCliente'];

            $Listado[$i]['IdVehiculo'] = $data['cIdVehiculo'];
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