<?php

// EMITIR LISTADO de Grupos
function Listar_Grupo($vConexion) {

    $Listado=array();

    //1) genero la consulta que deseo
    $SQL = "SELECT G.idGrupo, G.nombreGrupo
        FROM `grupos-vehiculos` G; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdGrupo'] = $data['idGrupo'];
            $Listado[$i]['NombreGrupo'] = $data['nombreGrupo'];
            
            $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;

}


// EMITIR LISTADO de Modelos
function Listar_Modelo($vConexion) {

    $Listado=array();

    //1) genero la consulta que deseo
    $SQL = "SELECT idModelo, nombreModelo, descripcionModelo
        FROM modelos; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdModelo'] = $data['idModelo'];
            $Listado[$i]['NombreModelo'] = $data['nombreModelo'];
            $Listado[$i]['DescripcionModelo'] = $data['descripcionModelo'];
            
            $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;

}


// EMITIR LISTADO de Combustibles
function Listar_Combustible($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT idCombustible, tipoCombustible
        FROM combustibles; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdCombustible'] = $data['idCombustible'];
            $Listado[$i]['TipoCombustible'] = $data['tipoCombustible'];
            
            $i++;
    }

    return $Listado;

}


// EMITIR LISTADO de Sucursales
function Listar_Sucursal($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT idSucursal, numeroSucursal, direccionSucursal, ciudadSucursal, telefonoSucursal
        FROM sucursales; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdSucursal'] = $data['idSucursal'];
            $Listado[$i]['NumeroSucursal'] = $data['numeroSucursal'];
            $Listado[$i]['DireccionSucursal'] = $data['direccionSucursal'];
            $Listado[$i]['CiudadSucursal'] = $data['ciudadSucursal'];
            $Listado[$i]['TelefonoSucursal'] = $data['telefonoSucursal'];
            
            $i++;
    }

    return $Listado;
}


// EMITIR LISTADO de Vehiculos
function Listar_VehiculosReservados($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT v.idVehiculo as IdVehiculo,
                   v.matricula as matricula,
                   v.idModelo,
                   v.idGrupoVehiculo,
                   m.idModelo, 
                   m.nombreModelo as modelo, 
                   m.descripcionModelo, 
                   g.idGrupo,
                   g.nombreGrupo as grupo, 
                   v.idSucursal as IdSucursal 
            FROM vehiculos v, modelos m, `grupos-vehiculos` g 
            WHERE v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdVehiculo'] = $data['IdVehiculo'];
            $Listado[$i]['matricula'] = $data['matricula'];
            $Listado[$i]['modelo'] = $data['modelo'];
            $Listado[$i]['grupo'] = $data['grupo'];
            $Listado[$i]['IdSucursal'] = $data['IdSucursal'];
            
            $i++;
    }

    return $Listado;
}


// EMITIR LISTADO de Vehiculos Disponibles para la reserva
function Listar_Vehiculos_Disponibles($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT v.idVehiculo as IdVehiculo,
                   v.matricula as matricula,
                   v.disponibilidad, 
                   v.idModelo,
                   v.idGrupoVehiculo,
                   m.idModelo, 
                   m.nombreModelo as modelo, 
                   m.descripcionModelo, 
                   g.idGrupo,
                   g.nombreGrupo as grupo
            FROM vehiculos v, modelos m, `grupos-vehiculos` g 
            WHERE v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            AND v.disponibilidad = 'S'; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdVehiculo'] = $data['IdVehiculo'];
            $Listado[$i]['matricula'] = $data['matricula'];
            $Listado[$i]['modelo'] = $data['modelo'];
            $Listado[$i]['grupo'] = $data['grupo'];
            
            $i++;
    }

    return $Listado;
}


// EMITIR LISTADO de Clientes
function Listar_Clientes($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT idCliente,
                   nombreCliente,
                   apellidoCliente,
                   dniCliente,
                   telefonoCliente
            FROM clientes ; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['idCliente'] = $data['idCliente'];
            $Listado[$i]['nombreCliente'] = $data['nombreCliente'];
            $Listado[$i]['apellidoCliente'] = $data['apellidoCliente'];
            $Listado[$i]['dniCliente'] = $data['dniCliente'];
            $Listado[$i]['telefonoCliente'] = $data['telefonoCliente'];
            
            $i++;
    }

    return $Listado;
}



// EMITIR LISTADO de Clientes ordenados por apellido, nombre y dni 
function Listar_Clientes_AtoZ($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT idCliente,
                   nombreCliente,
                   apellidoCliente,
                   dniCliente,
                   telefonoCliente
            FROM clientes 
            ORDER BY apellidoCliente, nombreCliente, dniCliente; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['idCliente'] = $data['idCliente'];
            $Listado[$i]['nombreCliente'] = $data['nombreCliente'];
            $Listado[$i]['apellidoCliente'] = $data['apellidoCliente'];
            $Listado[$i]['dniCliente'] = $data['dniCliente'];
            $Listado[$i]['telefonoCliente'] = $data['telefonoCliente'];
            
            $i++;
    }

    return $Listado;
}



// EMITIR LISTADO de Proveedores ordenados por localidad, dirección, y nombre 
function Listar_Proveedores_OrderByLocalidadDireccionNombre($vConexion) {

    $Listado = array();

    $SQL = "SELECT idProveedor,
                   nombreProveedor,
                   mailProveedor,
                   telefonoProveedor,
                   localidadProveedor,
                   direccionProveedor,
                   cuitProveedor, 
                   ivaProveedor 
            FROM proveedores 
            ORDER BY localidadProveedor, direccionProveedor, nombreProveedor; ";

    $rs = mysqli_query($vConexion, $SQL);
        
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['idProveedor'] = $data['idProveedor'];
            $Listado[$i]['nombreProveedor'] = $data['nombreProveedor'];
            $Listado[$i]['mailProveedor'] = $data['mailProveedor'];
            $Listado[$i]['telefonoProveedor'] = $data['telefonoProveedor'];
            $Listado[$i]['localidadProveedor'] = $data['localidadProveedor'];
            $Listado[$i]['direccionProveedor'] = $data['direccionProveedor'];
            $Listado[$i]['cuitProveedor'] = $data['cuitProveedor'];
            $Listado[$i]['ivaProveedor'] = $data['ivaProveedor'];
            
            $i++;
    }

    return $Listado;
}



// EMITIR LISTADO de Estados de un contrato
function Listar_EstadosContrato($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT idEstadoContrato, 
                   estadoContrato, 
                   descripcionEstadoContrato 
            FROM `estados-contratos` ; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdEstadoContrato'] = $data['idEstadoContrato'];
            $Listado[$i]['EstadoContrato'] = $data['estadoContrato'];
            $Listado[$i]['DescripcionEstadoContrato'] = $data['descripcionEstadoContrato'];
            
            $i++;
    }

    return $Listado;
}


// EMITIR LISTADO de Contratos con estado "Firmado" para la entrega del vehículo
function Listar_Contratos_Firmados($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT ca.idContrato as caIdContrato, 
                   ca.idCliente as caIdCliente,
                   ca.idVehiculo as caIdVehiculo,
                   ca.idEstadoContrato as caIdEstadoContrato,

                   c.idCliente as cIdCliente,
                   c.nombreCliente as cNombreCliente,
                   c.apellidoCliente as cApellidoCliente,
                   c.dniCliente as cDniCliente,

                   ec.idEstadoContrato as ecIdEstadoContrato,
                   ec.estadoContrato as ecEstadoContrato,
                   ec.descripcionEstadoContrato as ecDescripcionEstadoContrato,

                   v.idVehiculo as IdVehiculo,
                   v.matricula as matricula,
                   v.disponibilidad, 
                   v.idModelo,
                   v.idGrupoVehiculo,

                   m.idModelo, 
                   m.nombreModelo as modelo, 
                   m.descripcionModelo, 

                   g.idGrupo,
                   g.nombreGrupo as grupo
            FROM `contratos-alquiler` ca, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g, `estados-contratos` ec 
            WHERE ca.idCliente = c.idCliente 
            AND ca.idVehiculo = v.idVehiculo 
            AND v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            AND ca.IdEstadoContrato = ec.idEstadoContrato 
            AND ec.estadoContrato = 'Firmado'; ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdContrato'] = $data['caIdContrato'];

            $Listado[$i]['NombreCliente'] = $data['cNombreCliente'];
            $Listado[$i]['ApellidoCliente'] = $data['cApellidoCliente'];
            $Listado[$i]['DniCliente'] = $data['cDniCliente'];

            $Listado[$i]['EstadoContrato'] = $data['ecEstadoContrato'];
            $Listado[$i]['DescripcionEstadoContrato'] = $data['ecDescripcionEstadoContrato'];

            $Listado[$i]['IdVehiculo'] = $data['IdVehiculo'];
            $Listado[$i]['matricula'] = $data['matricula'];
            $Listado[$i]['modelo'] = $data['modelo'];
            $Listado[$i]['grupo'] = $data['grupo'];
            
            $i++;
    }

    return $Listado;
}



// EMITIR LISTADO de vehículos "Entregados" para su devolución:

function Listar_VehiculosEntregados($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT ev.idEntrega as evIdEntrega,
                   ev.fechaEntrega as evFechaEntrega,
                   ev.horaEntrega as evHoraEntrega,
                   ev.idCliente as evIdCliente,
                   ev.idContrato as evIdContrato,
                   
                   ca.idContrato as caIdContrato, 
                   ca.idCliente as caIdCliente,
                   ca.idVehiculo as caIdVehiculo,
                   ca.idEstadoContrato as caIdEstadoContrato,

                   c.idCliente as cIdCliente,
                   c.nombreCliente as cNombreCliente,
                   c.apellidoCliente as cApellidoCliente,
                   c.dniCliente as cDniCliente,

                   ec.idEstadoContrato as ecIdEstadoContrato,
                   ec.estadoContrato as ecEstadoContrato,
                   ec.descripcionEstadoContrato as ecDescripcionEstadoContrato,

                   v.idVehiculo as IdVehiculo,
                   v.matricula as matricula,
                   v.disponibilidad, 
                   v.idModelo,
                   v.idGrupoVehiculo,

                   m.idModelo, 
                   m.nombreModelo as modelo, 
                   m.descripcionModelo, 

                   g.idGrupo,
                   g.nombreGrupo as grupo
            FROM `entregas-vehiculos` ev, `contratos-alquiler` ca, clientes c, vehiculos v, modelos m, `grupos-vehiculos` g, `estados-contratos` ec 
            WHERE c.idCliente = ev.idCliente 
            AND ca.idContrato = ev.idContrato 
            AND ca.idCliente = c.idCliente 
            AND ca.idVehiculo = v.idVehiculo 
            AND v.idModelo = m.idModelo 
            AND v.idGrupoVehiculo = g.idGrupo 
            AND ca.IdEstadoContrato = ec.idEstadoContrato
            AND (ec.estadoContrato = 'Activo' OR ec.estadoContrato = 'Renovado'); ";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdEntrega'] = $data['evIdEntrega']; 
            $Listado[$i]['FechaEntrega'] = $data['evFechaEntrega']; 
            $Listado[$i]['HoraEntrega'] = $data['evHoraEntrega']; 

            $Listado[$i]['IdContrato'] = $data['caIdContrato'];

            $Listado[$i]['NombreCliente'] = $data['cNombreCliente'];
            $Listado[$i]['ApellidoCliente'] = $data['cApellidoCliente'];
            $Listado[$i]['DniCliente'] = $data['cDniCliente'];

            $Listado[$i]['EstadoContrato'] = $data['ecEstadoContrato'];
            $Listado[$i]['DescripcionEstadoContrato'] = $data['ecDescripcionEstadoContrato'];

            $Listado[$i]['IdVehiculo'] = $data['IdVehiculo'];
            $Listado[$i]['matricula'] = $data['matricula'];
            $Listado[$i]['modelo'] = $data['modelo'];
            $Listado[$i]['grupo'] = $data['grupo'];
            
            $i++;
    }

    return $Listado;
}



// EMITIR LISTADO de Usuarios del Sistema

function Listar_Usuarios($vConexion) {

    $Listado = array();

    //1) genero la consulta que deseo
    $SQL = "SELECT u.id as IdUsuario, 
                   u.nombre as NombreUsuario, 
                   u.usuario as Usuario,
                   u.id_cargo,
                   c.id as IdCargo, 
                   c.descripcion as NombreCargo 
            FROM usuarios u, cargo c 
            WHERE u.id_cargo = c.id; ";

    $rs = mysqli_query($vConexion, $SQL);
        
    $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IdUsuario'] = $data['IdUsuario'];
            $Listado[$i]['NombreUsuario'] = $data['NombreUsuario'];
            $Listado[$i]['Usuario'] = $data['Usuario'];
            $Listado[$i]['IdCargo'] = $data['IdCargo'];
            $Listado[$i]['NombreCargo'] = $data['NombreCargo'];

            if ($Listado[$i]['NombreCargo'] == "ADMINISTRADOR") {
                $Listado[$i]['NombreCargo'] = "Administrador del sistema"; 
            }
            if ($Listado[$i]['NombreCargo'] == "GERENTE_OPERACIONES") {
                $Listado[$i]['NombreCargo'] = "Gerente de Operaciones"; 
            }
            if ($Listado[$i]['NombreCargo'] == "GERENTE_COMERCIAL") {
                $Listado[$i]['NombreCargo'] = "Gerente Comercial"; 
            }
            if ($Listado[$i]['NombreCargo'] == "GERENTE_TALLER") {
                $Listado[$i]['NombreCargo'] = "Gerente de Taller"; 
            }
            if ($Listado[$i]['NombreCargo'] == "ENCARGADO_ATPUBLICO") {
                $Listado[$i]['NombreCargo'] = "Encargado de Atención al Público"; 
            }
            if ($Listado[$i]['NombreCargo'] == "ENCARGADO_VENTAS") {
                $Listado[$i]['NombreCargo'] = "Encargado de Ventas"; 
            }
            if ($Listado[$i]['NombreCargo'] == "ENCARGADO_TALLER") {
                $Listado[$i]['NombreCargo'] = "Encargado de Taller"; 
            }
            if ($Listado[$i]['NombreCargo'] == "ENCARGADO_COMPRAS") {
                $Listado[$i]['NombreCargo'] = "Encargado de Compras"; 
            }
            if ($Listado[$i]['NombreCargo'] == "OPERATIVO_ATPUBLICO") {
                $Listado[$i]['NombreCargo'] = "Operario de Atención al Público"; 
            }
            if ($Listado[$i]['NombreCargo'] == "OPERATIVO_VENTAS") {
                $Listado[$i]['NombreCargo'] = "Operario de Ventas"; 
            }
            if ($Listado[$i]['NombreCargo'] == "OPERATIVO_TALLER") {
                $Listado[$i]['NombreCargo'] = "Operario de Taller"; 
            }
            if ($Listado[$i]['NombreCargo'] == "OPERATIVO_COMPRAS") {
                $Listado[$i]['NombreCargo'] = "Operario de Compras"; 
            }
            
            $i++;
    }

    return $Listado;
}

?>