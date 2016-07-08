<?php
	function playlist($id, $pass) 
	{
		$conexion = new conexion("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");
		$arreglo= array();
		$arreglo  = playlist::programacion($conexion->id,$id); 
		return $arreglo;
	} 


?>
