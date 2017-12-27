<?php
ob_start();
@session_start();
function x($var) {
    echo '<pre>', print_r($var,1), '</pre>';
}
function xd($var) {
    echo '<pre>', var_dump($var), '</pre>';
}
$configCore = 'lib/bootstrap.php';
if (!file_exists($configCore)) {
    exit('Error: bootstrap not found!');
}
include ($configCore);
$layoutClear = true;
if( isset( $_GET['ajax'] ) ) { 
    header("Content-type: application/xml; charset=iso-8859-1");    
} else if( isset( $_GET['json'] ) ) {    
    header('Content-Type: application/json; charset=utf-8');
} else if (!isset($_REQUEST['layoutClear'])) {
    $layoutClear = false;
    header('Content-Type: text/html; charset=utf-8');
    include('app/view/header.php');
}

if ( isset( $_REQUEST['c'] ) ) {
    $classe = ucfirst($_REQUEST['c']);
} else {
    $classe = ucfirst(DEFAULT_CLASS); // Classe padrao
}

if ( isset( $_REQUEST['m'] ) ) {
    $metodo = $_REQUEST['m'];
} else {
    $metodo = DEFAULT_METHOD; // Metodo padrao
}

/**
 * Somente classes controller que podem ser
 * instanciadas na front controller
 */
$classe .= 'Controller';
$classe2inc = 'app/controller/' . $classe . '.php';

try {	
    //_________ Chamada da classe _________
    if( !file_exists( $classe2inc ) ) {
        throw new Exception( 'arquivo de classe ( '.$classe2inc.' ) inexistente!' );
    }
    include_once( $classe2inc );

    if( !class_exists( $classe ) ) {
        throw new Exception( 'classe ( '.$classe.' ) inexistente!' );
    }
    $instancia = new $classe;
    //________ Chamada do método _________
    if( !method_exists( $instancia, $metodo ) ) {
        throw new Exception( 'ação "'.$metodo.'" não encontrada!' );
    }
    $instancia->$metodo();
	
} catch ( Exception $e ) {
    echo '<h3>'.$e->getMessage().'</h3>';
}

if( !$layoutClear ) {
    include('app/view/footer.php');
}
ob_end_flush();
?>