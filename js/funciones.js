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