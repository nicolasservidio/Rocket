<?php

function Procesar_Consulta() {

    $_POST['Matricula'] = trim($_POST['Matricula']);
    $_POST['Modelo'] = trim($_POST['Modelo']);
    $_POST['Grupo'] = trim($_POST['Grupo']);
    $_POST['Matricula'] = strip_tags($_POST['Matricula']);
    $_POST['Modelo'] = strip_tags($_POST['Modelo']);
    $_POST['Grupo'] = strip_tags($_POST['Grupo']);

    $_POST['Color'] = trim($_POST['Color']);
    $_POST['Color'] = strip_tags($_POST['Color']);

    $_POST['Combustible'] = trim($_POST['Combustible']);
    $_POST['Combustible'] = strip_tags($_POST['Combustible']);

    $_POST['CiudadSucursal'] = trim($_POST['CiudadSucursal']);
    $_POST['CiudadSucursal'] = strip_tags($_POST['CiudadSucursal']);

    $_POST['DireccionSucursal'] = trim($_POST['DireccionSucursal']);
    $_POST['DireccionSucursal'] = strip_tags($_POST['DireccionSucursal']);

    $_POST['TelSucursal'] = trim($_POST['TelSucursal']);
    $_POST['TelSucursal'] = strip_tags($_POST['TelSucursal']);

    $_POST['Puertas'] = trim($_POST['Puertas']);
    $_POST['Puertas'] = strip_tags($_POST['Puertas']);

    $_POST['Asientos'] = trim($_POST['Asientos']);
    $_POST['Asientos'] = strip_tags($_POST['Asientos']);
}

function Consulta_Vehiculo($matricula, $modelo, $grupo, $color, $combustible, $disponibilidad, $ciudadsucursal, $direccionsucursal, $telsucursal, $puertas, $asientos, $automatico, $aireacondicionado, $direccionhidraulica, $conexion) {

    if ($matricula == 0000000) {
        $matricula = 0;
    }
    /*
    if (empty($matricula) && $matricula != 0) {
        $matricula = "notempty";
    }
    if (empty($modelo)) {
        $modelo = "notempty";
    }
    if (empty($grupo)) {
        $grupo = "notempty";
    }
    if (empty($color)) {
        $color = "notempty";
    }
    if (empty($combustible)) {
        $combustible = "notempty";
    } 
    */ 

    if ($disponibilidad != "S" && $disponibilidad != "N") {
        $disponibilidad = "";
    }
    if ($automatico != "S" && $automatico != "N") {
        $automatico = "";
    }
    if ($aireacondicionado != "S" && $aireacondicionado != "N") {
        $aireacondicionado = "";
    }
    if ($direccionhidraulica != "S" && $direccionhidraulica != "N") {
        $direccionhidraulica = "";
    }

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
            AND (v.matricula LIKE '$matricula%' 
                 AND m.nombreModelo LIKE '%$modelo%' 
                 AND g.nombreGrupo LIKE '%$grupo%'
                 AND v.color LIKE '$color%'
                 AND c.tipoCombustible LIKE '%$combustible%'
                 AND v.disponibilidad LIKE '%$disponibilidad%'
                 AND s.ciudadSucursal LIKE '%$ciudadsucursal%'
                 AND s.direccionSucursal LIKE '%$direccionsucursal%'
                 AND s.telefonoSucursal LIKE '$telsucursal%'
                 AND v.puertas LIKE '$puertas%' 
                 AND v.asientos LIKE '$asientos%' 
                 AND v.esAutomatico LIKE '%$automatico%'
                 AND v.aireAcondicionado LIKE '%$aireacondicionado%'
                 AND v.dirHidraulica LIKE '%$direccionhidraulica%'
                )
            ORDER BY v.matricula, m.nombreModelo; ";

    $rs = mysqli_query($conexion, $SQL);
        
    // El resultado debe organizarse en una matriz, entonces lo recorro:
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['vID'] = $data['vID'];
            $Listado[$i]['vMatricula'] = $data['vMatricula'];

            $Listado[$i]['vColor'] = $data['vColor'];
            if ($Listado[$i]['vColor'] == "" || $Listado[$i]['vColor'] == " " ) {
                $Listado[$i]['vColor'] = "Sin información";
            } 

            $Listado[$i]['vFechaCompra'] = $data['vFechaCompra'];
            if ($Listado[$i]['vFechaCompra'] == "" || $Listado[$i]['vFechaCompra'] == " " ) {
                $Listado[$i]['vFechaCompra'] = "Sin información";
            } 

            $Listado[$i]['vPrecioCompra'] = $data['vPrecioCompra'];
            if ($Listado[$i]['vPrecioCompra'] == "" || $Listado[$i]['vPrecioCompra'] == " " ) {
                $Listado[$i]['vPrecioCompra'] = "Sin información";
            } 

            $Listado[$i]['vAnio'] = $data['vAnio'];
            if ($Listado[$i]['vAnio'] == "" || $Listado[$i]['vAnio'] == " " ) {
                $Listado[$i]['vAnio'] = "Sin información";
            }

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
            if ($Listado[$i]['vEstadoFisico'] == "" || $Listado[$i]['vEstadoFisico'] == " " ) {
                $Listado[$i]['vEstadoFisico'] = "Sin información";
            }

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
            if (is_null($data['vSucursalDireccion'])) {
                $Listado[$i]['vSucursalDireccion'] = "A definir.";
            }

            $Listado[$i]['vSucursalCiudad'] = $data['vSucursalCiudad'];
            if (is_null($data['vSucursalCiudad'])) {
                $Listado[$i]['vSucursalCiudad'] = " ";
            }

            $Listado[$i]['vSucursalTel'] = $data['vSucursalTel'];

            $i++;
    }

    return $Listado;
}

?>
