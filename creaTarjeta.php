<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
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

<body>

<div class="container" id="formTarea" style="display: block;">
	<div class="row">
		<div class="col-md-6">
            <small>(*) Campos obligatorios</small>
			<form id="form">
                <input type="hidden" name="pagina" value="creaTarjeta" /><!--Variable oculta para identificar en el controlador-->
				<div class="form-group">
					<label for="cboTarea">Tarea (*)</label>
					<select class="form-control" id="cboTarea" name="cboTarea">
						<option value="seleccione">Seleccione</option>
						<?php $funciones->cboTarea(); ?>
					</select>
				</div>
				<!--
				<div class="form-group">
					<label for="txtSolicitante">Solicitante</label>
					<input type="text" class="form-control" id="txtSolicitante" name="txtSolicitante" placeholder="Solicitante">
				</div>
				-->
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
				<button type="button" class="btn btn-default" onclick="validaTarjeta();">Grabar</button>
			</form>
		</div>		
	</div>
</div>

</body>
</html>