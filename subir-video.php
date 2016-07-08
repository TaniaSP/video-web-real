
<?php
include('basedatos/conexion.php');
include('basedatos/video.php');

$conexion = new conexion("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");

?>

<html>
	<head>
		<link type="text/css" href="css/estiloGeneral.css" rel="stylesheet" title='Default' >
		<script language="javascript" src="/js/ajaxMySQL.js" type="text/javascript"></script>
			<title>Admin Videos</title>
			   <link rel="stylesheet" href="/css/styles.css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="/js/script.js"></script>
	</head>
	<body>
		<div id="contenido">
		<form action="subir.php" method="post" enctype="multipart/form-data">

				<table class='tabla'>
					<thead><tr><th>Id</th><th>Direcci&oacute;n</th><th>Nombre</th><th></th></tr></thead>
					<tbody>
						<tr>
							<td id="alta"></td>
							<td id="alta">
								<input type="text" id="direccion" name="direccion" value="/public_html/videos/" readonly />
							</td>
							<td id="alta">
								<div class="fileUpload btn btn-primary">
									<span>Video</span>
									<input type="file" name="filename" class="upload" id="filename"/>
								</div>
							</td>

							<td >
									<input type="submit" name="nuevo" class="botonEditar" value="Subir" />
							</td>
						</tr>
<?php
		global $rowindex, $numpags;
		$videos  = video::tablaVideos($conexion->id);
		$i=2;
		foreach($videos as $row){
			if ($rowindex != $i){
				echo "<tr><td>".$row->id."</td>";
				echo "<td>".$row->direccion." </td>";
				echo "<td>".$row->nombre."</td>";
				echo "<td><input type='button' name='editar' class='botonEditar' id='editar' value='Editar' ".
					"onclick=\"llamadaAjax('subir-video.php','modificarTabla=1&usuarioNombre=tania&usuarioContra=moitania&row='+(this.parentNode.parentNode.rowIndex), 'divVideos')\" /><br />".
					"<input type='button' name='eliminar' class='botonEliminar' id='eliminar' value='Eliminar' ".
					" onclick=\"llamadaAjax('subir-video.php','validarelim=1&row=$row->id', 'divVideos')\" /></td></tr>";;
			} 
			else
			{
				echo '<td>'.$row->id.'</td>';
				echo '<td><input type="text" id="direccionm" name="direccionm" value="'.$row->direccion.'" readonly /></td>';
				echo "<td><div class='fileUpload btn btn-primary'><span>Video</span><input type='file' name='video' class='upload' id='filenamem' value='.$row->nombre.'/></div></td>";
				echo "<td><input type='button' name='guardar' class='botonEditar' id='guardar' value='Guardar' ".
					 " onclick=\"validar(descripcionm.value, 'm', filenamem.value,'$row->id')\";' />".
					 "</br><input type='button' name='cancelar' id='cancelar' class='botonEliminar' value='Cancelar' onclick=\"llamadaAjax('catalogoVideos','desplegarTabla=1&usuarioNombre=tania&usuarioContra=moitania', 'divVideos');\"</td></tr>";
			}
			$i++;
		}
		echo "</tbody>";
		echo "</table>";
?>
			</form>
		</div>
	</body>
</html>

