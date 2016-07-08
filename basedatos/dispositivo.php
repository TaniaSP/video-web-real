<?php
class dispositivo
{
    public $id;
    public $descripcion;
    public $latitud;
    public $longitud;
    
    public function __construct  ($conexion,$id, $descripcion, $latitud, $longitud)
    {
        $this->conexion= $conexion;
        $this->id= $id;
        $this->descripcion= $descripcion;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
    }
    

    public static function tablaDispositivos($conexion){
        $consulta = mysql_query("SELECT * FROM  `Dispositivo` ;", $conexion);
        $i = 0;
        $tabla;
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new dispositivo($conexion, $registro['id'],$registro['Descripcion'], $registro['Latitud'], $registro['Longitud']);
            $i++;
        }
        return $tabla;
    }
    
	public static function weas($conexion){
        $consulta = mysql_query("SELECT * FROM  `Dispositivo` ;", $conexion);
        $i = 0;
        $tabla;
        while($registro = mysql_fetch_assoc($consulta)){
			$a=$registro['id'];  
			$b=$registro['Descripcion'];
			$c=$registro['Latitud'];
			$d=$registro['Longitud'];
 			$arreglo[] = array('id'=>$a, 'D'=>$b, 'LA'=>$c, 'LO'=>$d);
            $i++;
        }
        return $arreglo;
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
    public function eliminar(){	
        $resultado = mysql_query("DELETE FROM `marcas` WHERE `clave` = '$this->clave';", $this->conexion );
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
}
?>
