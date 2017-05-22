<?php
include('../clases/Funciones.class.php');
$controlador = new Funciones;

switch($_POST['pagina']){
    
    case 'creaTarjeta':
    
        //echo "hola, vas bien encamidado pequeño padawan :D";
        $respuesta = $controlador->creaTarjeta($_POST);
        if($respuesta == 1){        	
            header("location:../board.php");
        }

    break;

    case 'creaTarea':
    
        $respuesta = $controlador->creaTarea($_POST);
        if($respuesta == 1){
            header("location:../board.php");
        }
        
    break;



}

?>