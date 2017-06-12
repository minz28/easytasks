<?php
//session_start();
include("clases/Funciones.class.php");
include ("constantes.php");
$funciones = new Funciones;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximun-scale=1">
<title><?php echo TITULO; ?></title>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
</head>

<body style="background-color: #E6E6E6;">

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <?php include("menu.php"); ?>
        <div class="col-md-6">
	        <h5 class="text-right">Bienvenido <?php echo $_SESSION['nombreUsuario']; ?>
	        &nbsp;<a href="logout.php"><button type="button" class="btn btn-default">Cerrar Sesión</button></a></h5>
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
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalCreaTarjeta"><span class="glyphicon glyphicon-plus"></span></button><br><br>
    </div>
    <div class="row">
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed" style="box-shadow: 10px 10px 5px lightgrey;">
                <tr>
                    <th class="text-center" style="background-color: #F7FE2E;">PENDIENTES</th>
                </tr>
                <?php $funciones->muestraTarjetaPendientes(); ?>
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

<div class="container-fluid">
    <div class="panel-footer">
        <p>EasyTask® 2017 | Miguel Pinto - Miguel Inzunza - Hans Silva | Todos los derechos reservados</p>
    </div>
</div>

</body>
</html>