<?php
function Listar_Grupo($vConexion) {

    $Listado=array();

    //1) genero la consulta que deseo
    $SQL = "SELECT G.idGrupo, G.nombreGrupo
        FROM grupos-vehiculos G";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $ListadoGrupo[$i]['IdGrupo'] = $data['idGrupo'];
            $ListadoGrupo[$i]['NombreGrupo'] = $data['nombreGrupo'];
            
            $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;

}
?>