<?php
function Listar_Clientes($vConexion) {

    // Inicializamos el array que contendrá los resultados
    $Listado = array();

    // Consulta SQL para obtener los datos de la tabla clientes, incluyendo los nuevos campos
    $SQL = "SELECT IdCliente, dniCliente, nombreCliente, apellidoCliente, mailCliente, telefonoCliente, direccionCliente
            FROM clientes";

    // Ejecutamos la consulta SQL
    $rs = mysqli_query($vConexion, $SQL);
    
    // Comprobamos si la consulta devolvió algún resultado
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        // Llenamos el array $Listado con los resultados de la consulta
        $Listado[$i]['ID'] = $data['IdCliente'];
        $Listado[$i]['DOCUMENTO'] = $data['dniCliente'];
        $Listado[$i]['NOMBRE'] = $data['nombreCliente'];
        $Listado[$i]['APELLIDO'] = $data['apellidoCliente'];
        $Listado[$i]['EMAIL'] = $data['mailCliente'];
        $Listado[$i]['TELEFONO'] = $data['telefonoCliente'];
        $Listado[$i]['DIRECCION'] = $data['direccionCliente'];

        $i++;
    }

    // Devolvemos el listado generado en el array $Listado
    return $Listado;
}
?>