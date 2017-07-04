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

<body>

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
        	   <h2></h2>
            </div>
        </div>        
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p>Estimado <?php echo $_SESSION['nombreUsuario']; ?>, usted actualmente tiene una tarjeta en desarrollo (<a href="#" data-toggle="modal" data-target="#modalDetalleTarjeta">Ver tarjeta</a>), ¿qué desea hacer?</p>
        </div>
    </div>
    <div class="row">
        <form id="formFinalilzaTarjeta">
            <input type="hidden" name="pagina" id="pagina" value="finalizaTarea" /><!--Variable oculta para identificar en el controlador-->    
        </form>
        <div class="col-md-3 col-xs-12 text-center">
            <button type="button" class="btn btn-default" onclick="finalizaTarea();">Finalizar Tarjeta</button>
        </div>
        <div class="col-md-3 col-xs-12 text-center">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalRazonImpedimento">Declarar Tarjeta Impedida</button>
        </div>
    </div>
    <!--Inicio modal ADD Razon Impedimento-->
    <div class="modal fade" id="modalRazonImpedimento" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ingresar razón de impedimento</h4>
                    <small>(*) Campos obligatorios</small>
                </div>
                <div class="modal-body">
                    <form id="formTarjetaImpedida">
                        <input type="hidden" name="pagina" id="pagina" value="validaRazonImpedimento" /><!--Variable oculta para identificar en el controlador-->
                        <div class="form-group">
                            <label for="cboRazonImpedimento">Motivo de impedimento (*)</label>
                            <select class="form-control" id="cboRazonImpedimento" name="cboRazonImpedimento">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboRazonImpedimento(); ?>
                            </select>
                        </div>
                    </form>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="validaRazonImpedimento();">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal ADD Razon Impedimento-->
    <!--Inicio modal DETALLE tarjeta-->
    <div class="modal fade" id="modalDetalleTarjeta" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <?php $datos=$funciones->verTarjetaAsignada($_SESSION['idTarjetaVigente']); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="nombreTarea" class="modal-title"><?php echo $datos['tarea']; ?></h4>
                </div>
                <div class="modal-body">                    
                    <p id="solicitante">Solicitado por: <?php echo $datos['solicitante']; ?></p>
                    <p id="fechaSolicitud">Fecha de solicitud: <?php echo $datos['fechaSolicitud']; ?></p>
                    <p id="prioridad">Prioridad: <?php echo $datos['prioridad']; ?></p>
                    <p id="observaciones">Observaciones: <?php echo $datos['observaciones']; ?></p>                    
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal DETALLE tarjeta-->
</div>

<?php include("footer.php"); ?>

</body>
</html>