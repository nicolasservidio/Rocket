<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

// Verificar si el ID del contrato está presente en la URL
if (isset($_GET['id'])) {
    $idContrato = $_GET['id'];

    // Busco el ID en la tabla "Detalle del Contrato" 

    $SQL_seleccion_IdDetalle = "SELECT ca.idContrato, ca.idDetalleContrato, dc.idDetalleContrato as IdDetalle
                              FROM `contratos-alquiler` ca, `detalle-contratos` dc 
                              WHERE ca.idContrato = '$idContrato' 
                              AND ca.idDetalleContrato = dc.idDetalleContrato; ";

    $rs = mysqli_query($MiConexion, $SQL_seleccion_IdDetalle);

    if (!$rs) {
        $mensaje = "Error al seleccionar el ID del detalle del contrato: ";
    }

    else {

        $data = mysqli_fetch_array($rs);
        $idDetalle['IdDetalle'] = $data['IdDetalle'];

        $IdDetalleContrato = $idDetalle['IdDetalle'];

        // Ya contando con el Id de la tabla "Detalle del contrato", podemos realizar las dos eliminaciones:

        $SQLdeleteDetalle = "DELETE FROM `detalle-contratos` 
                             WHERE idDetalleContrato = '$IdDetalleContrato'; ";

        $rs = mysqli_query($MiConexion, $SQLdeleteDetalle);

        if (!$rs) {
            $mensaje.=" Error al eliminar el detalle del contrato. ";
        }
        else {

            $SQLdeleteContrato = "DELETE FROM `contratos-alquiler` 
            WHERE idContrato = $idContrato; ";

            $rs = mysqli_query($MiConexion, $SQLdeleteContrato);

            if (!$rs) {
                $mensaje.=" Error al eliminar el contrato. ";
                header("Location: contratosAlquiler.php?mensaje=$mensaje.");
                exit();
            }
            else {

                header('Location: contratosAlquiler.php?mensaje=El cliente ha sido eliminado correctamente.');
                exit();
            }
        }
    }
}

else {
    // Si no se pasó un ID, redirigir al listado de reservas
    header("Location: contratosAlquiler.php?mensaje= $mensaje.");
    exit();
}

?>