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
<link rel="stylesheet" type="text/css" href="css/estilos.css">

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
        	   <h2>Mantenedor de Usuarios</h2>
            </div>
        </div>        
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-default btnNaranja" data-toggle="modal" data-target="#modalAdd"><span class="glyphicon glyphicon-plus"></span>  Agregar usuario</button><br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">            
            <!--<table class="table table-hover table-condensed table-responsive" style="box-shadow: 10px 10px 5px lightgrey;">--><!--Tabla CON sombra-->
            <table class="table table-hover table-condensed table-responsive"><!--Tabla SIN sombra-->
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>E-mail</th>
                    <th>Teléfono</th>
                    <th>Username</th>
                    <th>Perfil</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <?php $funciones->listaUsuario(); ?>
            </table>
        </div>
    </div>
    <!--Inicio modal ADD tarea-->
    <div class="modal fade" id="modalAdd" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ingresar nuevo usuario</h4>
                    <small>(*) Campos obligatorios</small>
                </div>
                <div class="modal-body">
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
                    </form>
                </div>
                <br>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-default btnVerde" onclick="validaCrearUsuario();">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal ADD tarea-->
    <!--Inicio modal EDITAR tarea-->
    <div class="modal fade" id="modalEdit" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="nombreUsuario" class="modal-title">Editar usuario</h4>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <input type="hidden" name="pagina" id="pagina" value="" /><!--Variable oculta para identificar en el controlador-->
                        <input type="hidden" name="idEdit" id="idEdit" value=""><!--Variable oculta para saber id de tarea a editar-->
                        <div class="form-group">
							<label for="txtDescripcion">Nombre(s) (*)</label>
							<input type="text" class="form-control" id="txtNombreEdit" name="txtNombreEdit" placeholder="Nombre persona">
						</div>
						<div class="form-group">
							<label for="txtDescripcion">Apellido(s) (*)</label>
							<input type="text" class="form-control" id="txtApellidosEdit" name="txtApellidosEdit" placeholder="Apellidos persona">
						</div>
						<div class="form-group">
							<label for="txtDescripcion">E-mail</label>
							<input type="text" class="form-control" id="txtEmailEdit" name="txtEmailEdit" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="txtDescripcion">Teléfono</label>
							<input type="text" class="form-control" id="txtTelefonoEdit" name="txtTelefonoEdit" placeholder="Teléfono usuario">
						</div>
						<div class="form-group">
							<label for="cboPerfil">Perfil (*)</label>
							<select class="form-control" id="cboPerfilEdit" name="cboPerfilEdit">
								<option value="seleccione">Seleccione</option>
								<?php $funciones->cboPerfil(); ?>
							</select>
						</div>
                	</form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btnVerde" onclick="guardaEditaUsuario()">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal DETALLE tarjeta-->
</div>

<?php include("footer.php"); ?>

</body>
</html>