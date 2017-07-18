function xxx(){
	alert('xxx');
}

// Validating Empty Field
function check_empty() {
	if (document.getElementById('name').value == "" || document.getElementById('email').value == "" || document.getElementById('msg').value == "") {
	alert("Fill All Fields !");
	} else {
	document.getElementById('form').submit();
	alert("Form Submitted Successfully...");
	}
}
//Function To Display Popup
function div_show() {
	document.getElementById('abc').style.display = "block";
}
//Function to Hide Popup
function div_hide(){
	document.getElementById('abc').style.display = "none";
}

function validaLogin(){
    if($("#txtUsuario").val().trim() == "" || $("#txtPassword").val().trim() == ""){
        alert("Completar campos obligatorios");
        $("#txtUsuario").val("");
        $("#txtPassword").val("");
        $("#txtUsuario").focus();
    } else {
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();   
    }
}

//Validar formulario ingreso de tarjeta
function validaTarjeta(){
    //if(document.getElementById('cboTarea').value == "seleccione" || document.getElementById('cboPrioridad').value == "seleccione" || document.getElementById('cboEstado').value == "seleccione")
    if(document.getElementById('cboTarea').value == "seleccione" || document.getElementById('cboPrioridad').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaTarjeta(json){
    $('#pagina').val('editaTarjeta');
    $('#idEdit').val(json.idTarjeta);
    $('#cboTareaEdit option[value="'+ json.idTarea +'"]').attr('selected',true);
    $('#txtSolicitanteEdit option[value="'+ json.idSolicitante +'"]').attr('selected',true);
    $('#cboPrioridadEdit option[value="'+ json.idPrioridad +'"]').attr('selected',true);
    $('#cboEstadoEdit option[value="'+ json.idEstado +'"]').attr('selected',true);
    $('#txtObservacionesEdit').val(json.observaciones);
    //$('#fileAdjuntoEdit').val(json.descripcionSistema);
    $('#modalEdit').modal('show');
}

function guardaEditaTarjeta(){
    if(document.getElementById('cboTareaEdit').value == "seleccione" || document.getElementById('cboPrioridadEdit').value == "seleccione" || document.getElementById('cboEstadoEdit').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar esta tarjeta?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function detalleTarjeta(jsonTarjeta){
    $("#idTarjetaAutoAsignar").val(jsonTarjeta.idTarjeta);
    $("#nombreTarea").text(jsonTarjeta.tarea);
    $("#solicitante").text('Solicitado por: '+jsonTarjeta.solicitante);
    $("#fechaSolicitud").text('Fecha solicitud: '+jsonTarjeta.fechaSolicitud);
    $("#prioridad").text('Prioridad: '+jsonTarjeta.prioridad);
    $("#observaciones").text('Observaciones: '+jsonTarjeta.observaciones);
    if(jsonTarjeta.idEstado == 1) {
        $("#footerDetalleTarjeta1").show();
        $("#footerDetalleTarjeta4").hide();
    } else if(jsonTarjeta.idEstado == 4) {
        $("#footerDetalleTarjeta1").hide();
        $("#footerDetalleTarjeta4").show();
    } else {
        $("#footerDetalleTarjeta1").hide();
        $("#footerDetalleTarjeta4").hide();
    }
    $('#modalDetalleTarjeta').modal('show');    
}

//Validar formulario ingreso de tarjeta
function validaTarea(){
    if(document.getElementById('cboCategoria').value == "seleccione" || document.getElementById('cboSistema').value == "seleccione" || document.getElementById('txtDescripcion').value.trim() == "" || document.getElementById('cboDificultad').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaTarea(json){
    var tiempoEstimado = json.tiempoEstimado;
    var tiempo = tiempoEstimado.split(':');
    $('#pagina').val('editaTarea');
    $('#idEdit').val(json.idTarea);
    $('#cboCategoriaEdit option[value="'+ json.idCategoria +'"]').attr('selected',true);
    $('#cboSistemaEdit option[value="'+ json.idSistema +'"]').attr('selected',true);
    $('#txtDescripcionEdit').val(json.tarea);
    $('#cboDificultadEdit option[value="'+ json.idDificultad +'"]').attr('selected',true);
    $('#cboHHEdit option[value="'+ tiempo[0] +'"]').attr('selected',true);
    $('#cboMMEdit option[value="'+ tiempo[1] +'"]').attr('selected',true);
    //alert($('#pagina').val());
    $('#modalEdit').modal('show');
}

//Validar formulario editar tarea
function guardaEditaTarea(){    
    if(document.getElementById('cboCategoriaEdit').value == "seleccione" || document.getElementById('cboSistemaEdit').value == "seleccione" || document.getElementById('txtDescripcionEdit').value.trim() == "" || document.getElementById('cboDificultadEdit').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar esta tarea?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function eliminaTarea(id){
    if(confirm("¿Está seguro que desea eliminar esta tarea?") == true){
        $('#pagina').val('eliminaTarea');
        $('#idEdit').val(id);
        //alert($('#pagina').val());
        document.getElementById('formEdit').action = 'controlador/controlador.php';
        document.getElementById('formEdit').method = 'post';
        document.getElementById('formEdit').submit();
    } else {
        return false;
    }
}

//Validar formulario ingreso de tarjeta
function validaCrearUsuario(){
    if(document.getElementById('txtNombre').value.trim() == "" || document.getElementById('txtApellidos').value.trim() == "" || document.getElementById('cboPerfil').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {        
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaUsuario(json){
    $('#pagina').val('editaUsuario');
    $('#idEdit').val(json.idUsuario);
    $('#txtNombreEdit').val(json.nombres);
    $('#txtApellidosEdit').val(json.apellidos);
    $('#txtEmailEdit').val(json.email);
    $('#txtTelefonoEdit').val(json.telefono);
    $('#cboPerfilEdit option[value="'+ json.idPerfil +'"]').attr('selected',true);
    $('#modalEdit').modal('show');
}

//Validar formulario editar tarea
function guardaEditaUsuario(){    
    if(document.getElementById('txtNombreEdit').value.trim() == "" || document.getElementById('txtApellidosEdit').value.trim() == "" || document.getElementById('cboPerfilEdit').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar esta tarea?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function eliminaUsuario(id){
    if(confirm("¿Está seguro que desea eliminar esta tarea?") == true){
        $('#pagina').val('eliminaUsuario');
        $('#idEdit').val(id);
        //alert($('#pagina').val());
        document.getElementById('formEdit').action = 'controlador/controlador.php';
        document.getElementById('formEdit').method = 'post';
        document.getElementById('formEdit').submit();
    } else {
        return false;
    }
}

//Validar formulario ingreso de tarjeta
function validaCrearSolicitante(){
    if(document.getElementById('txtNombre').value.trim() == "" || document.getElementById('txtArea').value.trim() == "" || document.getElementById('txtCargo').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {        
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaSolicitante(json){
    $('#pagina').val('editaSolicitante');
    $('#idEdit').val(json.idCliente);
    $('#txtNombreEdit').val(json.nombreCliente);
    $('#txtAreaEdit').val(json.areaCliente);
    $('#txtCargoEdit').val(json.cargoCliente);
    $('#modalEdit').modal('show');
}

//Validar formulario editar tarea
function guardaEditaSolicitante(){    
    if(document.getElementById('txtNombreEdit').value.trim() == "" || document.getElementById('txtAreaEdit').value.trim() == "" || document.getElementById('txtCargoEdit').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar esta tarea?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function eliminaSolicitante(id){
    if(confirm("¿Está seguro que desea eliminar a este solicitante?") == true){
        $('#pagina').val('eliminaSolicitante');
        $('#idEdit').val(id);
        //alert($('#pagina').val());
        document.getElementById('formEdit').action = 'controlador/controlador.php';
        document.getElementById('formEdit').method = 'post';
        document.getElementById('formEdit').submit();
    } else {
        return false;
    }
}

//Validar formulario ingreso de tarjeta
function validaCrearCategoria(){
    if(document.getElementById('txtDescripcion').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {        
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaCategoria(json){
    $('#pagina').val('editaCategoria');
    $('#idEdit').val(json.idCategoria);
    $('#txtDescripcionEdit').val(json.descripcionCategoria);
    //$('#txtDescripcionEdit').focus();
    $('#modalEdit').modal('show');
}

//Validar formulario editar tarea
function guardaEditaCategoria(){    
    if(document.getElementById('txtDescripcionEdit').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar esta categoría?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function eliminaCategoria(id){
    if(confirm("¿Está seguro que desea eliminar esta categoría?") == true){
        $('#pagina').val('eliminaCategoria');
        $('#idEdit').val(id);
        //alert($('#pagina').val());
        document.getElementById('formEdit').action = 'controlador/controlador.php';
        document.getElementById('formEdit').method = 'post';
        document.getElementById('formEdit').submit();
    } else {
        return false;
    }
}

//Validar formulario ingreso de tarjeta
function validaCrearSistema(){
    if(document.getElementById('txtDescripcion').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {        
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaSistema(json){
    $('#pagina').val('editaSistema');
    $('#idEdit').val(json.idSistema);
    $('#txtDescripcionEdit').val(json.descripcionSistema);
    //$('#txtDescripcionEdit').focus();
    $('#modalEdit').modal('show');
}

//Validar formulario editar tarea
function guardaEditaSistema(){    
    if(document.getElementById('txtDescripcionEdit').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar este sistema?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function eliminaSistema(id){
    if(confirm("¿Está seguro que desea eliminar este sistema?") == true){
        $('#pagina').val('eliminaSistema');
        $('#idEdit').val(id);
        //alert($('#pagina').val());
        document.getElementById('formEdit').action = 'controlador/controlador.php';
        document.getElementById('formEdit').method = 'post';
        document.getElementById('formEdit').submit();
    } else {
        return false;
    }
}

function muestraAsignarTarjeta(id){
    $('#idTarjetaAsignar').val(id);
    $('#modalAsignar').modal('show');
}

function arrayAsignarUsuario(){
    //ESTA PARTE DE LA FUNCIÓN FUE PENSADA PARA ASIGNAR MÚLTIPLES USUARIOS DE UNA SOLA VEZ. QUEDA DESCARTADA HASTA SOLUCIONAR COMO ELIMINAR DEL ARRAY UN USUARIO ASIGNADO
    /*
    var arrayUsuario = [];
    arrayUsuario.push($('#txtUsuarioAsignado option:selected').text()); 
    //$('#arrayUsuario').text(arrayUsuario);
    if($('#txtUsuarioAsignado').val() != 'seleccione'){
        if($('#arrayUsuario').text() == ''){
            $('#arrayIdUsuarios').val($('#txtUsuarioAsignado option:selected').val());
            arrayUsuario.push($('#arrayIdUsuarios').val());
            $('#arrayUsuario').text($('#txtUsuarioAsignado option:selected').text()).append(" <a href='#' onclick='xxx();'><img id='eliminaUsuarioAsignado' src='img/site/deletex.png' style='width: 15px; height: 15px;'></a>");
        } else {
            $('#arrayIdUsuarios').val($('#arrayIdUsuarios').val() + ',' + $('#txtUsuarioAsignado option:selected').val());
            arrayUsuario.push($('#arrayIdUsuarios').val());
            $('#arrayUsuario').text($('#arrayUsuario').text() + '; ' + $('#txtUsuarioAsignado option:selected').text()).append(" <a href='#' onclick='xxx();'><img id='eliminaUsuarioAsignado' src='img/site/deletex.png' style='width: 15px; height: 15px;'></a>");
        }        
    }
    */
}

function asignaTarjeta(){
    if(confirm("¿Está seguro que desea asignar esta tarea?") == true){
        document.getElementById('formAsignar').action = 'controlador/controlador.php';
        document.getElementById('formAsignar').method = 'post';
        document.getElementById('formAsignar').submit();
    }
}

function autoAsignacionTarjeta(){
    if(confirm("¿Está seguro que desea asignarse esta tarea?") == true){
        $('#pagina').val('autoAsignaTarjeta');
        document.getElementById('formAutoAsignar').action = 'controlador/controlador.php';
        document.getElementById('formAutoAsignar').method = 'post';
        document.getElementById('formAutoAsignar').submit();
    }
}

function finalizaTarea(){
    if(confirm("¿Está seguro que desea dar por finalizada su tarjeta actual?") == true){
        document.getElementById('formFinalilzaTarjeta').action = 'controlador/controlador.php';
        document.getElementById('formFinalilzaTarjeta').method = 'post';
        document.getElementById('formFinalilzaTarjeta').submit();
    } else {
        return false;
    }
}

function reactivarImpedida(){
    if(confirm("¿Está seguro que desea volver esta tarjeta a estado pendiente?") == true){
        $('#pagina').val('reactivarImpedida');
        document.getElementById('formAutoAsignar').action = 'controlador/controlador.php';
        document.getElementById('formAutoAsignar').method = 'post';
        document.getElementById('formAutoAsignar').submit();
    }
}

function eliminarImpedida(){
    if(confirm("¿Está seguro que desea eliminar esta tarea?") == true){
        $('#pagina').val('eliminarImpedida');
        document.getElementById('formAutoAsignar').action = 'controlador/controlador.php';
        document.getElementById('formAutoAsignar').method = 'post';
        document.getElementById('formAutoAsignar').submit();
    }
}

function iniciarTarjeta(){
    if(confirm("¿Está seguro que desea dar inicio en este momento a la tarjeta asignada?") == true){
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
    } else {
        return false;
    }
}

function validaRazonImpedimento(){
    if(confirm("¿Está seguro que desea declarar esta tarjeta como impedida?") == true){
        document.getElementById('formTarjetaImpedida').action = 'controlador/controlador.php';
        document.getElementById('formTarjetaImpedida').method = 'post';
        document.getElementById('formTarjetaImpedida').submit();
    } else {
        return false;
    }
}

//FUNCIONES RELACIONADAS A ENCUESTA

//Validar formulario ingreso de tarjeta
function validaCrearPregunta(){
    if(document.getElementById('txtDescripcion').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {        
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaPregunta(json){
    $('#pagina').val('editaPregunta');
    $('#idEdit').val(json.idPregunta);
    $('#txtDescripcionEdit').val(json.pregunta);
    $('#modalEdit').modal('show');
}

//Validar formulario editar tarea
function guardaEditaPregunta(){    
    if(document.getElementById('txtDescripcionEdit').value.trim() == "")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar esta pregunta?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function eliminaPregunta(id){
    if(confirm("¿Está seguro que desea eliminar esta pregunta?") == true){
        $('#pagina').val('eliminaPregunta');
        $('#idEdit').val(id);
        //alert($('#pagina').val());
        document.getElementById('formEdit').action = 'controlador/controlador.php';
        document.getElementById('formEdit').method = 'post';
        document.getElementById('formEdit').submit();
    } else {
        return false;
    }
}

//Validar formulario ingreso de tarjeta
function validaCrearEncuesta(){
    if(document.getElementById('txtAnio').value.trim() == "" || document.getElementById('txtPeriodo').value.trim() == "" || document.getElementById('cboTipoEncuesta').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {        
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        //alert("Enviado");
    }
}

function editaEncuesta(json){
    $('#pagina').val('editaEncuesta');
    $('#idEdit').val(json.idEncuesta);
    $('#txtAnioEdit').val(json.anio);
    $('#txtPeriodoEdit').val(json.periodo);
    $('#cboTipoEncuestaEdit option[value="'+ json.idTipoEncuesta +'"]').attr('selected',true);
    $('#modalEdit').modal('show');
}

//Validar formulario editar tarea
function guardaEditaEncuesta(){    
    if(document.getElementById('txtAnioEdit').value.trim() == "" || document.getElementById('txtPeriodoEdit').value.trim() == "" || document.getElementById('cboTipoEncuestaEdit').value == "seleccione")
    {
        alert("Completar campos obligatorios");
    } else {
        if(confirm("¿Está seguro de editar esta encuesta?") == true){            
            document.getElementById('formEdit').action = 'controlador/controlador.php';
            document.getElementById('formEdit').method = 'post';
            document.getElementById('formEdit').submit();
        } else {
            $('#modalEdit').modal('hide');
        }
    }
}

function eliminaEncuesta(id){
    if(confirm("¿Está seguro que desea eliminar esta encuesta?") == true){
        $('#pagina').val('eliminaEncuesta');
        $('#idEdit').val(id);
        //alert($('#pagina').val());
        document.getElementById('formEdit').action = 'controlador/controlador.php';
        document.getElementById('formEdit').method = 'post';
        document.getElementById('formEdit').submit();
    } else {
        return false;
    }
}

function asignaPregunta(idEncuesta){
    $('#idEncuesta').val(idEncuesta);
    $('#modalAsignaPregunta').modal('show');
}

function guardaAsignaPregunta(){
    if(confirm("¿Está seguro que desea asignar esta pregunta?") == true){
        document.getElementById('formAsignaPregunta').action = 'controlador/controlador.php';
        document.getElementById('formAsignaPregunta').method = 'post';
        document.getElementById('formAsignaPregunta').submit();
    } else {
        return false;
    }
}

function borraPreguntaEncuesta(json){
    if(confirm("¿Está seguro que desea borrar esta pregunta para esta encuesta?") == true){
        window.location='controlador/controlador.php?pagina=borraPreguntaEncuesta&encuesta='+json.idEncuesta+'&pregunta='+json.idPregunta;
    } else {
        return false;
    }
}

function publicaEncuesta(idEncuesta){
    if(confirm("¿Está seguro que desea publicar esta encuesta?") == true){
        window.location='controlador/controlador.php?pagina=publicaEncuesta&idEncuesta='+idEncuesta;
    } else {
        return false;
    }
}

function validaEnvioEncuesta(){
    //var nro = document.getElementsByTagName("input");
    //alert(nro[40].getAttribute("type"));
    if(confirm("¿Está seguro que desea enviar la encuesta?") == true){
        document.getElementById('formEncuesta').action = 'controlador/controlador.php';
        document.getElementById('formEncuesta').method = 'post';
        document.getElementById('formEncuesta').submit();
    } else {
        return false;
    }
}

function validaFormDashboard(){
    if($("#cboUsuario").val() == 'seleccione' || $("#txtFechaInicio").val() == "" || $("#txtFechaTermino").val() == ""){
        alert("Completar campos obligatorios");
    } else {
        var usuario = $("#cboUsuario").val();
        var desde = $("#txtFechaInicio").val();
        var hasta = $("#txtFechaTermino").val();
        window.open('muestraDashboardUser.php?usuario='+usuario+'&desde='+desde+'&hasta='+hasta, 'Dashboard Usuario');
        /*document.getElementById('formDashboardUser').action = 'muestraDashboardUser.php';
        document.getElementById('formDashboardUser').method = 'post';
        document.getElementById('formDashboardUser').submit();*/
    }
}