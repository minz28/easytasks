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

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
</head>

<body>

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <?php include("menu.php"); ?>
        <div class="col-md-6">
            <h5 class="text-right">Bienvenido <?php echo $_SESSION['nombreUsuario']; ?>
            &nbsp;<a href="logout.php"><button type="button" class="btn btn-default">Cerrar Sesión</button></a></h5>
        </div>
    </div><!-- /.container-fluid -->
</nav>

<header>
    <div class="container">
    	<div class="row">
        	<div class="col-md-12 text-center">
        	   <h2>Mantenedor de Tareas</h2>
            </div>
        </div>        
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-default btnNaranja" data-toggle="modal" data-target="#modalAdd"><span class="glyphicon glyphicon-plus"></span>  Agregar tarea</button><br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">            
            <!--<table class="table table-hover table-condensed table-responsive" style="box-shadow: 10px 10px 5px lightgrey;">--><!--Tabla CON sombra-->
            <table class="table table-hover table-condensed table-responsive"><!--Tabla SIN sombra-->
                <tr>
                    <th>N°</th>
                    <th>Categoría</th>
                    <th>Sistema</th>
                    <th>Tarea</th>
                    <th>Dificultad</th>
                    <th>Tiempo de desarrollo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <?php $funciones->listaTarea(); ?>
            </table>
        </div>
    </div>
    <!--Inicio modal ADD tarea-->
    <div class="modal fade" id="modalAdd" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ingresar nueva tarea</h4>
                    <small>(*) Campos obligatorios</small>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <input type="hidden" name="pagina" value="creaTarea" /><!--Variable oculta para identificar en el controlador-->
                        <div class="form-group">
                            <label for="cboCategoria">Categoría (*)</label>
                            <select class="form-control" id="cboCategoria" name="cboCategoria">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboCategoria(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cboSistema">Sistema (*)</label>
                            <select class="form-control" id="cboSistema" name="cboSistema">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboSistema(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcion">Descripción (*)</label>
                            <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción tarea">
                        </div>
                        <div class="form-group">
                            <label for="cboDificultad">Dificutad (*)</label>
                            <select class="form-control" id="cboDificultad" name="cboDificultad">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboDificultad(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtTiempoEstimado">Tiempo estimado predefinido (HH:MM) (*)</label>
                            <br>
                            <div class="col-md-2">
                                <select class="form-control" id="cboHH" name="cboHH">
                                    <?php
                                    echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
                                    for ($i=10; $i<24; $i++) { 
                                        echo "<option value='".$i."'>".$i."</option>";
                                    }                                                           
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-2">
                                <select class="form-control" id="cboMM" name="cboMM">
                                    <?php
                                    echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
                                    for ($i=10; $i<60; $i++) { 
                                        echo "<option value='".$i."'>".$i."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <!--Asignación de segundos al detalle de tarea
                            <div class="col-md-2">
                                <select class="form-control" id="cboSS" name="cboSS">
                                    <?php/*
                                    echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
                                    for ($i=10; $i<60; $i++) { 
                                        echo "<option value='".$i."'>".$i."</option>";
                                    }*/
                                    ?>
                                </select>
                            </div>-->
                        </div>
                    </form>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="validaTarea();">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal ADD tarea-->
    <!--Inicio modal EDITAR tarea-->
    <div class="modal fade" id="modalEdit" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="nombreTarea" class="modal-title">Editar tarea</h4>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <input type="hidden" name="pagina" id="pagina" value="" /><!--Variable oculta para identificar en el controlador-->
                        <input type="hidden" name="idEdit" id="idEdit" value=""><!--Variable oculta para saber id de tarea a editar-->
                        <div class="form-group">
                            <label for="cboCategoriaEdit">Categoría (*)</label>
                            <select class="form-control" id="cboCategoriaEdit" name="cboCategoriaEdit">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboCategoria(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cboSistemaEdit">Sistema (*)</label>
                            <select class="form-control" id="cboSistemaEdit" name="cboSistemaEdit">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboSistema(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcionEdit">Descripción (*)</label>
                            <input type="text" class="form-control" id="txtDescripcionEdit" name="txtDescripcionEdit" placeholder="Descripción tarea">
                        </div>
                        <div class="form-group">
                            <label for="cboDificultadEdit">Dificutad (*)</label>
                            <select class="form-control" id="cboDificultadEdit" name="cboDificultadEdit">
                                <option value="seleccione">Seleccione</option>
                                <?php $funciones->cboDificultad(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtTiempoEstimadoEdit">Tiempo estimado predefinido (HH:MM) (*)</label>
                            <br>
                            <div class="col-md-2">
                                <select class="form-control" id="cboHHEdit" name="cboHHEdit">
                                    <?php
                                    echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
                                    for ($i=10; $i<24; $i++) { 
                                        echo "<option value='".$i."'>".$i."</option>";
                                    }                                                           
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-2">
                                <select class="form-control" id="cboMMEdit" name="cboMMEdit">
                                    <?php
                                    echo "<option value='00'>00</option><option value='01'>01</option><option value='02'>02</option><option value='03'>03</option><option value='04'>04</option><option value='05'>05</option><option value='06'>06</option><option value='07'>07</option><option value='08'>08</option><option value='09'>09</option>";
                                    for ($i=10; $i<60; $i++) { 
                                        echo "<option value='".$i."'>".$i."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="guardaEditaTarea()">Grabar</button>
                </div>                
            </div>
        </div>
    </div>
    <!--Fin modal DETALLE tarjeta-->
</div>

<?php include("footer.php"); ?>

</body>
</html>