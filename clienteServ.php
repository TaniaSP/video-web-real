<?php/*
require_once('lib/nusoap.php');
 
$client = new nusoap_client('http://adminvideos.tk/server.php');
$err = $client->getError();
if ($err) {
 echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
 
$param = array('id'=>'1','pass'=>'moises');
$result = $client->call('playlist',$param);
 
if ($client->fault) {
 echo '<h2>Fault</h2><pre>';
  print_r($result);
 echo '</pre>';
} else {
 // Check for errors
 $err = $client->getError();
 if ($err) {
  // Display the error
  echo '<h2>Error</h2><pre>' . $err . '</pre>';
 } else {
  // Display the result
  echo '<h2>Result</h2><pre>';
   print_r($result);
  echo '</pre>';
 }
}
 
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
*/
?>
<?php
require_once('webservice/lib/nusoap.php');
    $cliente = new nusoap_client("http://adminvideos.tk/webservice/server.php");
      
    $error = $cliente->getError();
    if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    }
      
    $result = $cliente->call("playlist", array("id" => "1", "pass"=>"moises"));
      
    if ($cliente->fault) {
        echo "<h2>Fault</h2><pre>";
        print_r($result);
        echo "</pre>";
    }
    else {
        $error = $cliente->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        }
        else {
            echo "<h2>Programacion dispositivo</h2><pre>";
            echo $result;
            echo "</pre>";
        }
    }
    $result = $cliente->call("registrarse", array("pass" => "chakemoi", "descripcion"=>"kjsdfhkjhfsdf","latitud"=>"10.6512" , "longitud"=>"110.6512" ));
      
    if ($cliente->fault) {
        echo "<h2>Fault</h2><pre>";
        print_r($result);
        echo "</pre>";
    }
    else {
        $error = $cliente->getError();
        if ($error) {
            echo "<h2>Error</h2><pre>" . $error . "</pre>";
        }
        else {
            echo "<h2>Reproduccion</h2><pre>";
            echo $result;
            echo "</pre>";
        }
    }
?>