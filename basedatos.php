<?php

class basedatos
{
    public $nombre;
    
    public function __construct  ($conexion, $nombre)
    {
        $this->conexion= $conexion;
        $this->nombre = $nombre;
    }
    

    public static function tablaMarcas($conexion){
        $consulta = mysql_query("SELECT * FROM testcolumna;", $conexion);
        $i = 0;
        $tabla = [];
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new marca($conexion, $registro['nombre']);
            $i++;
        }
        return $tabla;
    }
    
    
    
    public function insertar(){	
        $this->nombre = elimSignos($this->nombre);
        $this->imagen = elimSignos($this->imagen);
        $resultado =mysql_query("INSERT INTO `marcas` (`nombre`,`imagen`)".
                                "VALUES('$this->nombre', '$this->imagen');", $this->conexion);
        if (!$resultado)
            die("No se pudo realizar la insercion".mysql_error());
        else
            echo "Datos insertados exitosamente";
    }
    public function modificar(){	
        $this->nombre = elimSignos($this->nombre);
        $this->imagen = elimSignos($this->imagen);
        $resultado = mysql_query("UPDATE `marcas` SET `nombre` = '$this->nombre',`imagen` = '$this->imagen' WHERE `clave` = '$this->clave';", $this->conexion );
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
        $tabla = [];
        while($registro = mysql_fetch_assoc($consulta)){
            $i = $registro['total'];
        }
        return $i;
    }
}
?>
