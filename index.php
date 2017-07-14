<?php include("constantes.php"); ?>
<!DOCTYPE HTML>
<html>
<head>		
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!--<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximun-scale=1">-->
<title><?php echo utf8_decode(TITULO); ?></title>
<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
<link rel="stylesheet" href="assets/css/main.css" />
<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
</head>

<body>

<!-- Header -->
<header id="header" class="alt">
	<h1><a href="#">EasyTasks</a></h1>
	<nav>
		<a href="#mision">Misión</a>
		<a href="#vision">Visión</a>
		<a href="#nosotros">Quienes Somos</a>
		<a href="#planes">Planes</a>
		<a href="#footer">Contáctanos</a>
		<a href="#menu">Iniciar Sesión</a>
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
		<a href="#" class="image"><img src="img/logo.png" height="120" width="120" alt="" /></a>
		<h2>EASYTASKS</h2>
		<p>Flujo de tareas ágiles para equipos de trabajo </p>
	</div>
</section>

<!-- One -->
<nav id="mision">
	<section id="one" class="wrapper spotlight style1">
		<div class="inner">
		<a class="image"><img src="images/pic01.jpg" alt="" /></a>
			<div class="content">
				<br />
				<br />
				<h2 class="major">Misión</h2>
				<p>Mejoraremos la comunicación y organización entre los integrantes de los equipos de trabajo otorgándoles herramientas para llevar seguimiento de sus tareas y obtener constantes evaluaciones para confirmar su desempeño dentro de la organización.</p>
			</div>
		</div>
	</section>
</nav>

<!-- Two -->
<nav id="vision">
	<section id="two" class="wrapper alt spotlight style2">
		<div class="inner">
		<a class="image"><img src="images/pic02.jpg" alt="" /></a>
			<div class="content">
				<br />
				<br />
				<h2 class="major">Visión</h2>
				<p>Ser un referente en aplicaciones que buscan evaluar al trabajador mediante encuestas y reportes de sus tareas, también lograr mejoras a nivel del personal con los que cuente la empresa.</p>
			</div>
		</div>
	</section>
</nav>
<!-- Three -->

<nav id="nosotros">
	<section id="three" class="wrapper spotlight style3">
		<div class="inner">
		<a class="image"><img src="images/pic03.jpg" alt="" /></a>
			<div class="content">
				<br />
				<br />	
				<h2 class="major">Sobre Nosotros</h2>
				<p>Easytasks combina los beneficios de la metodología ágil Kanban y la evalución de desempeño para provocar una mayor productividad en tu empresa, una mejor gestión de tus RRHH y como resultado de aquello una mejor rentabilidad.</p>
			</div>
		</div>
	</section>
</nav>

<nav id="planes">
	<section id="plan" class="wrapper spotlight style1">
		<div class="inner">
			<section class="features">
				<article>
					<h2 class="major">Plan Básico </h2>
					<h3 style="padding-top:0;padding-bottom:10px;">0.69 UF<br><br /><span class="small">Acceso para 4 usuarios y 1 coordinador</span></h3>
					<strong>Registro del tiempo , informes y evaluación</strong><br>
					tableros ilimitados<br>
					0.22 UF por usuario / mes adicional<br/>
					0.44 UF por coordinador / mes adicional<br/>
					<a href="" class="clickable"><input type="submit" name="submit" value="Regístrese »"></a>
				</article>
				
				<article>
					<h2 class="major">Plan Estándar </h2>
					<h3 style="padding-top:0;padding-bottom:10px;">1.65 UF<br><br /><span class="small">Acceso para 10 usuarios y 2 coordinadores</span></h3>
					<strong>Registro del tiempo , informes y evaluación</strong><br>
					tableros ilimitados<br>
					0.22 UF por usuario / mes adicional<br/>
					0.44 UF por coordinador / mes adicional<br/>
					<a href="" class="clickable"><input type="submit" name="submit" value="Regístrese »"></a>
				</article>

				<article>
					<h2 class="major">Plan Profesional </h2>
					<h3 style="padding-top:0;padding-bottom:10px;">3.3 UF<br><br /><span class="small">Acceso para 20 usuarios y 3 coordinadores</span></h3>
					<strong>Registro del tiempo , informes y evaluación</strong><br>
					tableros ilimitados<br>
					0.22 UF por usuario / mes adicional<br/>
					0.44 UF por coordinador / mes adicional<br/>
					<a href="" class="clickable"><input type="submit" name="submit" value="Regístrese »"></a>
				</article>
			</section>
		</div>
	</section>
</nav>

<!-- Footer -->
<br />
<br />
<section id="footer">
	<div class="inner">
		<h2 class="major">Contáctate Con nosotros</h2>
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
			Región Metropolitana,Santiago<br />
			</li>
			<li class="fa-phone">(56 2) 2222 2222</li>
			<li class="fa-envelope"><a href="mailto:contacto@easytasks.cl?subject=Estoy interesado en conocer Easytasks">contacto@easytasks.cl</a></li>
			<li class="fa-twitter"><a href="#">twitter.com/easytasks</a></li>
			<li class="fa-facebook"><a href="#">facebook.com/easytasks</a></li>
		</ul>
		<ul class="copyright">
			<li>&copy; Untitled Inc. All rights reserved.</li><li>Design: <a href="htpp://www.inacap.cl">Inacapino</a></li>
		</ul>
	</div>
</section>

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