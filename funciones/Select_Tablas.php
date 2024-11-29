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
function Listar_Vehiculos($vConexion) {

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
                   g.nombreGrupo as grupo
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


?>