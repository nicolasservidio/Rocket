<?php

include('head.php');
include('conn/conexion.php');

$MiConexion = ConexionBD();

// Verificar si el ID del contrato está presente en la URL
if (isset($_GET['id'])) {
    $idContrato = $_GET['id'];

    // Primero verifico que el estado del contrato sea "En Preparación" o "Cancelado", caso contrario no debería poder eliminarse
    $contrato = array();

    $ConsultaEstadoContrato = "SELECT c.idContrato as cIdContrato, 
                                      c.idEstadoContrato as cIdEstadoContrato, 
                                      e.idEstadoContrato as eIdEstadoContrato,
                                      e.estadoContrato as eEstadoContrato  
                                FROM `contratos-alquiler` c, `estados-contratos` e  
                                WHERE c.idContrato = $idContrato 
                                AND e.idEstadoContrato = c.idEstadoContrato; ";

    $rs = mysqli_query($MiConexion, $ConsultaEstadoContrato);
    $contrato = mysqli_fetch_array($rs);
    
    if($contrato['eEstadoContrato'] == "Firmado" || $contrato['eEstadoContrato'] == "Activo" || $contrato['eEstadoContrato'] == "Renovado" || $contrato['eEstadoContrato'] == "Finalizado") {
        $mensaje = "Los contratos solo pueden eliminarse si se encuentran en preparación o cancelados. El estado del contrato {$idContrato} es {$contrato['eEstadoContrato']}.";
        echo "<script> 
            alert('$mensaje');
            window.location.href = 'contratosAlquiler.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos';
        </script>";
        exit();
    }

    if($contrato['eEstadoContrato'] == "En Preparación" || $contrato['eEstadoContrato'] == "Cancelado") {

        // Busco el ID en la tabla "Detalle del Contrato" 
        $SQL_seleccion_IdDetalle = "SELECT ca.idContrato, ca.idDetalleContrato, dc.idDetalleContrato as IdDetalle
                                FROM `contratos-alquiler` ca, `detalle-contratos` dc 
                                WHERE ca.idContrato = '$idContrato' 
                                AND ca.idDetalleContrato = dc.idDetalleContrato; ";

        $rs = mysqli_query($MiConexion, $SQL_seleccion_IdDetalle);

        if (!$rs) {
            $mensaje = "Error al seleccionar el ID del detalle del contrato.";
            echo "<script> 
                alert('$mensaje');
                window.location.href = 'contratosAlquiler.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos';
            </script>";
            exit();
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
                $mensaje = " Error al eliminar el detalle del contrato. ";
                echo "<script> 
                    alert('$mensaje');
                    window.location.href = 'contratosAlquiler.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos';
                </script>";
                exit();
            }
            else {

                $SQLdeleteContrato = "DELETE FROM `contratos-alquiler` 
                                        WHERE idContrato = $idContrato; ";

                $rs = mysqli_query($MiConexion, $SQLdeleteContrato);

                if (!$rs) {
                    $mensaje = "Error al eliminar el contrato, pero su detalle fue eliminado exitosamente. ";
                    echo "<script> 
                        alert('$mensaje');
                        window.location.href = 'contratosAlquiler.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos';
                    </script>";
                    exit();
                }
                else {

                    $mensaje = "El contrato de ID={$idContrato} ha sido eliminado exitosamente. ";
                    echo "<script> 
                        alert('$mensaje');
                        window.location.href = 'contratosAlquiler.php?NumeroContrato={$idContrato}&MatriculaContrato=&ApellidoContrato=&NombreContrato=&DocContrato=&EstadoContrato=&PrecioDiaContrato=&CantidadDiasContrato=&MontoTotalContrato=&RetiroDesde=&RetiroHasta=&DevolucionDesde=&DevolucionHasta=&BotonFiltrar=FiltrandoContratos';
                    </script>";
                    exit();
                }
            }
        }
    }
}

else {
    // Si no se pasó un ID, redirigir al listado de reservas
    $mensaje = "El ID del contrato (número identificador) no se capturó correctamente";
    header("Location: contratosAlquiler.php?mensaje= $mensaje.");
    exit();
}

?>