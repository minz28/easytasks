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

<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
        	<h2>Medición de desempeño</h2><br>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-4 col-md-offset-1 col-xs-12">
    		<?php $datosUsuario = $funciones->nombreUsuario($user); ?>
    		<h4>Nombre: <?php echo ucwords(strtolower($datosUsuario['nombre'])); ?></h4>
    		<h5>Empresa: <?php echo ucwords(strtolower($datosUsuario['empresa'])); ?></h5>
    		<h5>E-mail: <a href="mailto:<?php echo strtolower($datosUsuario['email']); ?>"><?php echo strtolower($datosUsuario['email']); ?></a></h5>
    	</div>
        <div class="col-md-6 col-xs-12">
        	<div id="graficaCircular" style="width: 100%; height: 300px; margin: 0 auto"></div>
        </div>
    </div>	
</div>

<script type="text/javascript">
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'graficaCircular'
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
						<?php $funciones->dashboardUser($user, $desde, $hasta); ?>
					]
			}]
		});
	});			
</script>

</body>
</html>

