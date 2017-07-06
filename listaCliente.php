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
        	   <h2>Mantenedor de Solicitantes</h2>
            </div>
        </div>        
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-default btnNaranja" data-toggle="modal" data-target="#modalAdd"><span class="glyphicon glyphicon-plus"></span>  Agregar solicitante</button><br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">            
            <!--<table class="table table-hover table-condensed table-responsive" style="box-shadow: 10px 10px 5px lightgrey;">--><!--Tabla CON sombra-->
            <table class="table table-hover table-condensed table-responsive"><!--Tabla SIN sombra-->
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Area</th>
                    <th>Cargo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <?php $funciones->listaSolicitante(); ?>
            </table>
        </div>
    </div>
    <!--Inicio modal ADD tarea-->
    <div class="modal fade" id="modalAdd" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ingresar nuevo solicitante</h4>
                    <small>(*) Campos obligatorios</small>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="pagina" value="creaSolicitante" /><!--Variable oculta para identificar en el controlador-->
                        <div class="form-group">
                            <label for="txtDescripcion">Nombre (*)</label>
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcion">Area (*)</label>
                            <input type="text" class="form-control" id="txtArea" name="txtArea" placeholder="Area">
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcion">Cargo (*)</label>
                            <input type="text" class="form-control" id="txtCargo" name="txtCargo" placeholder="Cargo">
                        </div>
                    </form>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="validaCrearSolicitante()">Grabar</button>
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
                    <h4 id="nombreTarea" class="modal-title">Editar solicitante</h4>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <input type="hidden" name="pagina" id="pagina" value="" /><!--Variable oculta para identificar en el controlador-->
                        <input type="hidden" name="idEdit" id="idEdit" value=""><!--Variable oculta para saber id de tarea a editar-->
                        <div class="form-group">
                            <label for="txtDescripcion">Nombre (*)</label>
                            <input type="text" class="form-control" id="txtNombreEdit" name="txtNombreEdit" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcion">Area (*)</label>
                            <input type="text" class="form-control" id="txtAreaEdit" name="txtAreaEdit" placeholder="Area">
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcion">Cargo (*)</label>
                            <input type="text" class="form-control" id="txtCargoEdit" name="txtCargoEdit" placeholder="Cargo">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="guardaEditaSolicitante()">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal DETALLE tarjeta-->
</div>

<?php include("footer.php"); ?>

</body>
</html>