<?php

// EMITIR LISTADO con todas las Reservas
function Listar_Reservas($conexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT r.idReserva as rIdReserva, 
                   r.numeroReserva as rNumeroReserva, 
                   r.fechaReserva as rFechaReserva, 
                   r.fechaInicioReserva as rFechaInicioReserva, 
                   r.FechaFinReserva as rFechaFinReserva, 
                   r.precioPorDiaReserva as rPrecioPorDiaReserva, 
                   r.cantidadDiasReserva as rCantidadDiasReserva, 
                   r.totalReserva as rTotalReserva, 
                   r.idCliente as rIdCliente, 
                   r.idContrato as rIdContrato,
                   r.idSucursal as rIdSucursal,
                   r.idVehiculo as rIdVehiculo,
                   c.idCliente as cIdCliente,
                   c.nombreCliente as cNombreCliente,
                   c.apellidoCliente as cApellidoCliente,
                   c.dniCliente as cDniCliente,
                   v.idVehiculo as vIdVehiculo,
                   v.matricula as vMatricula,
                   v.idModelo as vIdModelo,
                   v.idGrupoVehiculo as vIdGrupoVehiculo,
                   m.idModelo as  mIdModelo,
                   m.nombreModelo as mNombreModelo,
                   g.idGrupo as gIdGrupo,
                   g.nombreGrupo as gNombreGrupo 
            FROM `reservas-vehiculos` r, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g 
            WHERE r.idCliente = c.idCliente 
            AND r.idVehiculo = v.idVehiculo 
            AND v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            ORDER BY r.numeroReserva, c.apellidoCliente, c.nombreCliente; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
    $rs = mysqli_query($conexion, $SQL);
        
    //3) el resultado deberá organizarse en una matriz, entonces lo recorro
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['idReserva'] = $data['rIdReserva'];
            $Listado[$i]['numeroReserva'] = $data['rNumeroReserva'];
            $Listado[$i]['fechaReserva'] = $data['rFechaReserva'];
            $Listado[$i]['fechaInicioReserva'] = $data['rFechaInicioReserva'];
            $Listado[$i]['fechaFinReserva'] = $data['rFechaFinReserva'];
            $Listado[$i]['precioPorDiaReserva'] = $data['rPrecioPorDiaReserva'];
            $Listado[$i]['cantidadDiasReserva'] = $data['rCantidadDiasReserva'];
            $Listado[$i]['totalReserva'] = $data['rTotalReserva'];
            $Listado[$i]['idSucursal'] = $data['rIdSucursal'];            
            $Listado[$i]['idContrato'] = $data['rIdContrato'];            
            $Listado[$i]['idCliente'] = $data['rIdCliente'];
            $Listado[$i]['apellidoCliente'] = $data['cApellidoCliente'];
            $Listado[$i]['nombreCliente'] = $data['cNombreCliente'];
            $Listado[$i]['dniCliente'] = $data['cDniCliente'];
            $Listado[$i]['vehiculoMatricula'] = $data['vMatricula'];
            $Listado[$i]['vehiculoGrupo'] = $data['gNombreGrupo'];
            $Listado[$i]['vehiculoModelo'] = $data['mNombreModelo'];
            
            $i++;
    }

    return $Listado;

}

?>