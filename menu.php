<!-- Brand and toggle get grouped for better mobile display -->
<div class="col-md-6">
    <div class="navbar-header">
        <?php if ($_SESSION['perfil'][0] != 3) { ?><!--Oculta este menú del perfil 'usuario'-->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php } ?>
        <a class="navbar-brand" href="board.php">EasyTasks</a>
    </div>
    <?php if ($_SESSION['perfil'][0] != 3) { ?><!--Oculta este menú del perfil 'usuario'-->
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <!--<li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mantención<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="listaUsuario.php" title="Usuarios del sistema">Usuarios</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="listaCliente.php" title="Actores solicitantes de tareas de la empresa (tabla Cliente)">Solicitantes</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="listaArea.php" title="Áreas de negocio de la tarea">Áreas de tarea (Categoría)</a></li>
                    <li><a href="listaSistema.php" title="Sistemas que se ven afectados por la tarea">Sistemas</a></li>
                    <li><a href="listaTarea.php" title="Tareas">Tareas</a></li>
                </ul>
            </li>
            <li><a href="#">Bitácora</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Evaluación<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="listaPreguntas.php" title="">Preguntas</a></li>
                    <li><a href="listaEncuesta.php" title="Administración de encuestas">Encuesta</a></li>                    
                </ul>
            </li>
        </ul>
    </div>
    <?php } ?>
</div>