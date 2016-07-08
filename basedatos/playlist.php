<?php
class playlist
{
    public $conexion;
    public $id_video;
    public $id_dispositivo;
    public $orden;
    public $video;
    public $ruta;
    
    public function __construct  ($conexion,$id_video, $id_dispositivo, $video, $ruta, $orden)
    {
        $this->conexion = $conexion;
        $this->id_video = $id_video;
        $this->id_dispositivo = $id_dispositivo;
        $this->orden = $orden;
        $this->video = $video;
        $this->ruta = $ruta;
    }
    

    public static function tablaPlaylist($conexion){
        $consulta = mysql_query("SELECT id_dispositivo, id, direccion, nombre, orden FROM  `Playlist` ,  `video` WHERE  id = id_video ;", $conexion);
        $i = 0;
        $tabla = array ();
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new playlist($conexion, $registro['id'],$registro['id_dispositivo'], $registro['nombre'], $registro['direccion'], $registro['orden']);
            $i++;
        }
        return $tabla;
    }
    public static function tablaPlaylistDispositivo($conexion, $dispositivo){
        $consulta = mysql_query("SELECT id_dispositivo, id, direccion, nombre, orden FROM  `Playlist` ,  `video` WHERE  id = id_video AND id_dispositivo= '$dispositivo' ORDER BY cast(`orden` AS int)", $conexion);
        
        $i = 0;
        $tabla = array ();
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new playlist($conexion, $registro['id'],$registro['id_dispositivo'], $registro['nombre'], $registro['direccion'], $registro['orden']);
            $i++;
        }
        return $tabla;
    }
    
	public static function programacion($conexion,$id){
        $consulta = mysql_query("SELECT * FROM  Playlist WHERE id_dispositivo=$id;", $conexion);
        $i = 0;
        $tabla;
        while($registro = mysqli_fetch_assoc($consulta)){
			$tabla.= $registro['id_video']."|".$registro['orden']."|";  
            $i++;
        }
        return $tabla;
    }
	
    
    
    public function insertar(){	
    
        $resultado =mysql_query("INSERT INTO `Dispositivo` (`descripcion`,`Latitud`,`Longitud`)".
                                "VALUES('$this->descripcion', '$this->latitud', '$this->longitud');", $this->conexion);
        if (!$resultado)
            die("No se pudo realizar la insercion".mysql_error());
        else
            echo "Datos insertados exitosamente";
    }
    public function modificar(){	
        $resultado = mysql_query("UPDATE `Dispositivo` SET `descripcion` = '$this->descripcion' WHERE `id` = '$this->id';", $this->conexion );
        if (!$resultado)
            die("No se pudo realizar la modificacion".mysql_error());
        else
            echo "Datos modificados exitosamente";
    }
    public function eliminar($id_video, $id_dispositivo){	
        $resultado = mysql_query("DELETE FROM `Playlist` WHERE `id_video` = '$id_video' AND `id_dispositivo` = '$id_dispositivo' ;", $this->conexion );
        if (!$resultado)
            die("No se pudo realizar la eliminacion".mysql_error());
        else
            echo "Datos eliminados exitosamente";
    }
    
    public static function total($conexion){
        $consulta = mysql_query("SELECT count(*) as total from marcas;", $conexion);
        $i = 0;
        while($registro = mysql_fetch_assoc($consulta)){
            $i = $registro['total'];
        }
        return $i;
    }    
    public static function existe($conexion, $video, $dispositivo){
        $consulta = "SELECT * from `Playlist` WHERE `id_video` = '$video' AND `id_dispositivo` = '$dispositivo';";
        $consulta = mysql_query($consulta, $conexion);
        $i = 0;
        while($registro = mysql_fetch_assoc($consulta)){
            return true;
        }
        return false;
    }
    public static function agregarVideo($conexion, $video, $dispositivo){
        $consulta = "INSERT INTO  `Playlist` (`id_video` ,`id_dispositivo` ,`orden`)VALUES ('$video',  '$dispositivo','9999');";
        $consulta = mysql_query($consulta, $conexion);
        if (!$consulta)
            die("No se pudo realizar la insercion".mysql_error());
        else
            echo "Datos insertados exitosamente";
    }
    public static function editarOrden($conexion, $video, $dispositivo, $orden){
        $consulta = "UPDATE `Playlist` SET `orden` = '$orden' WHERE `id_video`='$video' AND `id_dispositivo`='$dispositivo';";
        $consulta = mysql_query($consulta, $conexion);
        if (!$consulta)
            die("No se pudo realizar la actualizacion".mysql_error());
        else
            echo "Datos actualizacion exitosamente";
    }
}
?>
