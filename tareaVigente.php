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
            <p>Estimado <?php echo $_SESSION['nombreUsuario']; ?>, usted actualmente tiene una tarjeta en desarrollo, ¿qué desea hacer?</p>
        </div>
    </div>
    <div class="row">
        <form id="form">
            <input type="hidden" name="pagina" id="pagina" value="finalizaTarea" /><!--Variable oculta para identificar en el controlador-->    
        </form>
        <div class="col-md-3 col-xs-12 text-center">
            <button type="button" class="btn btn-default" onclick="finalizaTarea();">Finalizar Tarea</button>
        </div>
        <div class="col-md-3 col-xs-12 text-center">
            <button type="button" class="btn btn-default" onclick="declaraTareaImpedida();">Declarar Tarea Impedida</button>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>