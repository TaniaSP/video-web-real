<?php
include('basedatos/conexion.php');
include('basedatos/playlist.php');
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
    $usuarioNombre = $_GET["usuarioNombre"];
if (isset($_GET["dispositivo"])){
    $dispositivo = $_GET["dispositivo"];
        
    }

    
if (isset($_GET["agregarvideo"])){
    $dispositivo = $_GET['dispositivo'];
    $video = $_GET['video'];
    $playlist = new playlist($conexion->id,$video, $dispositivo, "", "", "");
    $yaExiste = $playlist::existe($conexion->id, $video,$dispositivo);
    if ($yaExiste == "1")
    {
        echo  "<p style='color:red'>Ese video ya existe en la playlist</p>";
    
    }
    else{
       $playlist::agregarVideo($conexion->id,$video, $dispositivo);
        
    
    }
       
}    
if (isset($_GET["editarvideo"])){
    $dispositivo = $_GET['dispositivo'];
    $video = $_GET['video'];
    $orden = $_GET['orden'];
    $playlist = new playlist($conexion->id,$video, $dispositivo, "", "", "");
    $yaExiste = $playlist::editarOrden($conexion->id, $video, $dispositivo, $orden);
}

    
   if (isset($_GET['desplegarTabla'])){
    tablaPlaylist($conexion);

    return;


} 
    
 if (isset($_GET['validarelim']))
{
    $video="";
    $dispositivo="";
    $video = $_GET['video'];
    $dispositivo = $_GET['dispositivo'];
    echo '<div id="verificar" class="dialog">Seguro desea eliminar el video de id ';
    if(isset($_GET['video']) and isset($_GET['dispositivo'])) echo $_GET['video'];
    echo  '?';
    echo "<input type='button' value='Si' class='botonEditar' id='btnSi' name='btnSi' ".
        " onclick=\"llamadaAjax('playlist','eliminar=1&video=$video&dispositivo=$dispositivo', 'divPlaylist');\"/>";
    echo "<input type='button' class='botonEliminar' value='No' id='btnNo' name='btnNo' ".
        " onclick=document.getElementById('verificar').style.display='none';return false;  />" ;
    echo "</div>";
   tablaPlaylist($conexion);

    return;
}

if (isset($_GET['eliminar']))
{
    $video = "";
    $dispositivo = "";
    $video= $_GET['video'];
    $dispositivo= $_GET['dispositivo']; 
    $playlist = new playlist($conexion->id,"","","","","");
    $playlist->eliminar($video, $dispositivo);
   // $videonuevo->eliminar();
    tablaPlaylist($conexion);
    return;
}

   
$numpags = 0;
$rowindex=-1;
$actual=1;
$descripcion="";
function tablaPlaylist($conexion)
{
	global $rowindex, $numpags, $dispositivo, $usuarioContra, $usuarioNombre;
    $videos  = video::tablaVideos($conexion->id);
    if (isset($_GET["dispositivo"])){
$playlist   =playlist::tablaPlaylistDispositivo($conexion->id, $dispositivo);
}
else{

    $playlist  = playlist::tablaPlaylist($conexion->id);
    } 
    ?>
<h1>Playlist</h1>
<hr />
<table class='tabla'>
<thead><tr><th># Video</th><th># Disp</th><th>Nombre</th><th>Ruta</th><th>Orden</th><th></th></tr></thead>
<tbody>
<tr>

<?php
echo '<td colspan="4" id="alta"><select name="video" id="video">';
foreach($videos as $row)
    echo "<option value ='$row->id'>$row->nombre</option>";
echo '</select></td>';


?>


<td ><input type="button" name="nuevo" class="botonEditar" id="nuevo" value="Agregar Video" class="button"
    onclick="agregarVideo(video.value, <?php echo $dispositivo?>)"	/></td>
    
    <td ><a class="botonEditar" id="nuevo" class="button" href="/catalogoVideos.php?usuarioNombre=tania&usuarioContra=moitania"	/>Subir</a></td>
</tr>
<?php  
$idmarca= 0;
$i=2;
foreach($playlist as $row){
    if ($rowindex != $i){
        echo "<tr><td>".$row->id_video."</td>";
        echo "<td>".$row->id_dispositivo." </td>";
        echo "<td>".$row->video."</td>";
        echo "<td>".$row->ruta."</td>";
        echo "<td>".$row->orden."</td>";
        echo "<td><input type='button' name='editar' class='botonEditar' id='editar' value='Editar Orden' ".
            "onclick=\"llamadaAjax('playlist','modificarTabla=1&dispositivo=$dispositivo&usuarioNombre=$usuarioNombre&usuarioContra=$usuarioContra&row='+(this.parentNode.parentNode.rowIndex), 'divPlaylist')\" /></td>";
        echo "<td><input type='button' name='eliminar' class='botonEliminar' id='eliminar' value='Eliminar' ".
            "onclick=\"llamadaAjax('playlist','validarelim=1&video=$row->id_video&dispositivo=$dispositivo&usuarioNombre=$usuarioNombre&usuarioContra=$usuarioContra&row='+(this.parentNode.parentNode.rowIndex), 'divPlaylist')\" /></td></tr>";
    } 
    else
    {
        echo '<td>'.$row->id_video.'</td>';
        echo '<td>'.$row->id_dispositivo.'</td>';
        echo '<td>'.$row->video.'</td>';
        echo '<td>'.$row->ruta.'</td>';
        echo '<td><input type="text" id="ordenm" name="ordenm" value="'.$row->orden.'" /></td>';
        echo "<td><input type='button' name='guardar' class='botonEditar' id='guardar' value='Guardar' ".
             " onclick=\"editarVideo(ordenm.value, '$row->id_video', '$row->id_dispositivo')\";' />".
             "</br><input type='button' name='cancelar' id='cancelar' class='botonEliminar' value='Cancelar' onclick=\"llamadaAjax('playlist','desplegarTabla=1&usuarioNombre=$usuarioNombre&usuarioContra=$usuarioNombre&dispositivo=$dispositivo', 'divPlaylist');\"</td></tr>";
    }
    $i++;
    

}
echo "</tbody>";
echo "</table>";
}

function validar() {
		global $descripcion;
		$band=true;     
		if ($descripcion == "" || $descripcion == null || strlen($descripcion) > 30 ) 
		{
			$band=false;
		}
		return $band;
	}

if($contra == $usuarioContra && ($usuarioNombre == "tania" || $usuarioNombre == "moises"))

  {

  
  
if (isset($_GET['insertar']))
{   
    $descripcion = $_GET['descripcion'];
    $descripcion = trim($descripcion);
    if (validar()==true)
    {          
        $nuevoDisp = new dispositivo($conexion->id, "",$descripcion,"0","0");
        $nuevoDisp->insertar();
    }
    tablaPlaylist($conexion);
    return;
}  
if (isset($_GET['modificarTabla'])){
$rowindex = $_GET['row'];
tablaPlaylist($conexion);
return;
}
if (isset($_GET['modificar']))
{
    $idDisp = $_GET['idDisp'];
    $descripcion = $_GET['descripcion'];
    $descripcion = trim($descripcion);
    if (validar()==true)
    {
        $nuevoDisp = new dispositivo($conexion->id, $idDisp,$descripcion,"0","0");
        $nuevoDisp->modificar();
    }
    tablaDispositivos($conexion);
    return;
}




?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
    <script language="javascript" src="/js/ajaxMySQL.js" type="text/javascript"></script>
        <title>Admin Videos</title>
           <link rel="stylesheet" href="/css/styles.css">
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
           	<link type="text/css" href="css/estiloGeneral.css" rel="stylesheet" title='Default' >

   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="/js/script.js"></script>
	<script language="javascript" type="text/javascript">
	function validar(descripcion, tipo, clave)
	{
		if(descripcion == null || descripcion == "" || descripcion.trim() == "" || descripcion.length > 30){
			alert("descripcion incorrecta.");
			return false;
        }
		alert("Informacion correcta");
		if (tipo == 'i'){
			llamadaAjax('admin','insertar=1&usuarioNombre=<?php echo $usuarioNombre?>&usuarioContra=<?php echo $usuarioContra ?>&descripcion='+descripcion,'divPlaylist');
        }
		else
			llamadaAjax('admin','modificar=1&usuarioNombre=tania&usuarioContra=moitania&descripcion='+descripcion+'&idDisp='+clave,'divPlaylist');
		return true;
	}
	function agregarVideo(video, dispositivo)
    {
        llamadaAjax('playlist','agregarvideo=1&usuarioNombre=<?php echo $usuarioNombre ?>&usuarioContra=<?php echo $usuarioContra ?>&video='+video+'&dispositivo='+dispositivo,'divPlaylist');

    }
	function editarVideo(orden, video, dispositivo)
    {
    	if(isNaN(orden) || orden.trim() == "" || orden.length > 5)
            alert('orden incorrecto');
        else
            llamadaAjax('playlist','editarvideo=1&usuarioNombre=<?php echo $usuarioNombre ?>&usuarioContra=<?php echo $usuarioContra ?>&video='+video+'&orden='+orden+'&dispositivo='+dispositivo,'divPlaylist');

    }
    function videoExisteJS(){alert('ese video ya existe');}
	</script>
    </head>
    <body>
    <div id='contenido'>
    
    <?
if (!isset($_GET['eliminar']) && !isset($_GET['insertar']) && !isset($_GET['modificar']) 
 && !isset($_GET['modificarTabla']) && !isset($_GET['validarelim'])&& !isset($_GET['actual'])&& !isset($_GET['desplegarTabla'])&& !isset($_GET['agregarvideo'])&& !isset($_GET['editarvideo']))
{
    include('menu.php');
    }
    
    ?>
   <script>
  
  $( document ).ready(function() {
    $("#dispositivoMenu").removeClass( "active" );
    $("#videosMenu").removeClass( "active" );
    $("#playlistMenu").addClass( "active" );
});
   </script>
<div id="divPlaylist" > 
<?php

tablaPlaylist($conexion);

?>
</div>

</div>




    <!--form action="subir-video.php" method="post" enctype="multipart/form-data">
Archivo: <input type="file" name="filename" />
<input type="submit" value="Subir" />
</form-->

    </body>
</html>		
<?php
}

?>