<?php
function Listar_Proveedores($MiConexion, $filtros = []) {
    $query = "SELECT idProveedor AS ID, cuitProveedor AS CUIT, nombreProveedor AS NOMBRE, 
            ivaProveedor AS IVA, mailProveedor AS EMAIL, telefonoProveedor AS TELEFONO, 
              direccionProveedor AS DIRECCION, localidadProveedor AS LOCALIDAD FROM proveedores WHERE 1=1";

    $params = [];
    $types = '';

    if (!empty($filtros['cuit'])) {
        $query .= " AND cuitProveedor LIKE ?";
        $params[] = "%" . $filtros['cuit'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['nombre'])) {
        $query .= " AND nombreProveedor LIKE ?";
        $params[] = "%" . $filtros['nombre'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['iva'])) {
        $query .= " AND ivaProveedor LIKE ?";
        $params[] = "%" . $filtros['iva'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['email'])) {
        $query .= " AND mailProveedor LIKE ?";
        $params[] = "%" . $filtros['email'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['telefono'])) {
        $query .= " AND telefonoProveedor LIKE ?";
        $params[] = "%" . $filtros['telefono'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['direccion'])) {
        $query .= " AND direccionProveedor LIKE ?";
        $params[] = "%" . $filtros['direccion'] . "%";
        $types .= 's';
    }
    if (!empty($filtros['localidad'])) {
        $query .= " AND localidadProveedor LIKE ?";
        $params[] = "%" . $filtros['localidad'] . "%";
        $types .= 's';
    }    

    $stmt = $MiConexion->prepare($query);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}