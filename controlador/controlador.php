<?php
include('../clases/Funciones.class.php');
$controlador = new Funciones;

switch($_REQUEST['pagina']){
    
    case 'login':
    
        //echo "hola, vas bien encamidado pequeño padawan :D";
        if($respuesta = $controlador->validaLogin($_POST)){
            session_start();
            $_SESSION['nombreUsuario'] = $respuesta['nombreUsuario'];
            $_SESSION['empresa'] = $respuesta['empresa'];
            $_SESSION['perfil'] = $respuesta['perfil'];
            header("location:../board.php");
        }
        elseif($respuesta == 0){            
            header("location:../index.php?mensaje=noexiste");
        }

    break;

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
            header("location:../listaTarea.php");
        }
        
    break;

    case 'editaTarea':
        
        $respuesta = $controlador->editaTarea($_POST);        
        if($respuesta == 1){
            header("location:../listaTarea.php");
        }

    break;

    case 'eliminaTarea':
    
        $respuesta = $controlador->eliminaTarea($_POST);
        if($respuesta == 1){
            header("location:../listaTarea.php");
        }

    break;

    case 'creaUsuario':
    
        $respuesta = $controlador->creaUsuario($_POST);
        if($respuesta == 1){
            header("location:../listaUsuario.php");
        }
        
    break;



}

?>