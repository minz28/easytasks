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

<body style="background-color:#EAEAEA;">

<header>
    <div class="container">
    	<div class="row">
        	<div class="col-md-4">
        	   <h4>Tablero de tareas</h4>
            </div>
            <div class="col-md-6">           	
            	<h5 class="text-right">Bienvenido <?php echo $_SESSION['nombreUsuario']; ?></h5>            	
            </div>
            <div class="col-mod-2">
            	<a href="logout.php"><button type="button" class="btn btn-default">Cerrar Sesión</button></a>
            </div>
        </div>        
    </div>
</header>

<div class="container">
    <div class="row">
    	<div class="col-md-1">
    		<a href="creaTarjeta.php" id="popup"><img src="img/site/add.png" style="width: 50px;"></a>
    		<!--<button id="popup" onclick="div_show()">Popup</button>-->
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed">
                <tr>
                    <th class="warning text-center">PENDIENTES</th>
                </tr>
                <?php $funciones->muestraTarjetaPendientes(); ?>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed">
                <tr>
                    <th class="info text-center">EN DESARROLLO</th>
                </tr>
                <?php $funciones->muestraTarjetaEnDesarrollo(); ?>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed">
                <tr>
                    <th class="success text-center">TERMINADAS</th>
                </tr>
                <?php $funciones->muestraTarjetaTerminadas(); ?>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-bordered table-hover table-condensed">
                <tr>
                    <th class="danger text-center">IMPEDIDAS</th>
                </tr>
                <?php $funciones->muestraTarjetaImpedidas(); ?>
            </table>
        </div>            
    	<?php //$funciones->muestraTablero(); ?>
        <!--<div class="col-md-12">
        	<table class="table table-bordered table-hover table-condensed">
    			<tr>
    				<th class="success">Pendiente</th>
    				<th class="warning">En desarrollo</th>
    				<th class="danger">Terminada</th>
    				<th class="info">Impedida</th>
    			</tr>
    			<?php $funciones->muestraTablero();?>
    			<tr>
    				<td class="success">a</td>
    				<td class="warning">b</td>
    				<td class="danger">c</td>
    				<td class="info">d</td>
    			</tr>    			
    		</table>
    	<!--</div>-->
    </div>
</div>
<!--
<div class="container" id="formTarea" style="display: block;">
	<div class="row">
		<div class="col-md-3">
			<form>
				<div class="form-group">
					<label for="selectTarea">Tarea</label>
					<select class="form-control" id="selectTarea">
						<option>Seleccione</option>
						<option>a</option>
						<option>b</option>
						<option>c</option>
					</select>
				</div>
				<div class="form-group">
					<label for="textSolicitante">Solicitante</label>
					<input type="text" class="form-control" id="textoSolicitante" placeholder="Solicitante">
				</div>
				<div class="form-group">
					<label for="textDias">Días estimados de duración</label>
					<input type="text" class="form-control" id="textDias" placeholder="Días estimados">
				</div>
				<div class="form-group">
					<label for="textHoras">Horas estimadas de duración</label>
					<input type="text" class="form-control" id="textoSolicitante" placeholder="Horas estimadas">
				</div>
				<div class="form-group">
					<label for="selectPrioridad">Prioridad</label>
					<select class="form-control" id="selectPrioridad">
						<option>Seleccione</option>
						<option>a</option>
						<option>b</option>
						<option>c</option>
					</select>
				</div>
				<div class="form-group">
					<label for="selectEstado">Estado</label>
					<select class="form-control" id="selectEstado">
						<option>Seleccione</option>
						<option>a</option>
						<option>b</option>
						<option>c</option>
					</select>
				</div>
				<div class="form-group">
					<label for="textObservaciones">Observaciones</label>
					<textarea class="form-control" id="textObservaciones" rows="4"></textarea>
				</div>
				<div class="form-group">
					<label for="fileAdjunto">Archivo adjunto</label>
					<input type="file" id="fileAdjunto">
				</div>				
			</form>
		</div>		
	</div>
</div>
-->
<div class="panel-footer navbar-fixed-bottom">
    <div class="container">
        <p>EasyTask® 2017 | Miguel Pinto - Miguel Inzunza - Hans Silva | Todos los derechos reservados</p>
    </div>
</div>

</body>
</html>