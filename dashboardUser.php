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
<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="graph/css/highcharts.css">

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="graph/js/highcharts.js"></script>

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

<div class="container">
    <div class="row">
        <form class="form-inline">
        <div class="col-md-12">    	
    		<label for="cboUsuario">Usuario: </label>
            <select class="form-control" id="cboUsuario" name="cboUsuario">
                <option value="seleccione">Seleccione</option>
                <?php $funciones->cboUsuario(); ?>
            </select>    	
        	&nbsp;
    		<div class="form-group">
            <label for="txtFechaInicio">Rango de fechas: </label>
            	<!--<input type="text" class="form-control" id="txtFechaInicio" name="txtFechaInicio" placeholder="DD/MM/AAAA">                
                <input type="text" class="form-control" id="txtFechaTermino" name="txtFechaTermino" placeholder="DD/MM/AAAA">-->
                <div class='input-group date' id='divFechaInicio'>
					<input type='text' id="txtFechaInicio" name="txtFechaInicio" class="form-control" readonly/>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<div class='input-group date' id='divFechaTermino'>
					<input type='text' id="txtFechaTermino" name="txtFechaTermino" class="form-control" readonly/>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
            </div>				
        	&nbsp;
    		<button type="button" class="btn btn-default btnAzul" onclick=""><span class="glyphicon glyphicon-search"></span> Buscar</button>
        </div>
        </form><br>
    </div>
    <div class="row">
        <div class="col-md-12">
        	<h4>Estadísticas para</h4>
        </div>
    </div>    
</div>

<?php include("footer.php"); ?>


<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.es.js"></script>
<script type="text/javascript">
    $('#divFechaInicio').datetimepicker({
        format: 'DD-MM-YYYY'       
    });
    $('#divFechaTermino').datetimepicker({
        format: 'DD-MM-YYYY'       
    });
</script>

</body>
</html>

