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
<script type="text/javascript" src="graph/modules/exporting.js"></script>

</head>

<body style="background-color: #F0F0F6">
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
        <form id="formDashboardTareas" name="formDashboardTareas" method="post" action="dashboardTareas.php" class="form-inline">
        <div class="col-md-12">    	
    		<!--<label for="cboUsuario">Usuario: </label>
            <select class="form-control" id="cboUsuario" name="cboUsuario">
                <option value="seleccione">Seleccione</option>
                <?php $funciones->cboUsuario(); ?>
            </select>-->
        	&nbsp;
    		<div class="form-group">
            <label for="txtFechaInicio">Rango de fechas: </label>
                <div class='input-group date' id='divFechaInicio'>
					<input type='text' id="txtFechaInicio" name="txtFechaInicio" class="form-control" value="<?php if(isset($_POST['txtFechaInicio'])){ echo $_POST['txtFechaInicio']; } ?>" readonly/>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<div class='input-group date' id='divFechaTermino'>
					<input type='text' id="txtFechaTermino" name="txtFechaTermino" class="form-control" value="<?php if(isset($_POST['txtFechaTermino'])){ echo $_POST['txtFechaTermino']; } ?>" readonly/>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
            </div>				
        	&nbsp;
    		<button type="button" class="btn btn-default btnAzul" onclick="validaFormDashboardTareas()"><span class="glyphicon glyphicon-search"></span> Buscar</button>
        </div>
        </form><br><br>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <?php if(isset($_POST['txtFechaInicio'])) { ?>
            <h2>Detalle de tareas</h2><br>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php if(isset($_POST['txtFechaInicio'])) {
                echo "<h4>Top 5 tareas más solicitadas <small>(Entre $_POST[txtFechaInicio] y $_POST[txtFechaTermino])</small></h4>";
                $ranking=$funciones->rankingTareasSolicitadas($_POST['txtFechaInicio'],$_POST['txtFechaTermino']); #var_dump($ranking); die(); ?>
                <ol>
                <?php foreach ($ranking as $datoRanking) {
                    echo "<li>$datoRanking[tarea] ($datoRanking[cantidad] solicitudes)</li>";                                        
                }?>
                </ol>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <div id="graficaTop5" style="width: 100%; height: 300px; margin: 0 auto"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <?php if(isset($_POST['txtFechaInicio'])) {
                echo "<h4>Top 5 tareas finalizadas con éxito <small>(Entre $_POST[txtFechaInicio] y $_POST[txtFechaTermino])</small></h4>";
                $rankingRealizadas=$funciones->rankingTareasRealizadas($_POST['txtFechaInicio'],$_POST['txtFechaTermino']); ?>
                <ol>
                <?php foreach ($rankingRealizadas as $datoRankingRealizadas) {
                    echo "<li>$datoRankingRealizadas[tarea] ($datoRankingRealizadas[cantidad] solicitudes)</li>";                                        
                }?>
                </ol>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <div id="graficaTop5Realizadas" style="width: 100%; height: 300px; margin: 0 auto"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <?php if(isset($_POST['txtFechaInicio'])) {
                echo "<h4>Top 5 tareas más impedidas <small>(Entre $_POST[txtFechaInicio] y $_POST[txtFechaTermino])</small></h4>";
                $rankingImpedidas=$funciones->rankingTareasImpedidas($_POST['txtFechaInicio'],$_POST['txtFechaTermino']); ?>
                <ol>
                <?php foreach ($rankingImpedidas as $datoRankingImpedidas) {
                    echo "<li>$datoRankingImpedidas[tarea] ($datoRankingImpedidas[cantidad] solicitudes)</li>";                                        
                }?>
                </ol>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <div id="graficaTop5Impedidas" style="width: 100%; height: 300px; margin: 0 auto"></div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.es.js"></script>
<script type="text/javascript">
    $('#divFechaInicio').datetimepicker({
        format: 'YYYY-MM-DD'       
    });
    $('#divFechaTermino').datetimepicker({
        format: 'YYYY-MM-DD'       
    });
</script>

<?php if(isset($_POST['txtFechaInicio'])) { ?>
<!--GRÁFICO 1-->
<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                type: 'column',
                renderTo: 'graficaTop5'
            },
            title: {
                text: 'TOP 5 TAREAS MÁS SOLICITADAS'
            },
            subtitle: {
                text: 'ENTRE <?php echo $_POST["txtFechaInicio"] ?> Y <?php echo $_POST["txtFechaTermino"] ?>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {                    
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: 'Tareas',
                colorByPoint: true,
                data: [
                        <?php $funciones->graficoRankingTareasSolicitadas($_POST['txtFechaInicio'], $_POST['txtFechaTermino']); ?>
                    ]
            }]
        });
    });
</script>
<!--GRÁFICO 2-->
<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                type: 'column',
                renderTo: 'graficaTop5Realizadas'
            },
            title: {
                text: 'TOP 5 TAREAS MÁS SOLICITADAS'
            },
            subtitle: {
                text: 'ENTRE <?php echo $_POST["txtFechaInicio"] ?> Y <?php echo $_POST["txtFechaTermino"] ?>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {                    
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: 'Tareas',
                colorByPoint: true,
                data: [
                        <?php $funciones->graficoRankingTareasRealizadas($_POST['txtFechaInicio'], $_POST['txtFechaTermino']); ?>
                    ]
            }]
        });
    });
</script>
<!--GRÁFICO 3-->
<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                type: 'column',
                renderTo: 'graficaTop5Impedidas'
            },
            title: {
                text: 'TOP 5 TAREAS MÁS SOLICITADAS'
            },
            subtitle: {
                text: 'ENTRE <?php echo $_POST["txtFechaInicio"] ?> Y <?php echo $_POST["txtFechaTermino"] ?>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {                    
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: 'Tareas',
                colorByPoint: true,
                data: [
                        <?php $funciones->graficoRankingTareasImpedidas($_POST['txtFechaInicio'], $_POST['txtFechaTermino']); ?>
                    ]
            }]
        });
    });
</script>
<?php } ?>

</body>
</html>

