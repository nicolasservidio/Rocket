<?php

function Listar_Vehiculos($conexion) {

    $Listado = array();

    // Genero la consulta que deseo
    $SQL = "SELECT v.idVehiculo as vID,
                   v.matricula as vMatricula, 
                   v.color as vColor,
                   v.fechaCompra as vFechaCompra,
                   v.precioCompra as vPrecioCompra,
                   v.anio as vAnio,
                   v.numeroMotor as vNumeroMotor,
                   v.numeroChasis as vNumeroChasis,
                   v.puertas as vNumeroPuertas,
                   v.asientos as vNumeroAsientos,
                   v.esAutomatico as vAutomatico,
                   v.aireAcondicionado as vAire,
                   v.dirHidraulica as vHidraulica,
                   v.estadoFisicoDelVehiculo as vEstadoFisico,
                   v.disponibilidad as vDisponibilidad,
                   v.kilometraje as vKilometraje,
                   v.idModelo,
                   v.idCombustible,
                   v.idGrupoVehiculo,
                   v.idSucursal,
                   m.idModelo,
                   m.nombreModelo as vModelo,
                   m.descripcionModelo as vDescripcionModelo,
                   c.idCombustible,
                   c.tipoCombustible as vCombustible,
                   g.idGrupo,
                   g.nombreGrupo as vGrupo,
                   g.descripcionGrupo as vDescripcionGrupo,
                   s.idSucursal,
                   s.numeroSucursal as vSucursal,
                   s.direccionSucursal as vSucursalDireccion,
                   s.ciudadSucursal as vSucursalCiudad,
                   s.telefonoSucursal as vSucursalTel
            FROM vehiculos v, modelos m, combustibles c, `grupos-vehiculos` g, sucursales s
            WHERE m.idModelo = v.idModelo  
            AND c.idCombustible = v.idCombustible 
            AND g.idGrupo = v.idGrupoVehiculo
            AND s.idSucursal = v.idSucursal 
            ORDER BY v.matricula, m.nombreModelo; ";

    $rs = mysqli_query($conexion, $SQL);
        
    // El resultado debe organizarse en una matriz, entonces lo recorro:
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['vID'] = $data['vID'];
            $Listado[$i]['vMatricula'] = $data['vMatricula'];
            $Listado[$i]['vColor'] = $data['vColor'];
            $Listado[$i]['vFechaCompra'] = $data['vFechaCompra'];
            $Listado[$i]['vPrecioCompra'] = $data['vPrecioCompra'];
            $Listado[$i]['vAnio'] = $data['vAnio'];
            $Listado[$i]['vNumeroMotor'] = $data['vNumeroMotor'];
            $Listado[$i]['vNumeroChasis'] = $data['vNumeroChasis'];
            $Listado[$i]['vNumeroPuertas'] = $data['vNumeroPuertas'];
            $Listado[$i]['vNumeroAsientos'] = $data['vNumeroAsientos'];

            $Listado[$i]['vAutomatico'] = $data['vAutomatico'];
            if ($Listado[$i]['vAutomatico'] == "S") {
                $Listado[$i]['vAutomatico'] = "Es automático";
            }
            else {
                $Listado[$i]['vAutomatico'] = "No automático";
            }

            $Listado[$i]['vAire'] = $data['vAire'];
            if ($Listado[$i]['vAire'] == "S") {
                $Listado[$i]['vAire'] = "Con aire acondicionado";
            }
            else {
                $Listado[$i]['vAire'] = "Sin aire acondicionado";
            }

            $Listado[$i]['vHidraulica'] = $data['vHidraulica'];
            if ($Listado[$i]['vHidraulica'] == "S") {
                $Listado[$i]['vHidraulica'] = "Con dir. hidráulica";
            }
            else {
                $Listado[$i]['vHidraulica'] = "Sin dir. hidráulica";
            }            

            $Listado[$i]['vEstadoFisico'] = $data['vEstadoFisico'];
            $Listado[$i]['vDisponibilidad'] = $data['vDisponibilidad'];

            if ($Listado[$i]['vDisponibilidad'] == "S") {
                $Listado[$i]['vDisponibilidad'] = "Sí";
            }
            else {
                $Listado[$i]['vDisponibilidad'] = "No";
            }

            $Listado[$i]['vKilometraje'] = $data['vKilometraje'];
            $Listado[$i]['vModelo'] = $data['vModelo'];
            $Listado[$i]['vDescripcionModelo'] = $data['vDescripcionModelo'];
            $Listado[$i]['vCombustible'] = $data['vCombustible'];

            if (is_null($data['vCombustible'])) {
                $Listado[$i]['vCombustible'] = "A definir.";
            }

            $Listado[$i]['vGrupo'] = $data['vGrupo'];
            $Listado[$i]['vDescripcionGrupo'] = $data['vDescripcionGrupo'];
            $Listado[$i]['vSucursal'] = $data['vSucursal'];
            $Listado[$i]['vSucursalDireccion'] = $data['vSucursalDireccion'];
            $Listado[$i]['vSucursalCiudad'] = $data['vSucursalCiudad'];
            $Listado[$i]['vSucursalTel'] = $data['vSucursalTel'];

            if (is_null($data['vSucursalDireccion'])) {
                $Listado[$i]['vSucursalDireccion'] = "A definir.";
            }
            if (is_null($data['vSucursalCiudad'])) {
                $Listado[$i]['vSucursalCiudad'] = " ";
            }

            $i++;
    }

    // Devuelvo el listado (puede salir vacio o con datos)
    return $Listado;

}


function ListarVehiculos_OrderByFecha($conexion) {

    $Listado = array();

    // Genero la consulta que deseo
    $SQL = "SELECT v.idVehiculo as vID,
                   v.matricula as vMatricula, 
                   v.color as vColor,
                   v.fechaCompra as vFechaCompra,
                   v.anio as vAnio,
                   v.numeroMotor as vNumeroMotor,
                   v.numeroChasis as vNumeroChasis,
                   v.puertas as vNumeroPuertas,
                   v.asientos as vNumeroAsientos,
                   v.esAutomatico as vAutomatico,
                   v.aireAcondicionado as vAire,
                   v.dirHidraulica as vHidraulica,
                   v.estadoFisicoDelVehiculo as vEstadoFisico,
                   v.disponibilidad as vDisponibilidad,
                   v.kilometraje as vKilometraje,
                   v.idModelo,
                   v.idCombustible,
                   v.idGrupoVehiculo,
                   v.idSucursal,
                   m.idModelo,
                   m.nombreModelo as vModelo,
                   m.descripcionModelo as vDescripcionModelo,
                   c.idCombustible,
                   c.tipoCombustible as vCombustible,
                   g.idGrupo,
                   g.nombreGrupo as vGrupo,
                   g.descripcionGrupo as vDescripcionGrupo,
                   s.idSucursal,
                   s.numeroSucursal as vSucursal,
                   s.direccionSucursal as vSucursalDireccion,
                   s.ciudadSucursal as vSucursalCiudad,
                   s.telefonoSucursal as vSucursalTel
            FROM vehiculos v, modelos m, combustibles c, `grupos-vehiculos` g, sucursales s
            WHERE v.idModelo = m.idModelo 
            AND v.idCombustible = c.idCombustible 
            AND v.idGrupoVehiculo = g.idGrupo
            AND v.idSucursal = s.idSucursal 
            ORDER BY vFechaCompra; ";

    $rs = mysqli_query($conexion, $SQL);
        
    // El resultado debe organizarse en una matriz, entonces lo recorro:
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['vID'] = $data['vID'];
            $Listado[$i]['vMatricula'] = $data['vMatricula'];
            $Listado[$i]['vColor'] = $data['vColor'];
            $Listado[$i]['vFechaCompra'] = $data['vFechaCompra'];
            $Listado[$i]['vAnio'] = $data['vAnio'];
            $Listado[$i]['vNumeroMotor'] = $data['vNumeroMotor'];
            $Listado[$i]['vNumeroChasis'] = $data['vNumeroChasis'];
            $Listado[$i]['vNumeroPuertas'] = $data['vNumeroPuertas'];
            $Listado[$i]['vNumeroAsientos'] = $data['vNumeroAsientos'];
            $Listado[$i]['vAutomatico'] = $data['vAutomatico'];
            $Listado[$i]['vAire'] = $data['vAire'];
            $Listado[$i]['vHidraulica'] = $data['vHidraulica'];
            $Listado[$i]['vEstadoFisico'] = $data['vEstadoFisico'];
            $Listado[$i]['vDisponibilidad'] = $data['vDisponibilidad'];

            if ($Listado[$i]['vDisponibilidad'] == "S") {
                $Listado[$i]['vDisponibilidad'] = "Sí";
            }
            else {
                $Listado[$i]['vDisponibilidad'] = "No";
            }

            $Listado[$i]['vKilometraje'] = $data['vKilometraje'];
            $Listado[$i]['vModelo'] = $data['vModelo'];
            $Listado[$i]['vDescripcionModelo'] = $data['vDescripcionModelo'];
            $Listado[$i]['vCombustible'] = $data['vCombustible'];

            if (is_null($data['vCombustible'])) {
                $Listado[$i]['vCombustible'] = "A definir.";
            }

            $Listado[$i]['vGrupo'] = $data['vGrupo'];
            $Listado[$i]['vDescripcionGrupo'] = $data['vDescripcionGrupo'];
            $Listado[$i]['vSucursal'] = $data['vSucursal'];
            $Listado[$i]['vSucursalDireccion'] = $data['vSucursalDireccion'];
            $Listado[$i]['vSucursalCiudad'] = $data['vSucursalCiudad'];
            $Listado[$i]['vSucursalTel'] = $data['vSucursalTel'];

            if (is_null($data['vSucursalDireccion'])) {
                $Listado[$i]['vSucursalDireccion'] = "A definir.";
            }
            if (is_null($data['vSucursalCiudad'])) {
                $Listado[$i]['vSucursalCiudad'] = " ";
            }

            $i++;
    }

    // Devuelvo el listado (puede salir vacio o con datos)
    return $Listado;

}


?>
