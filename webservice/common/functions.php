<?php
	function playlist($id,$pass) 
	{
		//$sql= "SELECT * FROM  Playlist WHERE id_dispositivo=$id;";
        $sql =  "SELECT `id`, `nombre` ,  `orden` FROM  `video` ,  `Playlist` WHERE  `id_video` =  `id` AND  `id_dispositivo` =$id";
		$conn= mysqli_connect("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");    
  		if (!$conn){   
    	//si no hay conexion  lanzamos un error al servicio
    		throw new SOAPFault("Error", "Error de conexi&oacute;n: ".mysqli_connect_error());
  		}else{
    		$conn->set_charset("utf8");
  		}
        $consulta = mysqli_query($conn,$sql);
		while ($fila= mysqli_fetch_array($consulta)){
				$resultado.=$fila['id']."@".$fila['nombre']."@".$fila['orden']."|";  
      	} 
		return $resultado; 
		
	}
	function reproduccion($id_dispositivo,$pass,$id_video,$hora,$fecha) 
	{
		$sql="INSERT INTO `Reproduccion` (`id_dispositivo`,`id_video`,`Hora`,`Fecha`) VALUES($id_dispositivo, $id_video, '$hora', '$fecha');";
		$conn= mysqli_connect("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");    
		if (!$conn){   
    	//si no hay conexion lanzamos un error al servicio
    		throw new SOAPFault("Error", "Error de conexi&oacute;n: ".mysqli_connect_error());
  		}else{
    		$conn->set_charset("utf8");
  		}
	    $consulta = mysqli_query($conn,$sql);
		if (!$consulta)
			return "0";
        else
            return "1";
	} 
	
	function autentifica($id,$pass) 
	{
		$sql= "SELECT * FROM  Dispositivo WHERE id=$id and contra='$pass';";
		$conn= mysqli_connect("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");    
  		if (!$conn){   
    	//si no hay conexion lanzamos un error al servicio
    		throw new SOAPFault("Error", "Error de conexi&oacute;n: ".mysqli_connect_error());
  		}else{
    		$conn->set_charset("utf8");
  		}
        $consulta = mysqli_query($conn,$sql);
		$row_cnt = $consulta->num_rows;
		if($row_cnt>0)
		{
			while ($fila= mysqli_fetch_array($consulta)){
				$resultado.=$fila['Descripcion']."|".$fila['Latitud']."|".$fila['Longitud']; 
			}
			return $resultado;
		}
		else
			return "0";
	}
	
	function registrarse($pass,$descripcion,$latitud,$longitud) 
	{
		$sql="INSERT INTO `Dispositivo` (`Descripcion`,`Latitud`,`Longitud`,`contra`) VALUES('$descripcion', '$latitud', '$longitud', '$pass');";
		$conn= mysqli_connect("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");    
		if (!$conn){   
    	//si no hay conexion lanzamos un error al servicio
    		throw new SOAPFault("Error", "Error de conexi&oacute;n: ".mysqli_connect_error());
  		}else{
    		$conn->set_charset("utf8");
  		}
	    $consulta = mysqli_query($conn,$sql);
		if (!$consulta)
			return "0";
        else
	    {
			$sql= "SELECT id FROM Dispositivo WHERE contra='$pass' and Descripcion='$descripcion' and Latitud='$latitud' and Longitud='$longitud';";
			$consulta = mysqli_query($conn,$sql);
			if($fila = $consulta->fetch_assoc())
			{
				return $fila['id'];
			}
			else
				return "0";
	    }
	} 
	

?>