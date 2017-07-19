<?php
include('../clases/Funciones.class.php');
$controlador = new Funciones;

switch($_REQUEST['pagina']){
    
    case 'login':
    
        if($respuesta = $controlador->validaLogin($_POST)){
            #session_start();
            $_SESSION['existe'] = true;
            $_SESSION['idUsuario'] = $respuesta['idUsuario'];
            $_SESSION['nombreUsuario'] = $respuesta['nombreUsuario'];
            $_SESSION['empresa'] = $respuesta['empresa'];
            $_SESSION['descripcionEmpresa'] = $respuesta['descripcionEmpresa'];
            $_SESSION['perfil'] = $respuesta['perfil'];
            $encuesta = $controlador->validaExistenciaEncuesta();
            if ($encuesta == 0) {
            	$_SESSION['idEncuesta'] = 0;
            } else {
            	$_SESSION['idEncuesta'] = $encuesta;
            }
            //var_dump($_SESSION); die();
            $respuesta2 = $controlador->validaTareaVigente();
            if($respuesta2 == 0){	//NO EXISTE TAJETA ASIGNADA
            	$_SESSION['tarjetaVigente'] = 0;
                header("location:../board.php");
            } else {	//SI EXISTE TARJETA ASIGNADA
                $_SESSION['idTarjetaVigente'] = $respuesta2['idTarjeta'];
                //$_SESSION['fechaInicioTarjeta'] = $respuesta['fechaInicio'];
                $_SESSION['tarjetaVigente'] = 1;                
                $fechaInicioTarjeta = $respuesta2['fechaInicio'];
                if($_SESSION['perfil'] == 2){
                	header("location:../board.php");
                } elseif ($_SESSION['perfil'] == 3) {
                	if ($fechaInicioTarjeta == '0000-00-00') {
                		header("location:../aceptarTarjetaAsignada.php");
                	} elseif ($fechaInicioTarjeta != '0000-00-00') {
                		header("location:../tareaVigente.php");
                	}                	
                }
            }
        }
        elseif($respuesta == 0){
        	echo "<script>";
        	echo "alert('Usuario no existe en el sistema.');";
        	echo "window.location='../index.php';";        	
        	echo "</script>";
            //header("location:../index.php");
        }

    break;

    case 'creaTarjeta':
    
        $respuesta = $controlador->creaTarjeta($_POST);
        if($respuesta == 1){
            if ($_SESSION['perfil'] == 2) {
                header("location:../board.php");
            } elseif ($_SESSION['perfil'] == 3){
                header("location:../tareaVigente.php");
            }
            
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
            header("location:../tareaVigente.php");
        }

    break;
    
    case 'finalizaTarea':
        
        $respuesta = $controlador->finalizaTarea();
        if($respuesta == 1){
            header("location:../board.php");
        }

    break;

    case 'reactivarImpedida':
        
        $respuesta = $controlador->reactivarImpedida($_POST);
        if($respuesta == 1){
            header("location:../board.php");
        }

    break;

    case 'eliminarImpedida':
        
        $respuesta = $controlador->eliminarImpedida($_POST);
        if($respuesta == 1){
            header("location:../board.php");
        }

    break;

    case 'iniciarTarjeta':
        
        $respuesta = $controlador->iniciarTarjeta();
        if($respuesta == 1){
            header("location:../tareaVigente.php");
        }

    break;
    
    case 'validaRazonImpedimento':
        
        $respuesta = $controlador->validaRazonImpedimento($_POST);
        if($respuesta == 1){
            header("location:../board.php");
        }

    break;

    case 'verificaTarjetaAsignada':
    	
    	$respuesta = $controlador->validaTareaVigente();
    	if($respuesta == 0) {
    		echo "<script>";
        	echo "alert('Actualmente no cuenta con tarjetas asignadas');";
        	echo "window.location='../board.php';";        	
        	echo "</script>";
    	} else {
    		$_SESSION['tarjetaVigente']=1;
			$_SESSION['idTarjetaVigente']=$respuesta['idTarjeta'];
			$fechaInicioTarjeta = $respuesta['fechaInicio'];
			if($fechaInicioTarjeta == '0000-00-00'){
				header("location:../aceptarTarjetaAsignada.php");
			} elseif ($fechaInicioTarjeta != '0000-00-00') {
				if($_SESSION['perfil'] == 2){
					header("location:../board.php");
				}
			}    		
    	}

    break;

    //INSTRUCCIONES RELACIONADAS CON ENCUESTA
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

    case 'asignaPregunta':
        
        $respuesta = $controlador->asignaPregunta($_POST);
        if($respuesta == 1){
            //header("location:../listaEncuesta.php");
            header("location:../detalleEncuesta.php?encuesta=".$_POST['idEncuesta']);
        }

    break;

    case 'borraPreguntaEncuesta':
        
        $respuesta = $controlador->borraPreguntaEncuesta($_GET);
        if($respuesta == 1){
            header("location:../detalleEncuesta.php?encuesta=".$_GET['encuesta']);
        }

    break;

    case 'publicaEncuesta':
        
        $respuesta = $controlador->publicaEncuesta($_GET['idEncuesta']);
        if($respuesta == 1){
            header("location:../listaEncuesta.php");
        }

    break;

    case 'respondeEncuesta':
        $controlador->guardaResultadoEncuesta($_POST);
    break;

    case 'respondeEncuestaCoordinador':
        $controlador->guardaResultadoEncuestaCoordinador($_POST);
    break;

    case 'editaPuntajeFinal':
        $respuesta = $controlador->editaPuntajeFinal($_POST);
        if($respuesta == 1){
            header("location:../detalleListaEncuesta.php?encuesta=$_POST[idEncuestaEdit]");
        }
    break;

    //INSTRUCCIONES RELACIONADAS CON DASHBOARDS



}

?>