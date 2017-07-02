<?php
include ("constantes.php");
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

<header>
    <div class="container">
    	<div class="row">
        	<div class="col-md-4">
        	   <h3>Bienvenido a EasyTasks</h3>
            </div>
            <div class="col-md-8 text-right"><br>
                <form id="form" class="form-inline">
                	<input type="hidden" name="pagina" value="login">
                	<div class="form-group">
                    	<label for="txtUsuario">Usuario</label>
                        <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Usuario" value="">
                    </div>
                    <div class="form-group">
                    	<label for="txtPassword">Contraseña</label>
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Contraseña" value="">
                    </div>
                    <!--<a class="btn btn-default" href="board.php" role="button">Iniciar Sesión</a>-->
                    <button type="button" class="btn btn-default" onclick="validaLogin();">Iniciar Sesión</button>
                </form>
            </div>
        </div>               
    </div>
</header>

<div class="container">
    <br><br><br>
    <article>
    	<div class="col-md-offset-2 col-md-8">
        <h4>Quienes somos</h4>
        <p>
        	Easytasks es una herramienta para la planificación de las tareas laborales, lo que permite generar inteligencia a través de los datos almacenados durante el día a día laboral.
        </p>
        </div>
        <br><br><br><br><br><br><br>
        <div class="col-md-12">
        <h4 class="col-md-6 text-right">Misión</h4>
        <p class="col-md-6">La misión de “EasyTasks” es mejorar la comunicación y organización entre los integrantes de los equipos de trabajo 
        otorgándoles herramientas para llevar seguimiento de sus tareas y obtener constantes evaluaciones para confirmar su desempeño dentro de la organización.</p>
        </div>
        <br><br><br><br>
        <div class="col-md-12">
        <p class="col-md-6">Ser un referente en aplicaciones que buscan evaluar al trabajador mediante encuestas y reportes de sus tareas, 
        también lograr mejoras a nivel del personal con los que cuente la empresa.</p>
        <h4 class="col-md-6">Visión</h4>
        </div>
    </article>
</div>
<div class="col-md-offset-4 col-md-4 text-center">
	
</div>

<?php include("footer.php") ?>

</body>
</html> 