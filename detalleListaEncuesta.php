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
        	    <?php $titulo=$funciones->verPeriodoEncuesta($_GET["encuesta"]); ?>
                <h3><?php echo "Evaluación ".ucwords(strtolower($titulo['periodo'])).", Año ".substr($titulo['anio'], 0, 4)." - ".ucwords(strtolower($titulo['empresa'])); ?></h3>
            </div>
        </div>        
    </div>
</header>

<div class="container">    
    <div class="row">
        <div class="col-md-10 col-md-offset-1">            
            <!--<table class="table table-hover table-condensed table-responsive" style="box-shadow: 10px 10px 5px lightgrey;">--><!--Tabla CON sombra-->
            <table class="table table-hover table-condensed table-responsive"><!--Tabla SIN sombra-->
                <tr>
                    <th>Nombre</th>
                    <th class="text-center">Evaluar</th>
                    <th class="text-center">Puntaje usuario</th>
                    <th class="text-center">Puntaje coordinador</th>
                    <th class="text-center">Puntaje promedio</th>
                    <th class="text-center">Puntaje final</th>
                    <th class="text-center">Modificar puntaje final</th>
                </tr>
                <?php $funciones->listaEvaluacionPorPeriodo($_GET["encuesta"]); ?>
            </table>
        </div>
    </div>
    <!--Inicio modal EDITAR tarjeta-->
    <div class="modal fade" id="modalEdit" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Tarjeta</h4>
                    <small>(*) Campos obligatorios</small>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <input type="hidden" name="pagina" id="pagina" value="editaPuntajeFinal" /><!--Variable oculta para identificar en el controlador-->
                        <input type="hidden" name="idUsuarioEdit" id="idUsuarioEdit" value=""><!--Variable oculta para saber id de tarjeta a editar-->
                        <input type="hidden" name="idEncuestaEdit" id="idEncuestaEdit" value=""><!--Variable oculta para saber id de tarjeta a editar-->
                        <div class="form-group">
                            <label for="txtDescripcion">Nota final (*)</label>
                            <input type="text" class="form-control" id="txtPuntajeFinal" name="txtPuntajeFinal" placeholder="0.0" maxlength="3">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btnVerde" onclick="guardaEditaPuntajeFinal();">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal EDITAR tarjeta-->
</div>

<?php include("footer.php"); ?>

</body>
</html>