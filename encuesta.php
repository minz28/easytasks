<?php
//session_start();
include("clases/Funciones.class.php");
include ("constantes.php");
$funciones = new Funciones;
$encuesta = $_SESSION['idEncuesta'];
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
            <div class="col-md-12 text-center">
                <?php $titulo=$funciones->verPeriodoEncuesta($encuesta); ?>
                <h3><?php echo "Evaluación ".ucwords(strtolower($titulo['periodo'])).", Año ".substr($titulo['anio'], 0, 4)." - ".ucwords(strtolower($titulo['empresa'])); ?></h3>
            </div>
        </div>        
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p>Responda la siguiente encuesta de desempeño laboral preparada por su coordinador, marcando las respuestas del 1 a 5 según corresponda, 
            siendo 1 la ponderación relacionada con "Bajo" o "En desacuerdo" y 5 la ponderación relacionada con "Alto" o "Totalmente de acuerdo".</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br>
            <form id="formEncuesta">
                <input type="hidden" name="pagina" value="respondeEncuesta">
                <?php $funciones->verPreguntasEncuesta($encuesta,2); ?>    
            </form>            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-default" onclick="validaEnvioEncuesta();">Enviar respuestas</button>
        </div>
    </div>
</div>

</body>
</html>