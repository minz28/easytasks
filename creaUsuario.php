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
			<h2>Crear usuario</h2>
            <small>(*) Campos obligatorios</small>
			<form id="form">
                <input type="hidden" name="pagina" value="creaUsuario" /><!--Variable oculta para identificar en el controlador-->
				<div class="form-group">
					<label for="txtDescripcion">Nombre(s) (*)</label>
					<input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción tarea">
				</div>
				<div class="form-group">
					<label for="txtDescripcion">Apellido(s) (*)</label>
					<input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción tarea">
				</div>
				<div class="form-group">
					<label for="txtDescripcion">E-mail (*)</label>
					<input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción tarea">
				</div>
				<div class="form-group">
					<label for="txtDescripcion">Teléfono (*)</label>
					<input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción tarea">
				</div>
				<div class="form-group">
					<label for="cboCategoria">Perfil (*)</label>
					<select class="form-control" id="cboCategoria" name="cboCategoria">
						<option value="seleccione">Seleccione</option>
						<?php $funciones->cboCategoria(); ?>
					</select>
				</div>
				<div class="form-group">
					<label for="cboSistema">Sistema (*)</label>
					<select class="form-control" id="cboSistema" name="cboSistema">
						<option value="seleccione">Seleccione</option>
						<?php $funciones->cboSistema(); ?>
					</select>
				</div>
				<div class="form-group">
					<label for="txtDescripcion">Descripción (*)</label>
					<input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción tarea">
				</div>
				<div class="form-group">
					<label for="cboDificultad">Dificutad (*)</label>
					<select class="form-control" id="cboDificultad" name="cboDificultad">
						<option value="seleccione">Seleccione</option>
						<?php $funciones->cboDificultad(); ?>
					</select>
				</div>
				<div class="form-group">
					<label for="txtTiempoEstimado">Tiempo estimado predefinido (HH:MM) (*)</label>
					<br>
					<div class="col-md-2">
						<select class="form-control" id="cboHH" name="cboHH">
							<?php
							echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
							for ($i=10; $i<24; $i++) { 
								echo "<option value='".$i."'>".$i."</option>";
							}															
							?>
						</select>
					</div>						
					<div class="col-md-2">
						<select class="form-control" id="cboMM" name="cboMM">
							<?php
							echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
							for ($i=10; $i<60; $i++) { 
								echo "<option value='".$i."'>".$i."</option>";
							}
							?>
						</select>
					</div>
					<!--Asignación de segundos al detalle de tarea
					<div class="col-md-2">
						<select class="form-control" id="cboSS" name="cboSS">
							<?php/*
							echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
							for ($i=10; $i<60; $i++) { 
								echo "<option value='".$i."'>".$i."</option>";
							}*/
							?>
						</select>
					</div>-->
				</div>
				<br><br>
				<button type="button" class="btn btn-default" onclick="validaTarea();">Grabar</button>
			</form>
		</div>		
	</div>
</div>

</body>
</html>