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
            
            $Listado[$i]['ContratoAsociado'] = " ";
            $Listado[$i]['ContratoColorAdvertencia'] = " ";
            if (is_null($Listado[$i]['idContrato'])) {
                $Listado[$i]['ContratoAsociado'] = "No registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "danger";
                $Listado[$i]['idContrato'] = "No existe";
            }
            else {
                $Listado[$i]['ContratoAsociado'] = "Registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "success";
            }

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

function Procesar_ConsultaReservas() {

    $_GET['NumeroReserva'] = trim($_GET['NumeroReserva']);
    $_GET['NumeroReserva'] = strip_tags($_GET['NumeroReserva']);

    $_GET['MatriculaReserva'] = trim($_GET['MatriculaReserva']);
    $_GET['MatriculaReserva'] = strip_tags($_GET['MatriculaReserva']);

    $_GET['ApellidoReserva'] = trim($_GET['ApellidoReserva']);
    $_GET['ApellidoReserva'] = strip_tags($_GET['ApellidoReserva']);

    $_GET['NombreReserva'] = trim($_GET['NombreReserva']);
    $_GET['NombreReserva'] = strip_tags($_GET['NombreReserva']);

    $_GET['DocReserva'] = trim($_GET['DocReserva']);
    $_GET['DocReserva'] = strip_tags($_GET['DocReserva']);

    // Se cambia formato de las fechas:
    // Es mejor hacerlo de este modo que de la forma especificada inicialmente:
    if (!empty($_GET['RetiroDesde'])) {
        $_GET['RetiroDesde'] = date("Y-m-d", strtotime($_GET['RetiroDesde']));
    } 
    if (!empty($_GET['RetiroHasta'])) {
        $_GET['RetiroHasta'] = date("Y-m-d", strtotime($_GET['RetiroHasta']));
    } 

}


function Consulta_Reservas($numReserva, $matricula, $apellido, $nombre, $dni, $retiroDesde, $retiroHasta, $conexion) {

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
            AND v.idGrupoVehiculo = g.idGrupo ";

            // Concateno el resto de la consulta para poder agregar condicionales
            if (!empty($numReserva)) {
                $SQL .= " AND r.numeroReserva = '$numReserva' ";
            }
            if (!empty($matricula)) {
                $SQL .= " AND v.matricula LIKE '$matricula%' ";
            }
            if (!empty($apellido)) {
                $SQL .= " AND c.apellidoCliente LIKE '%$apellido%' ";
            }
            if (!empty($nombre)) {
                $SQL .= " AND c.nombreCliente LIKE '%$nombre%' ";
            }
            if (!empty($dni)) {
                $SQL .= " AND c.dniCliente LIKE '$dni%' ";
            }

            if (!empty($retiroDesde)) {
                $SQL .= " AND r.fechaInicioReserva >= '$retiroDesde' ";
            }
            if (!empty($retiroHasta)) {
                $SQL .= " AND r.fechaInicioReserva <= '$retiroHasta' ";
            }

            // Agrego el orden a la consulta sql
            $SQL .= " ORDER BY r.fechaInicioReserva, c.apellidoCliente, c.nombreCliente, r.numeroReserva; "; 


    $rs = mysqli_query($conexion, $SQL);
        
    // El resultado debe organizarse en una matriz, entonces lo recorro:
    $i = 0;
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

            $Listado[$i]['ContratoAsociado'] = " ";
            $Listado[$i]['ContratoColorAdvertencia'] = " ";
            if (is_null($Listado[$i]['idContrato'])) {
                $Listado[$i]['ContratoAsociado'] = "No registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "danger";
                $Listado[$i]['idContrato'] = "No existe";
            }
            else {
                $Listado[$i]['ContratoAsociado'] = "Registrado";
                $Listado[$i]['ContratoColorAdvertencia'] = "success";
            }

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




// No estamos usándolo en ningún lado mepa, al final seguimos otra estrategia
function Corroborar_FechasReserva($fecharetiro, $fechadevolucion) {
 
    $Fecha_actual = date("y-m-d");
    $Fecha_manana = date("y-m-d",strtotime($Fecha_actual."+ 1 day"));

    if ($fecharetiro <= $Fecha_actual || $fechadevolucion <= $Fecha_actual) {
        return false; 
    } 
    elseif ($fecharetiro < $fechadevolucion) {
        return false;
    }
    else {
        return true;
    }

}

?>