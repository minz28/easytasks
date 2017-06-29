<?php
include('../clases/Funciones.class.php');
$controlador = new Funciones;

switch($_REQUEST['pagina']){
    
    case 'login':
    
        //echo "hola, vas bien encamidado pequeño padawan :D";
        if($respuesta = $controlador->validaLogin($_POST)){
            session_start();
            $_SESSION['idUsuario'] = $respuesta['idUsuario'];
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

    case 'editaTarjeta':
    
        $respuesta = $controlador->editaTarjeta($_POST);
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

    case 'editaUsuario':
    
        $respuesta = $controlador->editaUsuario($_POST);
        if($respuesta == 1){
            header("location:../listaUsuario.php");
        }
        
    break;

    case 'eliminaUsuario':
    
        $respuesta = $controlador->eliminaUsuario($_POST);
        if($respuesta == 1){
            header("location:../listaUsuario.php");
        }
        
    break;

    case 'creaSolicitante':
    
        $respuesta = $controlador->creaSolicitante($_POST);
        if($respuesta == 1){
            header("location:../listaCliente.php");
        }
        
    break;

    case 'editaSolicitante':
    
        $respuesta = $controlador->editaSolicitante($_POST);
        if($respuesta == 1){
            header("location:../listaCliente.php");
        }
        
    break;

    case 'eliminaSolicitante':
    
        $respuesta = $controlador->eliminaSolicitante($_POST);
        if($respuesta == 1){
            header("location:../listaCliente.php");
        }
        
    break;

    case 'creaCategoria':
    
        $respuesta = $controlador->creaCategoria($_POST);
        if($respuesta == 1){
            header("location:../listaArea.php");
        }
        
    break;

    case 'editaCategoria':
    
        $respuesta = $controlador->editaCategoria($_POST);
        if($respuesta == 1){
            header("location:../listaArea.php");
        }
        
    break;

    case 'eliminaCategoria':
    
        $respuesta = $controlador->eliminaCategoria($_POST);
        if($respuesta == 1){
            header("location:../listaArea.php");
        }
        
    break;

    case 'creaSistema':
    
        $respuesta = $controlador->creaSistema($_POST);
        if($respuesta == 1){
            header("location:../listaSistema.php");
        }
        
    break;

    case 'editaSistema':
    
        $respuesta = $controlador->editaSistema($_POST);
        if($respuesta == 1){
            header("location:../listaSistema.php");
        }
        
    break;

    case 'eliminaSistema':
    
        $respuesta = $controlador->eliminaSistema($_POST);
        if($respuesta == 1){
            header("location:../listaSistema.php");
        }
        
    break;

    case 'asignaTarjeta':
        
        $respuesta = $controlador->asignaTarjeta($_POST);
        if($respuesta == 1){
            header("location:../board.php");
        }

    break;

    case 'autoAsignaTarjeta':
        
        $respuesta = $controlador->autoAsignaTarjeta($_POST);
        if($respuesta == 1){
            header("location:../board.php");
        }

    break;
    
    case 'creaPregunta':
    
        $respuesta = $controlador->creaPregunta($_POST);
        if($respuesta == 1){
            header("location:../listaPreguntas.php");
        }
        
    break;

    case 'editaPregunta':
        
        $respuesta = $controlador->editaPregunta($_POST);        
        if($respuesta == 1){
            header("location:../listaPreguntas.php");
        }

    break;

    case 'eliminaPregunta':
    
        $respuesta = $controlador->eliminaPregunta($_POST);
        if($respuesta == 1){
            header("location:../listaPreguntas.php");
        }

    break;

    case 'creaEncuesta':
    
        $respuesta = $controlador->creaEncuesta($_POST);
        if($respuesta == 1){
            header("location:../listaEncuesta.php");
        }
        
    break;

    case 'editaEncuesta':
        
        $respuesta = $controlador->editaEncuesta($_POST);        
        if($respuesta == 1){
            header("location:../listaEncuesta.php");
        }

    break;

    case 'eliminaEncuesta':
    
        $respuesta = $controlador->eliminaEncuesta($_POST);
        if($respuesta == 1){
            header("location:../listaEncuesta.php");
        }

    break;

}

?>