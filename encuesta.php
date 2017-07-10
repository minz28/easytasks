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
            <?php $funciones->verPreguntasEncuesta($encuesta,2); ?>
        </div>
    </div>

    <!--Inicio modal ASIGNA preguntas-->
    <div class="modal fade" id="modalAsignaPregunta" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="nombreTarea" class="modal-title">Asignar preguntas a encuesta</h4>
                </div>
                <div class="modal-body">
                    <form id="formAsignaPregunta">
                        <input type="hidden" name="pagina" id="pagina" value="asignaPregunta" /><!--Variable oculta para identificar en el controlador-->
                        <input type="hidden" name="idEncuesta" id="idEncuesta" value="<?php echo $encuesta; ?>"><!--Variable oculta para saber id de tarea a editar-->
                        <div class="form-group">
                            <label for="cboPreguntaAsignada">Pregunta (*)</label>
                            <select class="form-control" id="cboPreguntaAsignada" name="cboPreguntaAsignada">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboPreguntaAsignada($encuesta); ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="guardaAsignaPregunta()">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal ASIGNA preguntas-->    
</div>

</body>
</html>