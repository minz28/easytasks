<?php
//session_start();
include("clases/Funciones.class.php");
include ("constantes.php");
$funciones = new Funciones;
$user = $_GET['usuario'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
/*$user = $_POST['cboUsuario'];
$desde = $_POST['txtFechaInicio'];
$hasta = $_POST['txtFechaTermino'];*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximun-scale=1">
<title><?php echo TITULO; ?></title>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link rel="stylesheet" type="text/css" href="graph/css/highcharts.css">

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="graph/js/highcharts.js"></script>
<script type="text/javascript" src="graph/modules/exporting.js"></script>

</head>

<body style="background-color: #F0F0F6">

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
        	<h2>Medición de desempeño</h2><br>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-4 col-md-offset-1 col-xs-12">
    		<?php $datosUsuario = $funciones->nombreUsuario($user); ?>
    		<h3>Datos personales</h3>
    		<h5>Nombre: <?php echo ucwords(strtolower($datosUsuario['nombre'])); ?></h5>
    		<h5>Empresa: <?php echo ucwords(strtolower($datosUsuario['empresa'])); ?></h5>
    		<h5>E-mail: <a href="mailto:<?php echo strtolower($datosUsuario['email']); ?>"><?php echo strtolower($datosUsuario['email']); ?></a></h5>
    		<?php $ultimaEncuesta = $funciones->datosUltimaEncuesta($user); ?>
    		<h3>Última evaluación <br><small>(<?php echo $ultimaEncuesta['periodo']." - ".$ultimaEncuesta['anio']; ?>)</small></h3>
			Puntaje Autoevaluación: <strong><?php echo $ultimaEncuesta['puntajeUsuario']; ?></strong><br>
			Puntaje Coordinador: <strong><?php echo $ultimaEncuesta['puntajeCoordinador']; ?></strong><br>
			Puntaje Promedio: <strong><?php echo $ultimaEncuesta['puntajePromedio']; ?></strong><br>
			Puntaje Final: <strong><?php echo $ultimaEncuesta['puntajeReal']; ?></strong>
    	</div>
        <div class="col-md-6 col-xs-12">
        	<div id="graficaFinalizacionTarjetas" style="width: 100%; height: 300px; margin: 0 auto"></div>
        </div>
    </div>
    <br>
    <div class="row">
    	<div class="col-md-5 col-md-offset-1 col-xs-12">
        	<div id="graficaDetalleImpedidas" style="width: 100%; height: 300px; margin: 0 auto"></div>
        </div>
        <div class="col-md-5 col-xs-12">
        	<div id="graficaTiemposFinalizacion" style="width: 100%; height: 300px; margin: 0 auto"></div>
        </div>        
    </div>
</div>

<!--GRÁFICO 1-->
<script type="text/javascript">
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graficaFinalizacionTarjetas'
			},
			title: {
				text: 'FINALIZACIÓN DE TARJETAS'
			},
			subtitle: {
				text: 'ENTRE <?php echo $desde ?> Y <?php echo $hasta ?>'
			},
			plotArea: {
				shadow: null,
				borderWidth: null,
				backgroundColor: null
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
						}
					}
				}
			},
		    series: [{
				type: 'pie',
				name: 'Browser share',
				data: [
						<?php $funciones->dashboardUserFinalizacionTarjetas($user, $desde, $hasta); ?>
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
				renderTo: 'graficaDetalleImpedidas'
			},
			title: {
				text: 'DETALLE TARJETAS IMPEDIDAS'
			},
			subtitle: {
				text: 'ENTRE <?php echo $desde ?> Y <?php echo $hasta ?>'
			},
			plotArea: {
				shadow: null,
				borderWidth: null,
				backgroundColor: null
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
						}
					}
				}
			},
		    series: [{
				type: 'pie',
				name: 'Browser share',
				data: [
						<?php $funciones->dashboardUserDetalleImpedidas($user, $desde, $hasta); ?>
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
				renderTo: 'graficaTiemposFinalizacion'
			},
			title: {
				text: 'DETALLE FINALIZACIÓN TARJETAS'
			},
			subtitle: {
				text: 'ENTRE <?php echo $desde ?> Y <?php echo $hasta ?>'
			},
			plotArea: {
				shadow: null,
				borderWidth: null,
				backgroundColor: null
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
						}
					}
				}
			},
		    series: [{
				type: 'pie',
				name: 'Browser share',
				data: [
						<?php $funciones->dashboardUserTiemposCumplimiento($user, $desde, $hasta); ?>
					]
			}]
		});
	});			
</script>

</body>
</html>

