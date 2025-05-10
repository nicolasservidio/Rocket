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

    // Proceso las fechas. Es mucho mejor hacerlo de este modo que de la forma especificada en los demás módulos:
    if (!empty($_POST['AdquisicionDesde'])) {
        $_POST['AdquisicionDesde'] = date("Y-m-d", strtotime($_POST['AdquisicionDesde']));
    } 

    if (!empty($_POST['AdquisicionHasta'])) {
        $_POST['AdquisicionHasta'] = date("Y-m-d", strtotime($_POST['AdquisicionHasta']));
    } 

}


function Consulta_Vehiculo($matricula, $modelo, $grupo, $color, $combustible, $disponibilidad, $ciudadsucursal, $direccionsucursal, $telsucursal, $puertas, $asientos, $automatico, $aireacondicionado, $direccionhidraulica, $fabricaciondesde, $fabricacionhasta, $adquisiciondesde, $adquisicionhasta, $preciodesde, $preciohasta, $conexion) {

    if ($matricula == 0000000) {
        $matricula = 0;
    }

    if ($disponibilidad != "S" && $disponibilidad != "N") {
        $disponibilidad = null;
    }
    if ($automatico != "S" && $automatico != "N") {
        $automatico = null;
    }
    if ($aireacondicionado != "S" && $aireacondicionado != "N") {
        $aireacondicionado = null;
    }
    if ($direccionhidraulica != "S" && $direccionhidraulica != "N") {
        $direccionhidraulica = null;
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
            AND s.idSucursal = v.idSucursal ";

    // Concateno el resto de la consulta para poder agregar condicionales
    if (!empty($matricula)) {
        $SQL .= " AND v.matricula LIKE '$matricula%' ";
    }

    if (!empty($modelo)) {
        $SQL .= " AND m.nombreModelo LIKE '%$modelo%' ";
    }

    if (!empty($grupo)) {
        $SQL .= " AND g.nombreGrupo LIKE '%$grupo%' ";
    }

    if (!empty($color)) {
        $SQL .= " AND v.color LIKE '$color%' ";
    }

    if (!empty($combustible)) {
        $SQL .= " AND c.tipoCombustible LIKE '%$combustible%' ";
    }

    if (!empty($disponibilidad)) {
        $SQL .= " AND v.disponibilidad LIKE '%$disponibilidad%' ";
    }

    if (!empty($ciudadsucursal)) {
        $SQL .= " AND s.ciudadSucursal LIKE '%$ciudadsucursal%' ";
    }

    if (!empty($direccionsucursal)) {
        $SQL .= " AND s.direccionSucursal LIKE '%$direccionsucursal%' ";
    }

    if (!empty($telsucursal)) {
        $SQL .= " AND s.telefonoSucursal LIKE '$telsucursal%' ";
    }

    if (!empty($puertas)) {
        $SQL .= " AND v.puertas LIKE '$puertas%' ";
    }

    if (!empty($asientos)) {
        $SQL .= " AND v.asientos LIKE '$asientos%' ";
    }

    if (!empty($automatico)) {
        $SQL .= " AND v.esAutomatico LIKE '%$automatico%' ";
    }

    if (!empty($aireacondicionado)) {
        $SQL .= " AND v.aireAcondicionado LIKE '%$aireacondicionado%' ";
    }

    if (!empty($direccionhidraulica)) {
        $SQL .= " AND v.dirHidraulica LIKE '%$direccionhidraulica%' ";
    }

    if (!empty($fabricaciondesde)) {
        $SQL .= " AND v.anio >= '$fabricaciondesde'";
    }
    if (!empty($fabricacionhasta)) {
        $SQL .= " AND v.anio <= '$fabricacionhasta'";
    }    

    if (!empty($adquisiciondesde)) {
        $SQL .= " AND v.fechaCompra >= '$adquisiciondesde'";
    }
    if (!empty($adquisicionhasta)) {
        $SQL .= " AND v.fechaCompra <= '$adquisicionhasta'";
    }

    if (!empty($preciodesde)) {
        $SQL .= " AND v.precioCompra >= '$preciodesde'";
    }
    if (!empty($preciohasta)) {
        $SQL .= " AND v.precioCompra <= '$preciohasta'";
    }  

    $SQL .= " ORDER BY v.matricula, m.nombreModelo; "; // Agrego el orden a la consulta sql

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
                $Listado[$i]['ColorAdvertencia'] = "success";
            }
            else {
                $Listado[$i]['vDisponibilidad'] = "No";
                $Listado[$i]['ColorAdvertencia'] = "danger";
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
