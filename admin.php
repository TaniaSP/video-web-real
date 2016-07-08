<?php
include('basedatos/conexion.php');
include('basedatos/dispositivo.php');
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
$numpags = 0;
$rowindex=-1;
$actual=1;
$descripcion="";
function tablaDispositivos($conexion)
{
	global $rowindex, $numpags, $usuarioContra, $usuarioNombre;
    $dispositivos  = dispositivo::tablaDispositivos($conexion->id);
    ?>
<h1>Dispositivos</h1>
<hr />
<table class='tabla' cellpadding="5">
<thead><tr><th>id</th><th>Descripcion</th><th>Lat</th><th>Long</th><th></th><th></th></tr></thead>
<tbody>
<tr>
<td id="alta"></td>
<td id="alta"><input type="text" id="descripcion" name="descripcion" maxlength="30"/></td>
<td id="alta"></td>
<td id="alta"></td>

<td ><input type="button" name="nuevo" class="botonEditar" id="nuevo" value="Agregar" class="button"
    onclick="validar(descripcion.value, 'i','')"	/></td><td></td>
</tr>
<?php
$idmarca= 0;
$i=2;
foreach($dispositivos as $row){
    if ($rowindex != $i){
        echo "<tr><td>".$row->id."</td>";
        echo "<td>".$row->descripcion." </td>";
        echo "<td>".$row->latitud."</td>";
        echo "<td>".$row->longitud."</td>";
        echo "<td><input type='button' name='editar' class='botonEditar' id='editar' value='Editar' ".
            "onclick=\"llamadaAjax('admin','modificarTabla=1&usuarioNombre=$usuarioNombre&usuarioContra=$usuarioContra&row='+(this.parentNode.parentNode.rowIndex), 'divDispositivos')\" /></td>";
        echo "<td><a style='width:95px' class='botonEditar' href='/playlist.php?usuarioNombre=tania&usuarioContra=moitania&dispositivo=$row->id' >Abrir Playlist</a></td></tr>";
    } 
    else
    {
        echo '<td>'.$row->id.'</td>';
        echo '<td><input type="text" id="descripcionm" name="descripcionm" value="'.$row->descripcion.'" /></td>';
        echo "<td>".$row->latitud."</td><td>".$row->longitud."</td>";
        echo "<td><input type='button' name='guardar' class='botonEditar' id='guardar' value='Guardar' ".
             " onclick=\"validar(descripcionm.value, 'm', '$row->id')\";' />".
             "</br><input type='button' name='cancelar' id='cancelar' class='botonEliminar' value='Cancelar' onclick=\"llamadaAjax('admin','desplegarTabla=1&usuarioNombre=$usuarioNombre&usuarioContra=$usuarioContra', 'divDispositivos');\"</td></tr>";
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
    tablaDispositivos($conexion);
    return;
}  
if (isset($_GET['modificarTabla'])){
$rowindex = $_GET['row'];
tablaDispositivos($conexion);
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
                      	<link type="text/css" href="css/estiloGeneral.css" rel="stylesheet" title='Default' >
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
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
			llamadaAjax('admin','insertar=1&usuarioNombre=<? echo $usuarioNombre?>&usuarioContra=<? echo $usuarioContra?>&descripcion='+descripcion,'divDispositivos');
        }
		else
			llamadaAjax('admin','modificar=1&usuarioNombre=<? echo $usuarioNombre?>&usuarioContra=<? echo $usuarioContra?>&descripcion='+descripcion+'&idDisp='+clave,'divDispositivos');
		return true;
	}
	
	</script>
    </head>
    <body>
    <div id='contenido'>
    
    <?
if (!isset($_GET['eliminar']) && !isset($_GET['insertar']) && !isset($_GET['modificar']) 
 && !isset($_GET['modificarTabla']) && !isset($_GET['validarelim'])&& !isset($_GET['actual'])&& !isset($_GET['desplegarTabla']))
{
    include('menu.php');

    }
    
    ?>

<div id="divDispositivos" > 
   <script>
  
  $( document ).ready(function() {
    $("#playlistMenu").removeClass( "active" );
    $("#videosMenu").removeClass( "active" );
    $("#dispositivoMenu").addClass( "active" );
});
   </script>
<?php

tablaDispositivos($conexion);
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