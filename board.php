<?php
//session_start();
include("clases/Funciones.class.php");
$funciones = new Funciones;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximun-scale=1">
<title>EasyTask | Gestión visual de tareas</title>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
</head>

<body style="background-color: #E6E6E6;">

<nav class="navbar navbar-default navbar-fixed">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
	        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
        	</button>
        	<a class="navbar-brand" href="#">EasyTasks</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
            </li>
        </ul>-->
        <div class="row">
        	<div class="col-md-4 col-md-offset-4">           	
            	<h5 class="text-right">Bienvenido <?php echo $_SESSION['nombreUsuario']; ?></h5>            	
            </div>
            <div class="col-md-2">
            	<a href="logout.php"><button type="button" class="btn btn-default">Cerrar Sesión</button></a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</nav>

<header>
    <div class="container">
    	<div class="row">
        	<div class="col-md-12 text-center">
        	   <h2>Tablero de tareas</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
            	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalCreaTarjeta"><span class="glyphicon glyphicon-plus"></span></button>
        	</div>
        </div>        
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed" style="box-shadow: 10px 10px 5px lightgrey;">
                <tr>
                    <th class="text-center" style="background-color: #F7FE2E;">PENDIENTES</th>
                </tr>
                <?php $arreglo=$funciones->muestraTarjetaPendientes(); ?>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed" style="box-shadow: 10px 10px 5px lightgrey;">
                <tr>
                    <th class="text-center" style="background-color: #2E2EFE">EN DESARROLLO</th>
                </tr>
                <?php $funciones->muestraTarjetaEnDesarrollo(); ?>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed" style="box-shadow: 10px 10px 5px lightgrey;">
                <tr>
                    <th class="text-center" style="background-color: #2EFE2E">TERMINADAS</th>
                </tr>
                <?php $funciones->muestraTarjetaTerminadas(); ?>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed" style="box-shadow: 10px 10px 5px lightgrey;">
                <tr>
                    <th class="text-center" style="background-color: #FE2E2E">IMPEDIDAS</th>
                </tr>
                <?php $funciones->muestraTarjetaImpedidas(); ?>
            </table>
        </div>
    </div>
    <!--Inicio modal ADD tarjeta-->
    <div class="modal fade" id="modalCreaTarjeta" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear Tarjeta</h4>
                    <small>(*) Campos obligatorios</small>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="pagina" value="creaTarjeta" /><!--Variable oculta para identificar en el controlador-->
                        <div class="form-group">
                            <label for="cboTarea">Tarea (*)</label>
                            <select class="form-control" id="cboTarea" name="cboTarea">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboTarea(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtSolicitante">Solicitante (*)</label>
                            <select class="form-control" id="txtSolicitante" name="txtSolicitante">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboCliente(); ?>
                            </select>
                        </div>              
                        <div class="form-group">
                            <label for="cboPrioridad">Prioridad (*)</label>
                            <select class="form-control" id="cboPrioridad" name="cboPrioridad">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboPrioridad(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cboEstado">Estado (*)</label>
                            <select class="form-control" id="cboEstado" name="cboEstado">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboEstTarjeta(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtObservaciones">Observaciones</label>
                            <textarea class="form-control" id="txtObservaciones" name="txtObservaciones" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fileAdjunto">Archivo adjunto</label>
                            <input type="file" id="fileAdjunto"  name="fileAdjunto">
                        </div>                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="validaTarjeta();">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal ADD tarjeta-->
    <!--Inicio modal DETALLE tarjeta-->
    <div class="modal fade" id="modalDetalleTarjeta" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="nombreTarea" class="modal-title"></h4>
                </div>
                <div class="modal-body">
                	<p id="solicitante"></p>
                	<p id="fechaSolicitud"></p>
                	<p id="prioridad"></p>
                	<p id="observaciones"></p>
                    <form id="form">
                        <input type="hidden" name="pagina" value="creaTarjeta" /><!--Variable oculta para identificar en el controlador-->
                        <?php if ($_SESSION['perfil'][0] != 3) { ?><!--Oculta esta entrada del perfil 'usuario'-->
                        <div class="form-group">
                            <label for="cboEstado">Estado (*)</label>
                            <select class="form-control" id="cboEstado" name="cboEstado">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboEstTarjeta(); ?>
                            </select>
                        </div>
                        <?php } ?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="validaTarjeta();">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal DETALLE tarjeta-->
</div>

<div class="panel-footer navbar-fixed-bottom">
    <div class="container">
        <p>EasyTask® 2017 | Miguel Pinto - Miguel Inzunza - Hans Silva | Todos los derechos reservados</p>
    </div>
</div>

</body>
</html>