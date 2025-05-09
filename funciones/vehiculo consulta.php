<?php

function Procesar_Consulta() {

    $_POST['Matricula'] = trim($_POST['Matricula']);
    $_POST['Modelo'] = trim($_POST['Modelo']);
    $_POST['Grupo'] = trim($_POST['Grupo']);
    $_POST['Matricula'] = strip_tags($_POST['Matricula']);
    $_POST['Modelo'] = strip_tags($_POST['Modelo']);
    $_POST['Grupo'] = strip_tags($_POST['Grupo']);

}

function Consulta_Vehiculo($matricula, $modelo, $grupo, $conexion) {

    if (empty($matricula)) {
        $matricula = "notempty";
    }
    if (empty($modelo)) {
        $modelo = "notempty";
    }
    if (empty($grupo)) {
        $grupo = "notempty";
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
            AND (v.matricula LIKE '$matricula%' OR m.nombreModelo LIKE '%$modelo%' OR g.nombreGrupo LIKE '%$grupo%')
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
            $Listado[$i]['vGrupo'] = $data['vGrupo'];
            $Listado[$i]['vDescripcionGrupo'] = $data['vDescripcionGrupo'];
            $Listado[$i]['vSucursal'] = $data['vSucursal'];
            $Listado[$i]['vSucursalDireccion'] = $data['vSucursalDireccion'];
            $Listado[$i]['vSucursalCiudad'] = $data['vSucursalCiudad'];
            $Listado[$i]['vSucursalTel'] = $data['vSucursalTel'];

            $i++;
    }

    return $Listado;
}

?>
