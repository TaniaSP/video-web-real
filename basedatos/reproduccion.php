<?php
class reproduccion
{
    public $id_video;
    public $nombre;
    public $id_dispositivo;
    public $Fecha;
    public $Hora;
    
    public function __construct  ($conexion,$id_video, $nombre, $id_dispositivo, $Fecha, $Hora)
    {
        $this->conexion= $conexion;
        $this->id_video= $id_video;
        $this->nombre= $nombre;
        $this->id_dispositivo = $id_dispositivo;
        $this->Fecha = $Fecha;
        $this->Hora = $Hora;
    }
    
     public static function tablaReproducciones($conexion){
        $consulta = mysql_query("SELECT  `id_video`, `nombre`  ,  `id_dispositivo` ,  `Fecha` ,  `Hora`  FROM  `Reproduccion` ,  `video` WHERE  `video`.`id` =  `Reproduccion`.`id_video`;", $conexion);
        $i = 0;
        $tabla;
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new reproduccion($conexion, $registro['id_video'],$registro['nombre'], $registro['id_dispositivo'],$registro['Fecha'],$registro['Hora']);
            $i++;
        }
        return $tabla;
    }    
     public static function tablaReproduccionesFiltro($conexion, $idVideo, $idDispositivo, $fechaIni, $fechaFin){
        $condiciones = "";
        echo $idVideo;
        if ($idVideo == "todos" || $idVideo == "")
            $condiciones.= " AND `video`.`id` LIKE '%'";
        else
            $condiciones.= " AND `video`.`id` = $idVideo";
        if ($idDispositivo == "todos" || $idDispositivo == "")
            $condiciones.= " AND `Dispositivo`.`id` LIKE '%'";
        else
            $condiciones.= " AND `Dispositivo`.`id` = $idDispositivo";
        
		
        if ($fechaIni != "" && $fechaFin!=""){
			$fechaIni = str_replace('/', '-', $fechaIni);
			$fechaFin = str_replace('/', '-', $fechaFin);
			$fechaIni=date("Y-m-d", strtotime($fechaIni));
			$fechaFin=date("Y-m-d", strtotime($fechaFin));
			$condiciones.=" AND   `Fecha` >=  '$fechaIni' AND  `Fecha` <=  '$fechaFin' ";        
        }        
        
        
        
        $consulta = mysql_query("SELECT  `id_video` ,  `nombre` ,  `id_dispositivo` ,  `Fecha` ,  `Hora`".
                                "FROM  `Reproduccion` ,  `video` ,  `Dispositivo` ".
                                "WHERE  `video`.`id` =  `Reproduccion`.`id_video` ".
                                "AND  `Dispositivo`.`id` =  `Reproduccion`.`id_dispositivo`  ".$condiciones, $conexion);
        $i = 0;
        $tabla;
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new reproduccion($conexion, $registro['id_video'],$registro['nombre'], $registro['id_dispositivo'],$registro['Fecha'],$registro['Hora']);
            $i++;
        }
        return $tabla;
    }
    
    
}
?>

