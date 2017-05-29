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

<header>
    <div class="container">
    	<div class="row">
        	<div class="col-md-4">
        	   <h3>Bienvenido a EasyTask</h3>
            </div>
            <div class="col-md-8">
                <form class="form-inline" method="POST" action="controlador/controlador.php">
                	<input type="hidden" name="pagina" value="login">
                	<div class="form-group">
                    	<label for="txtUsuario">Usuario</label>
                        <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Usuario" value="minzunza">
                    </div>
                    <div class="form-group">
                    	<label for="txtPassword">Contraseña</label>
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Contraseña" value="lalala99">
                    </div>
                    <!--<a class="btn btn-default" href="board.php" role="button">Iniciar Sesión</a>-->
                    <button type="submit" class="btn btn-default">Iniciar Sesión</button>
                </form>
            </div>
        </div>               
    </div>
</header>

<div class="container">
    <article>
        <p>
            Quienes somos bla bla bla
        </p>
    </article>
</div>

<div class="panel-footer navbar-fixed-bottom">
    <div class="container">
        <p>EasyTask® 2017 | Miguel Pinto - Miguel Inzunza - Hans Silva | Todos los derechos reservados</p>
    </div>
</div>

</body>
</html> 