<?php
	// Definición de tipos en nuestro servicio web -------------------------
	// Definición de métodos en nuestro servicio web -------------------------------------------

	$server->register(
	    'playlist',                		  // Nombre del método
	    array('id' => 'xsd:string', 'pass' => 'xsd:string'),      // Parámetros de entrada
	    array('return' => 'xsd:string'),      // Parámetros de salida
	    SOAP_SERVER_NAMESPACE,                // Nombre del workspace
	    SOAP_SERVER_NAMESPACE.'#playlist',        // Acción soap
	    'rpc',                                // Estilo
	    'encoded',                            // Uso
	    'Programacion de los dispositivos'       	  // Documentación
	);
	$server->register(
	    'reproduccion',                		  // Nombre del método
	    array('id_dispositivo' => 'xsd:string', 'pass' => 'xsd:string', 'id_video' => 'xsd:string', 'hora' => 'xsd:string', 'fecha' => 'xsd:string' ),      // Parámetros de entrada
	    array('return' => 'xsd:string'),      // Parámetros de salida
	    SOAP_SERVER_NAMESPACE,                // Nombre del workspace
	    SOAP_SERVER_NAMESPACE.'#reproduccion',        // Acción soap
	    'rpc',                                // Estilo
	    'encoded',                            // Uso
	    'Programacion de los dispositivos'       	  // Documentación
	);
	
	$server->register(
	    'autentifica',                		  // Nombre del método
	    array('id' => 'xsd:string', 'pass' => 'xsd:string'),      // Parámetros de entrada
	    array('return' => 'xsd:string'),      // Parámetros de salida
	    SOAP_SERVER_NAMESPACE,                // Nombre del workspace
	    SOAP_SERVER_NAMESPACE.'#autentifica',        // Acción soap
	    'rpc',                                // Estilo
	    'encoded',                            // Uso
	    'Login'       	  // Documentación
	);
	$server->register(
	    'registrarse',                		  // Nombre del método
	    array('pass'=>'xsd:string','descripcion' => 'xsd:string', 'latitud' => 'xsd:string', 'longitud' => 'xsd:string' ),      // Parámetros de entrada
	    array('return' => 'xsd:string'),      // Parámetros de salida
	    SOAP_SERVER_NAMESPACE,                // Nombre del workspace
	    SOAP_SERVER_NAMESPACE.'#registrarse',        // Acción soap
	    'rpc',                                // Estilo
	    'encoded',                            // Uso
	    'Programacion de los dispositivos'       	  // Documentación
	);
?>