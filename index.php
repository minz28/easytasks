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
<link rel="stylesheet" type="text/css" href="css/estilos.css">

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>

<style type="text/css">
/*
 * Start Bootstrap - Full Slider (http://startbootstrap.com/)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */

html,
body {
    height: 100%;
}

.carousel,
.item,
.active {
    height: 100%;
}

.carousel-inner {
    height: 100%;
}

/* Background images are set within the HTML using inline CSS, not here */

.fill {
    width: 100%;
    height: 100%;
    background-position: center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -o-background-size: cover;
}


</style>

</head>

<body>

<header>
    <div class="container">
    	<div class="row">
        	<div class="col-md-4">
        	   <!--<h2 style="color:#00FFFF; font-family: helvetica">EasyTasks</h3>-->
               <p style="text-shadow:1px 1px 1px rgba(16,33,89,1);font-weight:normal;font-variant:small-caps;color:#0C063B;letter-spacing:7pt;word-spacing:2pt;font-size:45px;text-align:left;font-family:trebuchet MS, sans-serif;line-height:2;">EasyTasks</p>
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
                    <button type="button" class="btn btn-default btnRojo2" onclick="validaLogin();">Iniciar Sesión</button>
                </form>
            </div>
        </div>               
    </div>
</header>

<!-- Full Page Image Background Carousel Header -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url('img/Fondo21.jpg');"></div>
                <div class="carousel-caption">
                </div>
            </div>            
        </div>

        

    </header>



</body>
</html> 