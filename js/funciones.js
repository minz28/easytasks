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

//Validar formulario ingreso de tarjeta
function validaTarjeta(){
    if(document.getElementById('cboTarea').value == "seleccione" || document.getElementById('cboPrioridad').value == "seleccione" || document.getElementById('cboEstado').value == "seleccione")    
    {
        alert("Completar campos obligatorios");
    } else {
        document.getElementById('form').action = 'controlador/controlador.php';
        document.getElementById('form').method = 'post';
        document.getElementById('form').submit();
        alert("Enviado");
    }
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

function detalleTarjeta(jsonTarjeta){
    $("#nombreTarea").text(jsonTarjeta.tarea);
    $("#solicitante").text('Solicitado por: '+jsonTarjeta.solicitante);
    $("#fechaSolicitud").text('Fecha solicitud: '+jsonTarjeta.fechaSolicitud);
    $("#prioridad").text('Prioridad: '+jsonTarjeta.prioridad);
    $("#observaciones").text('Observaciones: '+jsonTarjeta.observaciones);
    $('#modalDetalleTarjeta').modal('show');    
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