<?php
include ("constantes.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo TITULO; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<h1><a href="index.html">EasyTask</a></h1>
						<nav>
							<a href="#menu">Iniciar Sesion</a>
						</nav>
					</header>

				<!-- Menu -->
<nav id="menu">
	<div class="inner">
		<h2>Iniciar Sesion</h2>
			<!--<input type="text" placeholder="Username"/>
			<input type="password" placeholder="***********"/>-->
			<form id="form">
				<input type="hidden" name="pagina" value="login">
				<div class="form-group">
					<label for="txtUsuario">Usuario</label>
					<input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Usuario" value="">
				</div>
				<br>
				<div class="form-group">
					<label for="txtPassword">Contraseña</label>
					<input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Contraseña" value="">
				</div>
				<!--<a class="btn btn-default" href="board.php" role="button">Iniciar Sesión</a>-->
				<br>
				<button type="button" class="btn btn-default" onclick="validaLogin();">Iniciar Sesión</button>
			</form>
		</br>
		<a href="#" class="close">Close</a>
	</div>
</nav>

				<!-- Banner -->
					<section id="banner">
						<div class="inner">
							<div class="logo"><span class="icon fa fa-area-chart"></span></div>
							<h2>EASYTASK</h2>
						</div>
					</section>

				<!-- Wrapper -->
					<section id="wrapper">

						<!-- One -->
							<section id="one" class="wrapper spotlight style1">
								<div class="inner">
									<a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
									<div class="content">
										<h2 class="major">Mision</h2>
										<p><strong>Mejorar</strong> la organización y comunicación entre los integrantes de los equipos de trabajo 
										<strong>otorgándole</strong> a nuestros clientes herramientas para llevar seguimiento de sus tareas 
										y obtener constantes evaluaciones para confirmar su desempeño dentro de la organización.</p>
									</div>
								</div>
							</section>

						<!-- Two -->
							<section id="two" class="wrapper alt spotlight style2">
								<div class="inner">
									<a href="#" class="image"><img src="images/pic02.jpg" alt="" /></a>
									<div class="content">
										<h2 class="major">Vision</h2>
										<p>Ser un <strong>referente</strong> en sistemas de evaluación al trabajador, mediante encuestas y reportes de desempeño, 
										<strong>incrementando</strong> las mejoras a nivel del personal de nuestros clientes.</p>
									</div>
								</div>
							</section>

						<!-- Three 
							<section id="three" class="wrapper spotlight style3">
								<div class="inner">
									<a href="#" class="image"><img src="images/pic03.jpg" alt="" /></a>
									<div class="content">
										<h2 class="major">Sobre Nosotros</h2>
										<p>......</p>
									</div>
								</div>
							</section>
					</section>
				<!-- Footer -->
					<section id="footer">
						<div class="inner">
							<h2 class="major">Contactate Con nosotros</h2>
							<form method="post" action="#">
								<div class="field">
									<label for="name">Nombre</label>
									<input type="text" name="name" id="name" />
								</div>
								<div class="field">
									<label for="email">Correo</label>
									<input type="email" name="email" id="email" />
								</div>
								<div class="field">
									<label for="message">Mensaje</label>
									<textarea name="message" id="message" rows="4"></textarea>
								</div>
								<ul class="actions">
									<li><input type="submit" value="Enviar Mensaje" /></li>
								</ul>
							</form>
							<ul class="contact">
								<li class="fa-home">
									Chile<br />
									Region Metropolitana,Santiago<br />
								</li>
								<li class="fa-phone">(+56 2) 2345 6789</li>
								<li class="fa-envelope"><a href="mailto:contacto@easytask.cl?Subject=Contacto" target="_top">contacto@easytask.cl</a></li>
								<li class="fa-twitter"><a href="#">twitter.com/easytask</a></li>
								<li class="fa-facebook"><a href="#">facebook.com/easytask</a></li>
							</ul>
							<ul class="copyright">
								<li>&copy; Untitled Inc. All rights reserved.</li><li>Design: <a href="htpp://www.inacap.cl">Inacapino</a></li>
							</ul>
						</div>
					</section>

			</div>

		<!-- Scripts -->
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script type="text/javascript" src="js/funciones.js"></script>

	</body>
</html>
