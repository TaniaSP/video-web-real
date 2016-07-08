function showMunicipios(pagina, nombre, valor, etiqueta)
{

  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=
	function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	  {
		document.getElementById(etiqueta).innerHTML=xmlhttp.responseText;
	  }
	}
  xmlhttp.open("GET",pagina+".php?"+nombre+"="+valor,true);
  xmlhttp.send();
}

function showUsuarios(pagina, nombre, valor, etiqueta)
{
 if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=
	function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	  {
		document.getElementById(etiqueta).innerHTML=xmlhttp.responseText;
	  }
	}

  xmlhttp.open("GET",pagina+".php?"+nombre+"="+valor,true);
  xmlhttp.send();
}




function llamadaAjax(pagina, valores, etiqueta)
{
 if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  } 
  xmlhttp.onreadystatechange=
	function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	  {
		 document.getElementById(etiqueta).innerHTML=xmlhttp.responseText;
	  }
	}
    valores =  valores.replace(/#/g, "");
    alert(valores);
  xmlhttp.open("GET",pagina+".php?"+valores,true);
  xmlhttp.send();
}


// window.document.onkeydown = function (e)
// {
// if (!e){
    // e = event;
// }
// if (e.keyCode == 27){
        // carrito_close();
    // }
// }
function carrito_open(){
    window.scrollTo(0,0);
    document.getElementById('carrito').style.display='block';
    document.getElementById('fade').style.display='block';  
}
function carrito_close(){
    document.getElementById('carrito').style.display='none';
    document.getElementById('fade').style.display='none';
}




