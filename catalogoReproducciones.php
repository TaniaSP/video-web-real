<?php
include('basedatos/conexion.php');
include('basedatos/reproduccion.php');
include('basedatos/video.php');
include('basedatos/dispositivo.php');
$contra = "moitania";
$conexion = new conexion("mysql.hostinger.mx", "u373017502_admin", "moitania", "u373017502_video");
$usuarioContra = "";
$usuarioContra = $_POST["contra"];
$idVideo = "todos";
$idDisp = "todos";
$fechaIni = "";
$fechaFin = "";
if (isset($_GET["usuarioContra"]))
    $usuarioContra = $_GET["usuarioContra"];
if (isset($_GET["idDisp"]))
    $idDisp = $_GET["idDisp"];
if (isset($_GET["fechaIni"]))
    $fechaIni = $_GET["fechaIni"];
if (isset($_GET["fechaFin"]))
    $fechaFin = $_GET["fechaFin"];
if (isset($_GET["idVideo"]))
    $idVideo = $_GET["idVideo"]; 
if (isset($_GET['desplegarTabla'])){
    $idDisp = $_GET["idDisp"];
    $idVideo = $_GET["idVideo"];
    $fechaIni = $_GET["fechaIni"];
    $fechaFin = $_GET["fechaFin"];
    tablaReproccion($conexion, $idVideo, $idDisp, $fechaIni, $fechaFin);
    return;
  }
$usuarioNombre = "";
$usuarioNombre = $_POST["nombre"];
if (isset($_GET["usuarioNombre"]))
{
    
    $usuarioNombre = $_GET["usuarioNombre"];
}

$numpags = 0;
$rowindex=-1;
$actual=1;
$direccion = "/home/u373017502/public_html/videos/";
$nombre="";
function tablaReproccion($conexion, $idVideo, $idDisp, $fechaIni, $fechaFin)
{
	global $rowindex, $numpags;
    $reproducciones  = reproduccion::tablaReproduccionesFiltro($conexion->id, $idVideo, $idDisp, $fechaIni, $fechaFin);
    $videos  = video::tablaVideos($conexion->id);
    $dispositivos  = dispositivo::tablaDispositivos($conexion->id);
	
    ?>
<h1>Reproduccion</h1>
<table width="100%">
    <tr><th>Video</td><td>Dispositivo</td><td>Fecha inicio</td><td>Fecha final</td></tr>
    <tr><?php
        echo "<td><select name='idVideo' id='idVideo' onchange=\"llamadaAjax('catalogoReproducciones','desplegarTabla=1&idDisp=$idDisp&idVideo='+this.value+'&fechaIni='+dateIni.value+'&fechaFin='+dateFin.value,'divReproducciones')\" >"; 
        echo "<option value='todos'>Todos</option>";

        foreach($videos as $row)
        { 

            if ($row->id == $idVideo)
                echo "<option value ='$row->id' selected>$row->nombre</option>";
            else
                echo "<option value ='$row->id'>$row->nombre</option>";
        }
        echo '</select></td>';
        echo "<td><select name='idDisp' id='idDisp' onchange=\"llamadaAjax('catalogoReproducciones','desplegarTabla=1&idVideo=$idVideo&idDisp='+this.value+'&fechaIni='+dateIni.value+'&fechaFin='+dateFin.value,'divReproducciones')\" >"; 
        echo "<option value='todos'>Todos</option>";
        foreach($dispositivos as $row)
        {
            if ($row->id == $idDisp)
                echo "<option value ='$row->id' selected>$row->descripcion</option>";
            else
                echo "<option value ='$row->id'>$row->descripcion</option>";
        
        
        }
        echo '</select></td>'; ?>

       <td><input type="text" name="dateIni" id="dateIni" readonly="readonly" size="12" onchange="llamadaAjax('catalogoReproducciones', 'desplegarTabla=1&idVideo='+idVideo.value+'&idDisp='+idDisp.value+'&fechaIni='+dateIni.value+'&fechaFin='+dateFin.value, 'divReproducciones' )" value="<?php echo $fechaIni; ?>"/></td>
	   <td><input type="text" name="dateFin" id="dateFin" readonly="readonly" size="12" onchange="llamadaAjax('catalogoReproducciones', 'desplegarTabla=1&idVideo='+idVideo.value+'&idDisp='+idDisp.value+'&fechaIni='+dateIni.value+'&fechaFin='+dateFin.value, 'divReproducciones' )" value="<?php echo $fechaFin; ?>" /></td>
    </tr>
</table>
<hr />
<table class='tabla'>
	<thead><tr><th>Id</th><th>nombre</th><th>dispositivo</th><th>Fecha</th><th>Hora</tr></thead>
	<tbody>
<?php
$idmarca= 0;
$i=2;
        if ($reproducciones == NULL){
            return;
        }
foreach($reproducciones as $row){
    if ($rowindex != $i){
        echo "<tr><td>".$row->id_video."</td>";
        echo "<td>".$row->nombre." </td>";
        echo "<td>".$row->id_dispositivo."</td>";
        echo "<td>".$row->Fecha."</td>";
        echo "<td>".$row->Hora."</td></tr>";
    } 
    $i++;
    

}
echo "</tbody>";
echo "</table>";
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
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
 	<script type="text/javascript">
		jQuery(function($){
			$.datepicker.regional['es'] = {
				closeText: 'Cerrar',
				prevText: '&#x3c;Ant',
				nextText: 'Sig&#x3e;',
				currentText: 'Hoy',
				monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
				'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
				'Jul','Ago','Sep','Oct','Nov','Dic'],
				dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
				dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
				weekHeader: 'Sm',
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''};
			$.datepicker.setDefaults($.datepicker.regional['es']);
		});    

		$(document).ready(function() {
		   $("#dateFin").datepicker();
		});
		$(document).ready(function() {
		   $("#dateIni").datepicker();
		});
				
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
    $("#videosMenu").removeClass( "active" );
    $("#reproduccionesMenu").addClass( "active" );
    $("#dispositivoMenu").removeClass( "active" );
	$('body').click(function(event) {
		if ($(event.target).is("#dateIni")) {
			$("#dateIni").datepicker({showOn: 'focus'}).focus();
		}
		if ($(event.target).is("#dateFin")) {
			$("#dateFin").datepicker({showOn: 'focus'}).focus();
		}
	});
	
}); 


   </script> 
   
<div id="divReproducciones" > 
<?php
tablaReproccion($conexion, "", "", "", "");
?>
</div>
   
</div>
   
</form>

    </body>
</html>		
<?php

?>