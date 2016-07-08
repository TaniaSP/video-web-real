<?php
include('basedatos/conexion.php');
include('basedatos/video.php');
$contra = "moitania";
$conexion = new conexion("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");
$usuarioContra = "";
$usuarioContra = $_POST["contra"];
if (isset($_GET["usuarioContra"]))
    $usuarioContra = $_GET["usuarioContra"];
$usuarioNombre = "";
$usuarioNombre = $_POST["nombre"];
if (isset($_GET["usuarioNombre"]))
{
    
    $usuarioNombre = $_GET["usuarioNombre"];
}
$usuarioNombre ="tania";
$usuarioContra="moitania";
$numpags = 0;
$rowindex=-1;
$actual=1;
$direccion = "";
$nombre="";
function tablaVideos($conexion)
{
	global $rowindex, $numpags;
    $videos  = video::tablaVideos($conexion->id);
    ?>

<h1>Videos</h1>
<hr />
<form action="catalogoVideos.php" method="post" enctype="multipart/form-data"> 
<table class='tabla'>
	<thead><tr><th>Id</th><th>Direcci&oacute;n</th><th>Nombre</th><th></th></tr></thead>
	<tbody>
		<tr>
			<td id="alta"></td>
			<td id="alta">
				<input type="text" id="direccion" name="direccion" value="/videos/" readonly />
			</td>
			<td id="alta">
				<div class="fileUpload btn btn-primary">
				<span>Video</span>
				<input type="file" name="filename" class="upload" id="filename"/></div>
			</td>

			<td >
				<input type="submit" name="nuevo" class="botonEditar" id="nuevo" value="Agregar" class="button" />
			</td>
</tr>
<?php
$idmarca= 0;
$i=2;
foreach($videos as $row){
    if ($rowindex != $i){
        echo "<tr><td>".$row->id."</td>";
        echo "<td>".$row->direccion." </td>";
        echo "<td>".$row->nombre."</td>";
        echo "<td><input type='button' name='editar' class='botonEditar' id='editar' value='Editar' ".
            "onclick=\"llamadaAjax('catalogoVideos','modificarTabla=1&usuarioNombre=tania&usuarioContra=moitania&row='+(this.parentNode.parentNode.rowIndex), 'divVideos')\" /></td>";
		echo "<td><input type='button' name='eliminar' class='botonEliminar' id='eliminar' value='Eliminar' ".
            " onclick=\"llamadaAjax('catalogoVideos','validarelim=1&row=$row->id', 'divVideos')\" /></td></tr>";
    } 
    else
    {
        echo '<td><input type="text" name="idvid" id="idvid" value="'.$row->id.'" readonly /></td>';
        echo '<td><input type="text" id="direccionm" name="direccionm" value="'.$row->direccion.'" readonly /></td>';
        echo "<td><div class='fileUpload btn btn-primary'><span>Video</span><input type='file' name='filenamem' class='upload' id='filenamem' value='.$row->nombre.'/></div></td>";
        echo "<td><input type='submit' name='guardar' class='botonEditar' id='guardar' value='Guardar' /></td>";
        echo "<td><input type='button' name='cancelar' id='cancelar' class='botonEliminar' value='Cancelar' onclick=\"llamadaAjax('catalogoVideos','desplegarTabla=1&usuarioNombre=tania&usuarioContra=moitania', 'divVideos');\"</td></tr>";
    }
    $i++;
    

}
echo "</tbody>";
echo "</table></form>";
}

function validar() {
		global $direccion, $nombre;
		$band=true;     
		if ($nombre == "" || $nombre == null  || (!preg_match("/[\w]*.mp4$/",$nombre) && !preg_match("/[\w]*.avc$/",$nombre) 
		&& !preg_match("/[\w]*.3gp$/",$nombre)) ) 
		{
			$band=false;
		}
		else if ($direccion == "" || $direccion   == null || strlen($direccion) > 100 ) 
		{
			$band=false;
		}
		return $band;
	}
	
if($contra == $usuarioContra && ($usuarioNombre == "tania" || $usuarioNombre == "moises"))
  {
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{   
		//echo "ENTRO";
		if (empty($_FILES['filename']['name']))
		{
			if (!empty($_FILES['filenamem']['name']))
			{
				$nombre=$_FILES['filenamem']['name'];
				if (validar()==true)
				{
					$id = $_POST["idvid"];
					$direccion= $_POST["direccionm"];
					$folder = "/home/u373017502/public_html/videos/";

					
					if (is_uploaded_file($HTTP_POST_FILES['filenamem']['tmp_name']))  {
						if (move_uploaded_file($HTTP_POST_FILES['filenamem']['tmp_name'], $folder.$HTTP_POST_FILES['filenamem']['name'])) {
							$editarVideo = new video($conexion->id,$id,'','');
							$video=$editarVideo->nombreVideo($conexion->id);
							unlink($folder.$video);
							$editarVideo->nombre=$nombre;
							$editarVideo->direccion=$direccion;
							$editarVideo->modificar();
						} else {
							Echo "File not moved to destination folder. Check permissions";
						}
					} else {
						Echo "File is not uploaded.";	
					}
				}
			}
			else
			{
			echo "NO ENTROW";
			}
		}
		else
		{
			$nombre=$_FILES['filename']['name'];
			$direccion= $_POST["direccion"];
			if (validar()==true)
			{		
				$folder = "/home/u373017502/public_html/videos/";
				if (is_uploaded_file($HTTP_POST_FILES['filename']['tmp_name']))  {
					if (move_uploaded_file($HTTP_POST_FILES['filename']['tmp_name'], $folder.$HTTP_POST_FILES['filename']['name'])) {
						$nuevoVideo = new video($conexion->id, '',$direccion,$nombre);
						$nuevoVideo->insertar();
					} else {
						Echo "File not moved to destination folder. Check permissions";
					}
				} else {
					Echo "File is not uploaded.";	
				}
			}
		}
		

	}  
	if (isset($_GET['modificarTabla'])){
		$rowindex = $_GET['row'];
		tablaVideos($conexion);
		return;
	}
	if (isset($_GET['modificar']))
	{
		$idVide = $_GET['idVide'];
		$nombre = $_GET['nombre'];
		$nombre = trim($nombre);
		$nombre = str_replace("\\", "/",$nombre);
		$nombre = explode('fakepath',$nombre); 
		$nombre = $nombre['1'];
		if (validar()==true)
		{
			$nuevoDisp = new dispositivo($conexion->id, $idVide,$direccion,$nombre);
			$nuevoDisp->modificar();
		}
		tablaVideos($conexion);
		return;
	}

	if (isset($_GET['eliminar']))
	{
		$folder = "/home/u373017502/public_html/videos/";
		$idVide = $_GET['row'];
		$videonuevo = new video($conexion->id, $idVide, "","");
		if ($videonuevo->tienePlaylist() == true){
			echo '<div id="verificar" class="dialog"><p class="error" >No se puede eliminar, tiene playlist asignadas.</p>';                                                                      
			echo "<input type='button' class='botonEditar' value='Aceptar' ".
				" onclick=document.getElementById('verificar').style.display='none';return false;  />" ;
			echo "</div>";
		}
		else{
			$video=$videonuevo->nombreVideo($conexion->id);
			unlink($folder.$video);
			$videonuevo->eliminar();
		}
		tablaVideos($conexion);
		return;
	}

	if (isset($_GET['validarelim']))
	{
		$idVide="";
		$idVide = $_GET['row'];
		echo '<div id="verificar" class="dialog">Seguro desea eliminar el video de id ';
		if(isset($_GET['row'])) echo $_GET['row'];
		echo  '?';
		echo "<input type='button' value='Si' class='botonEditar' id='btnSi' name='btnSi' ".
			" onclick=\"llamadaAjax('catalogoVideos','eliminar=1&row=$idVide', 'divVideos');\"/>";
		echo "<input type='button' class='botonEliminar' value='No' id='btnNo' name='btnNo' ".
			" onclick=document.getElementById('verificar').style.display='none';return false;  />" ;
		echo "</div>";
		tablaVideos($conexion);
		return;
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
	<link type="text/css" href="css/estiloGeneral.css" rel="stylesheet" title='Default' >
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    <script language="javascript" src="/js/ajaxMySQL.js" type="text/javascript"></script>
        <title>Admin Videos</title>
           <link rel="stylesheet" href="/css/styles.css">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="/js/script.js"></script>
	<script language="javascript" type="text/javascript">
		function validar(direccion, tipo, file,clave)
		{
			if((file) == null || file == "" || file.trim() == "" || 
				(!/[\w]*.mp4$/.test(file) && !/[\w]*.3gp$/.test(file) && !/[\w]*.avc$/.test(file))){				
				alert("Video Incorrecto");
				return false;
			}
			else if(direccion == null || direccion == "" || direccion.trim() == "" || direccion.length > 100){
				alert("Direcci&oacute Incorrecta");
				return false;
			}
			alert("Informacion correcta");
			if (tipo == 'i'){
				llamadaAjax('catalogoVideos','insertar=1&usuarioNombre=tania&usuarioContra=moitania&nombre='+file,'divVideos');
			}
			else
				llamadaAjax('catalogoVideos','modificar=1&usuarioNombre=tania&usuarioContra=moitania&nombre='+file+'&idVide='+clave,'divVideos');
			return true;
	}			
	</script>
    </head>
    <body>	
    <div id='contenido'>
    <?				
if (!isset($_GET['eliminar'])  && !isset($_GET['modificar']) 
 && !isset($_GET['modificarTabla']) && !isset($_GET['validarelim'])&& !isset($_GET['actual'])&& !isset($_GET['desplegarTabla']))
{
    include('menu.php');

    }
    
    ?>
   <script>
  
  $( document ).ready(function() {
    $("#playlistMenu").removeClass( "active" );
    $("#videosMenu").addClass( "active" );
    $("#dispositivoMenu").removeClass( "active" );
});
   </script>
<div id="divVideos" > 
<?php

tablaVideos($conexion);
?>
</div>

</div>




    <!--form action="subir-video.php" method="post" enctype="multipart/form-data">
Archivo: <input type="file" name="filename" />
<input type="submit" value="Subir" />-->
<!--</form> -->

    </body>
</html>		
<?php
}

?>