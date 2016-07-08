<?php
class video
{
    public $id;
    public $direccion;
    public $nombre;
    
    public function __construct  ($conexion,$id, $direccion, $nombre)
    {
        $this->conexion= $conexion;
        $this->id= $id;
        $this->direccion= $direccion;
        $this->nombre = $nombre;
    }
    

    public static function tablaVideos($conexion){
        $consulta = mysql_query("SELECT * FROM  `video` ;", $conexion);
        $i = 0;
        $tabla;
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new video($conexion, $registro['id'],$registro['direccion'], $registro['nombre']);
            $i++;
        }
        return $tabla;
    }
    
    public function insertar(){	
    
        $resultado =mysql_query("INSERT INTO `video` (`direccion`,`nombre`)".
                                "VALUES('$this->direccion', '$this->nombre');", $this->conexion);
        if (!$resultado)
            die("No se pudo realizar la insercion".mysql_error());
        else
            echo "Datos insertados exitosamente";
    }
    public function modificar(){	
        $resultado = mysql_query("UPDATE `video` SET `direccion` = '$this->direccion', `nombre`= '$this->nombre'  WHERE `id` = '$this->id';", $this->conexion );
        if (!$resultado)
            die("No se pudo realizar la modificacion".mysql_error());
        else
            echo "Datos modificados exitosamente";
    }
    public function eliminar(){	
        $resultado = mysql_query("DELETE FROM `video` WHERE `id` = '$this->id';", $this->conexion );
        if (!$resultado)
            die("No se pudo realizar la eliminacion".mysql_error());
        else
            echo "Datos eliminados exitosamente";
    }
    public function tienePlaylist(){
        $consulta = mysql_query("SELECT * FROM Playlist, video where video.id = Playlist.id_video and id = '$this->id';", $this->conexion);
        $i = 0;
        //$tabla = [];
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = 1;
            $i++;
        }
        if (count($tabla)> 0)
            return true;
        else
            return false; 
    }
	 
	
	
    public static function total($conexion){
        $consulta = mysql_query("SELECT count(*) as total from marcas;", $conexion);
        $i = 0;
        while($registro = mysql_fetch_assoc($consulta)){
            $i = $registro['total'];
        }
        return $i;
    }
}
?>
