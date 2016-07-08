<?php
		
	//Create a complex type
	$server->wsdl->addComplexType('TPlaylist','complexType','struct','all','',
        array( 'id_video' => array('name' => 'id_video','type' => 'xsd:string'),
               'id_dis' => array('name' => 'id_dis','type' => 'xsd:string'),
               'orden' => array('name' => 'orden','type' => 'xsd:string')));
			   
			   
	// Definición de métodos en nuestro servicio web -------------------------------------------
/*
	$server->register(
	    'playlist',                		  // Nombre del método
	    array('id' => 'xsd:string'),      // Parámetros de entrada
	    array('return' => 'xsd:string'),      // Parámetros de salida
	    SOAP_SERVER_NAMESPACE,                // Nombre del workspace
	    SOAP_SERVER_NAMESPACE.'#playlist',        // Acción soap
	    'rpc',                                // Estilo
	    'encoded',                            // Uso
	    'Login'       	  // Documentación
	);
	*/
$server->register(
                'playlist',				                		  // Nombre del método
                array('id' => 'xsd:string', 'pass' => 'xsd:string'), // Parámetros de entrada
                array('return'=>'tns:TPlaylist'), 					// Parámetros de salida
				SOAP_SERVER_NAMESPACE,								//Nombre del workspace
				SOAP_SERVER_NAMESPACE.'#playlist',        // Acción soap
				'rpc',                                // Estilo
				'encoded',                            // Uso
				'Programacion Dispositivos'       	  // Documentación
	);

?>
