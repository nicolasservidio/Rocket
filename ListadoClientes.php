<?php
function Listar_Clientes($vConexion) {

    // Inicializamos el array que contendrá los resultados
    $Listado = array();

    // Consulta SQL para obtener los datos de la tabla clientes, incluyendo los nuevos campos
    $SQL = "SELECT Id, Documento, Nombre, Apellido, Email, Telefono, FechaNac, Direccion, Pais, Ciudad, RegistroCond, PaisExp, FechaExp, FechaVenc, Tarjeta, Vto
            FROM clientes";

    // Ejecutamos la consulta SQL
    $rs = mysqli_query($vConexion, $SQL);
    
    // Comprobamos si la consulta devolvió algún resultado
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        // Llenamos el array $Listado con los resultados de la consulta
        $Listado[$i]['ID'] = $data['Id'];
        $Listado[$i]['DOCUMENTO'] = $data['Documento'];
        $Listado[$i]['NOMBRE'] = $data['Nombre'];
        $Listado[$i]['APELLIDO'] = $data['Apellido'];
        $Listado[$i]['EMAIL'] = $data['Email'];
        $Listado[$i]['TELEFONO'] = $data['Telefono'];
        $Listado[$i]['FECHANAC'] = $data['FechaNac'];
        $Listado[$i]['DIRECCION'] = $data['Direccion'];
        $Listado[$i]['PAIS'] = $data['Pais'];
        $Listado[$i]['CIUDAD'] = $data['Ciudad'];
        $Listado[$i]['REGISTROCOND'] = $data['RegistroCond'];
        $Listado[$i]['PAISEXP'] = $data['PaisExp'];
        $Listado[$i]['FECHAEXP'] = $data['FechaExp'];
        $Listado[$i]['FECHAVENC'] = $data['FechaVenc'];
        $Listado[$i]['TARJETA'] = $data['Tarjeta'];
        $Listado[$i]['VTO'] = $data['Vto'];

        $i++;
    }

    // Devolvemos el listado generado en el array $Listado
    return $Listado;
}
?>