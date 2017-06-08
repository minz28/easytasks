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
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
        	</button>
        	<a class="navbar-brand" href="#">EasyTasks</a>
        </div>
        <?php if ($_SESSION['perfil'][0] != 3) { ?><!--Oculta este menú del perfil 'usuario'-->
        <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse" id="bs-example-navbar-collapse-1">
	        <ul class="nav navbar-nav">
	            <!--<li><a href="#">Link</a></li>
	            <li><a href="#">Link</a></li>
	            <li><a href="#">Link</a></li>-->
	            <li class="dropdown">
	                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mantención<span class="caret"></span></a>
	                <ul class="dropdown-menu">
	                    <li><a href="#" title="Usuarios del sistema">Usuarios</a></li>
	                    <li role="separator" class="divider"></li>
	                    <li><a href="#" title="Actores solicitantes de tareas de la empresa (tabla Cliente)">Solicitantes</a></li>
	                    <li role="separator" class="divider"></li>
	                    <li><a href="#" title="Áreas de negocio de la tarea">Áreas de tarea (Categoría)</a></li>                    
	                    <li><a href="#" title="Sistemas que se ven afectados por la tarea">Sistemas</a></li>
	                    <li><a href="creaTarea.php" title="Tareas">Tareas</a></li>
	                </ul>
	            </li>
	            <li><a href="#">Bitácora</a></li>
	        </ul>
	    </div>
        <?php } ?>
        <h5 class="text-right">Bienvenido <?php echo $_SESSION['nombreUsuario']; ?>
        <a href="logout.php">&nbsp;<button type="button" class="btn btn-default">Cerrar Sesión</button></a></h5>
    </div><!-- /.container-fluid -->
</nav>

<header>
    <div class="container">
    	<div class="row">
        	<div class="col-md-12 text-center">
        	   <h2>Mantenedor de Tareas</h2>
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