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
					<input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre persona">
				</div>
				<div class="form-group">
					<label for="txtDescripcion">Apellido(s) (*)</label>
					<input type="text" class="form-control" id="txtApellidos" name="txtApellidos" placeholder="Apellidos persona">
				</div>
				<div class="form-group">
					<label for="txtDescripcion">E-mail</label>
					<input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email">
				</div>
				<div class="form-group">
					<label for="txtDescripcion">Teléfono</label>
					<input type="text" class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Teléfono usuario">
				</div>
				<div class="form-group">
					<label for="cboPerfil">Perfil (*)</label>
					<select class="form-control" id="cboPerfil" name="cboPerfil">
						<option value="seleccione">Seleccione</option>
						<?php $funciones->cboPerfil(); ?>
					</select>
				</div>
				
				<br><br>
				<button type="button" class="btn btn-default" onclick="validaCrearUsuario();">Grabar</button>
			</form>
		</div>		
	</div>
</div>

</body>
</html>