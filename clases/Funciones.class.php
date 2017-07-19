<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require("Conexion.class.php");

class Funciones extends Conexion{

	function elimina_acentos($text){
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = array (
            // Espacios, puntos y comas por guion
            //'/[\., ]+/' => ' ',
 
            // Vocales
            '/\+/' => '',
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',
 
            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',
 
            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',
 
            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            // Otras letras y caracteres especiales
            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $text = preg_replace(array_keys($patron),array_values($patron),$text);
        return $text;
    }

	function selectId(){
		$conexion = $this->conectaEasyTasks();
		// Recuperamos el ultimo ID ingresado
		$sql="SELECT LAST_INSERT_ID() AS ULTIMOID;";
		$record = $this->insertEasyTasks($sql);
		$Emp = mysql_fetch_array($record);
		//echo "<br/>".$Emp;
		return $Emp['ULTIMOID'];
		mysql_close($conexion);
	}//FIN function

	function validaLogin($datos){
		try {
    		$sql="	SELECT 		U.ID_USUARIO, U.NOMBRES, U.APELLIDOS, U.EMPRESA, E.DESCRIPCION_EMPRESA, U.PERFIL
					FROM 		USUARIO U
					INNER JOIN 	EMPRESA E
					ON 			U.EMPRESA = E.ID_EMPRESA
					WHERE 		U.USERNAME = '".$datos['txtUsuario']."' 
					AND 		U.PASSWORD = '".$datos['txtPassword']."'
					AND 		U.ESTADO_REGISTRO = 1";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
				while($datos = mysql_fetch_assoc($record)){
					$arreglo['idUsuario'] = $datos['ID_USUARIO'];
					$arreglo['nombreUsuario'] = $datos['NOMBRES']." ".$datos['APELLIDOS'];			
					$arreglo['empresa'] = $datos['EMPRESA'];
					$arreglo['descripcionEmpresa'] = $datos['DESCRIPCION_EMPRESA'];
					$arreglo['perfil'] = $datos['PERFIL'];
				}
				//var_dump($arreglo); die();
				return $arreglo;
	        } else {
	        	return 0;
	        }				
    	} catch (Exception $e) {
    		//echo 'Error: ', $e->getMessage(), "\n";
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
	}

	function cboUsuario(){
		$sql="	SELECT U.ID_USUARIO, U.NOMBRES, U.APELLIDOS, U.USERNAME
				FROM USUARIO U
				WHERE U.EMPRESA = $_SESSION[empresa]
				AND U.PERFIL != 1
				AND U.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		while($usuario = mysql_fetch_assoc($record)){
			$arreglo['cboUsuario'] .= "<option value='".$usuario['ID_USUARIO']."'>".$usuario['NOMBRES']." ".$usuario['APELLIDOS']." (".$usuario['USERNAME'].")"."</option>";
		}
		echo $arreglo['cboUsuario'];
	}

	function cboUsuarioAsignar(){

		$sql="	SELECT U.ID_USUARIO, U.NOMBRES, U.APELLIDOS, U.USERNAME
				FROM USUARIO U				
				WHERE U.ID_USUARIO NOT IN (SELECT TU.USUARIO_RESPONSABLE FROM TARJETA_USUARIO TU WHERE TU.FECHA_TERMINO = '0000-00-00' AND TU.RAZON_ESTADO_IMPEDIDO IS NULL)
				AND U.EMPRESA = $_SESSION[empresa]
				AND U.PERFIL != 1
				AND U.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		while($usuario = mysql_fetch_assoc($record)){
			$arreglo['cboUsuario'] .= "<option value='".$usuario['ID_USUARIO']."'>".$usuario['NOMBRES']." ".$usuario['APELLIDOS']." (".$usuario['USERNAME'].")"."</option>";
		}
		echo $arreglo['cboUsuario'];
	}

	function cboTarea(){
		$sql="	SELECT 		T.ID_TAREA, T.DESCRIPCION_TAREA, S.DESCRIPCION_SISTEMA
				FROM 		TAREA T
				INNER JOIN  SISTEMA S
				ON 			T.SISTEMA = S.ID_SISTEMA
				INNER JOIN 	CATEGORIA C
				ON 			T.CATEGORIA = C.ID_CATEGORIA
				WHERE 		C.EMPRESA = 1
				AND 		T.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboTarea'] .= "<option value='".$tarea['ID_TAREA']."'>".$tarea['DESCRIPCION_SISTEMA']." - ".$tarea['DESCRIPCION_TAREA']."</option>";
		}
		echo $arreglo['cboTarea'];
	}

	function cboPrioridad(){
		$sql="	SELECT 	P.ID_PRIORIDAD, P.DESCRIPCION_PRIORIDAD
				FROM 	PRIORIDAD P
				WHERE 	P.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboPrioridad']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboPrioridad'] .= "<option value='".$tarea['ID_PRIORIDAD']."'>".$tarea['DESCRIPCION_PRIORIDAD']."</option>";
		}
		echo $arreglo['cboPrioridad'];
	}

	function cboEstTarjeta(){
		$sql="	SELECT 	ET.ID_ESTADO_TARJETA, ET.DESCRIPCION_ESTADO_TAJETA
				FROM 	ESTADO_TARJETA ET
				WHERE 	ET.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboEstTarjeta']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboEstTarjeta'] .= "<option value='".$tarea['ID_ESTADO_TARJETA']."'>".$tarea['DESCRIPCION_ESTADO_TAJETA']."</option>";
		}
		echo $arreglo['cboEstTarjeta'];
	}

	function cboCategoria(){
		$sql="	SELECT 	C.ID_CATEGORIA, C.DESCRIPCION_CATEGORIA
				FROM 	CATEGORIA C
				WHERE 	C.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboCategoria']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboCategoria'] .= "<option value='".$tarea['ID_CATEGORIA']."'>".$tarea['DESCRIPCION_CATEGORIA']."</option>";
		}
		echo $arreglo['cboCategoria'];
	}

	function cboSistema(){
		$sql="	SELECT 	S.ID_SISTEMA, S.DESCRIPCION_SISTEMA
				FROM 	SISTEMA S
				WHERE 	S.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboSistema']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboSistema'] .= "<option value='".$tarea['ID_SISTEMA']."'>".$tarea['DESCRIPCION_SISTEMA']."</option>";
		}
		echo $arreglo['cboSistema'];
	}

	function cboDificultad(){
		$sql="	SELECT 	D.ID_DIFICULTAD, D.DESCRIPCION_DIFICULTAD
				FROM 	DIFICULTAD D
				WHERE 	D.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboDificultad']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboDificultad'] .= "<option value='".$tarea['ID_DIFICULTAD']."'>".$tarea['DESCRIPCION_DIFICULTAD']."</option>";
		}
		echo $arreglo['cboDificultad'];
	}

	function cboCliente(){
		$sql="	SELECT 	C.ID_CLIENTE, C.NOMBRE_CLIENTE, C.CARGO_CLIENTE, C.AREA_CLIENTE
				FROM 	CLIENTE C
				WHERE 	C.EMPRESA = 1
				AND 	C.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboCliente']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboCliente'] .= "<option value='".$tarea['ID_CLIENTE']."'>".$tarea['NOMBRE_CLIENTE']." - ".$tarea['CARGO_CLIENTE']." - ".$tarea['AREA_CLIENTE']."</option>";
		}
		echo $arreglo['cboCliente'];
	}
	
	function cboPerfil(){
		$sql="	SELECT 	P.ID_PERFIL, P.DESCRIPCION_PERFIL
				FROM 	PERFIL P
				WHERE 	P.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboPerfil']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboPerfil'] .= "<option value='".$tarea['ID_PERFIL']."'>".$tarea['DESCRIPCION_PERFIL']."</option>";
		}
		echo $arreglo['cboPerfil'];
	}

	function cboRazonImpedimento(){
		$sql="	SELECT 	RI.ID_RAZON, RI.DESCRIPCION_RAZON
				FROM 	RAZON_IMPEDIMENTO RI
				WHERE 	RI.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboRazonImpedimento']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboRazonImpedimento'] .= "<option value='".$tarea['ID_RAZON']."'>".$tarea['DESCRIPCION_RAZON']."</option>";
		}
		echo $arreglo['cboRazonImpedimento'];
	}

	function cboTipoEncuesta(){
		$sql="	SELECT 	TE.ID_TIPO_ENCUESTA, TE.DESCRIPCION_TIPO_ENCUESTA
				FROM 	TIPO_ENCUESTA TE
				WHERE 	TE.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		$arreglo['cboTipoEncuesta']="";
		while($tarea = mysql_fetch_assoc($record)){
			$arreglo['cboTipoEncuesta'] .= "<option value='".$tarea['ID_TIPO_ENCUESTA']."'>".$tarea['DESCRIPCION_TIPO_ENCUESTA']."</option>";
		}
		echo $arreglo['cboTipoEncuesta'];
	}

	//SIN USO HASTA ARREGLAR PASO DE VARIABLES
	function cboPreguntaAsignada($encuesta){
		$sql="	SELECT 	P.ID_PREGUNTA, P.PREGUNTA
				FROM 	PREGUNTA P
				WHERE 	P.ID_PREGUNTA NOT IN (SELECT PE.PREGUNTA FROM PREGUNTA_ENCUESTA PE WHERE PE.ENCUESTA = $encuesta)
				AND 	P.EMPRESA = $_SESSION[empresa]
				AND 	P.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		while($pregunta = mysql_fetch_assoc($record)){
			$arreglo['cboPregunta'] .= "<option value='".$pregunta['ID_PREGUNTA']."'>".$pregunta['PREGUNTA']."</option>";
		}
		echo $arreglo['cboPregunta'];
	}

	function cboPregunta(){
		$sql="	SELECT 	P.ID_PREGUNTA, P.PREGUNTA
				FROM 	PREGUNTA P
				WHERE 	P.EMPRESA = $_SESSION[empresa]
				AND 	P.ESTADO_REGISTRO = 1";
		$record = $this->selectEasyTasks($sql);
		while($pregunta = mysql_fetch_assoc($record)){
			$arreglo['cboPregunta'] .= "<option value='".$pregunta['ID_PREGUNTA']."'>".$pregunta['PREGUNTA']."</option>";
		}
		echo $arreglo['cboPregunta'];
	}

    function creaTarjeta($datos){
    	try {
    		if ($_SESSION['perfil'] == 3) {
    			$sql="INSERT INTO TARJETA (TAREA, CLIENTE_SOLICITANTE, FECHA_SOLICITUD, PRIORIDAD, OBSERVACIONES, ADJUNTO, ESTADO_TARJETA, ESTADO_REGISTRO) 
	                	VALUES ($datos[cboTarea], $datos[txtSolicitante], NOW(), $datos[cboPrioridad], '$datos[txtObservaciones]', '$datos[fileAdjunto]', 2, 1)";
	            if($record=$this->insertEasyTasks($sql)){
	            	$ultimaTarjeta = $this->selectId();
	            	$sql2="INSERT INTO TARJETA_USUARIO (TARJETA, USUARIO_RESPONSABLE, FECHA_INICIO, HORA_INICIO)
	            	VALUES ($ultimaTarjeta, $_SESSION[idUsuario], DATE(NOW()), TIME(NOW()))";
	            	if($record=$this->insertEasyTasks($sql2)){
	            		$_SESSION['tarjetaVigente'] = 1;
    					$_SESSION['idTarjetaVigente'] = $ultimaTarjeta;
	            		return 1;
	            	} else {
	            		echo "<script>alert('Error al autoasignar tarjeta');</script>";
	            		echo "<script>window.history.back();</script>";
	            	}
	            } else {
	            	echo "<script>alert('Error al crear tarjeta');</script>";
	            	echo "<script>window.history.back();</script>";
	            }
    		} elseif ($_SESSION['perfil'] == 2) {//CAMBIAR POR $_SESSION['perfil'] == 2
    			$sql="INSERT INTO TARJETA (TAREA, CLIENTE_SOLICITANTE, FECHA_SOLICITUD, PRIORIDAD, OBSERVACIONES, ADJUNTO, ESTADO_TARJETA, ESTADO_REGISTRO) 
		                VALUES ($datos[cboTarea], $datos[txtSolicitante], NOW(), $datos[cboPrioridad], '$datos[txtObservaciones]', '$datos[fileAdjunto]', 1, 1)";
		                //echo $sql;die();
		        if($record=$this->insertEasyTasks($sql)){
		            //echo "<script>alert('La tarjeta fue creada exitosamente');</script>";
		            return 1;
		        } else {
		            echo "<script>alert('Error al crear tarjeta');</script>";
		            echo "<script>window.history.back();</script>";
		        }
    		}	    		
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
	        
    }

    function editaTarjeta($datos){
    	try {
			$sql="	UPDATE 	TARJETA
    				SET 	TAREA = $datos[cboTareaEdit],
							CLIENTE_SOLICITANTE = $datos[txtSolicitanteEdit],
							PRIORIDAD = $datos[cboPrioridadEdit],
							OBSERVACIONES = '$datos[txtObservacionesEdit]',
							ESTADO_TARJETA = $datos[cboEstadoEdit]
					WHERE 	ID_TARJETA = $datos[idEdit]";
			//echo $sql; die();
			if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al editar tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function muestraTarjetaPendientes(){
    	try {
    		$sql="	SELECT
    					TJ.ID_TARJETA,
						S.DESCRIPCION_SISTEMA,
						T.DESCRIPCION_TAREA,
						C.NOMBRE_CLIENTE,
						C.CARGO_CLIENTE,
						C.AREA_CLIENTE,
						TJ.FECHA_SOLICITUD,
						P.DESCRIPCION_PRIORIDAD,
						TJ.TAREA,
						TJ.CLIENTE_SOLICITANTE,
						TJ.PRIORIDAD,
						TJ.OBSERVACIONES,
						TJ.ADJUNTO,
						TJ.ESTADO_TARJETA,
						ET.DESCRIPCION_ESTADO_TAJETA
					FROM
						TARJETA TJ
					INNER JOIN TAREA T ON TJ.TAREA = T.ID_TAREA
					INNER JOIN SISTEMA S ON T.SISTEMA = S.ID_SISTEMA
					INNER JOIN CLIENTE C ON TJ.CLIENTE_SOLICITANTE = C.ID_CLIENTE
					INNER JOIN PRIORIDAD P ON TJ.PRIORIDAD = P.ID_PRIORIDAD
					INNER JOIN ESTADO_TARJETA ET ON TJ.ESTADO_TARJETA = ET.ID_ESTADO_TARJETA
					WHERE
						C.EMPRESA = ".$_SESSION['empresa']."
					AND TJ.ESTADO_TARJETA = 1
					AND TJ.ESTADO_REGISTRO = 1
					ORDER BY
						TJ.PRIORIDAD DESC, TJ.FECHA_SOLICITUD ASC";
						//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while($datos = mysql_fetch_assoc($record)){
					$arreglo[$i]['idTarjeta'] = $datos['ID_TARJETA'];
					$arreglo[$i]['tarea'] = $datos['DESCRIPCION_SISTEMA']." - ".$datos['DESCRIPCION_TAREA'];			
					$arreglo[$i]['solicitante'] = $datos['NOMBRE_CLIENTE']." - ".$datos['CARGO_CLIENTE']." - ".$datos['AREA_CLIENTE'];
					$arreglo[$i]['fechaSolicitud'] = $datos['FECHA_SOLICITUD'];
					$arreglo[$i]['prioridad'] = $datos['DESCRIPCION_PRIORIDAD'];
					$arreglo[$i]['idTarea'] = $datos['TAREA'];
					$arreglo[$i]['idSolicitante'] = $datos['CLIENTE_SOLICITANTE'];
					$arreglo[$i]['idPrioridad'] = $datos['PRIORIDAD'];
					$arreglo[$i]['observaciones'] = $datos['OBSERVACIONES'];
					//$arreglo[$i]['adjunto'] = $datos['ADJUNTO'];
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//return $arreglo;
				foreach ($arreglo as $tarjeta) {
					//echo "<tr><td class='warning' style='background: url(ruta de la imagen);'>";
					$tarjetaJson=json_encode($tarjeta);
					echo "<tr><td style='background-color: #fdfd96; color: black; 
					border-radius: 0px 0px 50px 0px;
					-moz-border-radius: 0px 0px 50px 0px;
					-webkit-border-radius: 0px 0px 50px 0px;
					'>";
					echo "<a style='color: black;' href='#' onclick='detalleTarjeta(".$tarjetaJson.")'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</a><br>";
					if ($_SESSION['perfil'] == 2) {
						//echo "<button type='button' class='btn btn-default' onclick='editaTarjeta($tarjetaJson);'><span class='glyphicon glyphicon-edit'></span></button>";
						//echo "<a href='#' style='color: black' class='glyphicon glyphicon-edit' onclick='editaTarjeta($tarjetaJson);'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<a href='#' title='Editar tarjeta' style='color: black' class='material-icons' onclick='editaTarjeta($tarjetaJson);'>&#xe254;</a>&nbsp;&nbsp;";
						echo "<a href='#' title='Asignar usuario' style='color: black' class='material-icons' onclick='muestraAsignarTarjeta($tarjeta[idTarjeta]);'>&#xe7f0;</i>";
					}					
					echo "<br></td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #fdfd96; color: black;
					border-radius: 10px 10px 10px 10px;
                    -moz-border-radius: 10px 10px 10px 10px;
                    -webkit-border-radius: 10px 10px 10px 10px;
                    border: 5px solid #ffffff'>";
				echo "<h6>NO EXISTEN TARJETAS PENDIENTES</h6>";
				echo "</td></tr>";
			}
				
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function muestraTarjetaEnDesarrollo(){
    	try {
    		$sql="	SELECT
						S.DESCRIPCION_SISTEMA,
						T.DESCRIPCION_TAREA,
						C.NOMBRE_CLIENTE,
						C.CARGO_CLIENTE,
						C.AREA_CLIENTE,
						TJ.FECHA_SOLICITUD,
						P.DESCRIPCION_PRIORIDAD,
						TJ.OBSERVACIONES,
						TJ.ESTADO_TARJETA,
						ET.DESCRIPCION_ESTADO_TAJETA
					FROM
						TARJETA TJ
					INNER JOIN TAREA T ON TJ.TAREA = T.ID_TAREA
					INNER JOIN SISTEMA S ON T.SISTEMA = S.ID_SISTEMA
					INNER JOIN CLIENTE C ON TJ.CLIENTE_SOLICITANTE = C.ID_CLIENTE
					INNER JOIN PRIORIDAD P ON TJ.PRIORIDAD = P.ID_PRIORIDAD
					INNER JOIN ESTADO_TARJETA ET ON TJ.ESTADO_TARJETA = ET.ID_ESTADO_TARJETA
					WHERE
						C.EMPRESA = ".$_SESSION['empresa']."
					AND TJ.ESTADO_TARJETA = 2
					AND TJ.ESTADO_REGISTRO = 1
					ORDER BY
						TJ.ESTADO_TARJETA ASC, TJ.FECHA_SOLICITUD ASC";
						//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while($datos = mysql_fetch_assoc($record)){
					$arreglo[$i]['tarea'] = $datos['DESCRIPCION_SISTEMA']." - ".$datos['DESCRIPCION_TAREA'];			
					$arreglo[$i]['solicitante'] = $datos['NOMBRE_CLIENTE']." - ".$datos['CARGO_CLIENTE']." - ".$datos['AREA_CLIENTE'];
					$arreglo[$i]['fechaSolicitud'] = $datos['FECHA_SOLICITUD'];
					$arreglo[$i]['prioridad'] = $datos['DESCRIPCION_PRIORIDAD'];
					$arreglo[$i]['observaciones'] = $datos['OBSERVACIONES'];
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//var_dump($arreglo); die();					
				foreach ($arreglo as $tarjeta) {
					$tarjetaJson=json_encode($tarjeta);
					echo "<tr><td style='background-color: #779ecb; color: black;
					border-radius: 0px 0px 50px 0px;
					-moz-border-radius: 0px 0px 50px 0px;
					-webkit-border-radius: 0px 0px 50px 0px;
					border: 5px solid #ffffff;'>";
					echo "<a style='color: black;' href='#' onclick='detalleTarjeta(".$tarjetaJson.")'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</a><br>";
					echo "<br></td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #779ecb; color: black;
					border-radius: 10px 10px 10px 10px;
                    -moz-border-radius: 10px 10px 10px 10px;
                    -webkit-border-radius: 10px 10px 10px 10px;
                    border: 5px solid #ffffff'>";
				echo "<h6>NO EXISTEN TARJETAS EN DESARROLLO</h6>";
				echo "</td></tr>";
			}
				
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function muestraTarjetaTerminadas(){
    	try {
    		$sql="	SELECT
						S.DESCRIPCION_SISTEMA,
						T.DESCRIPCION_TAREA,
						C.NOMBRE_CLIENTE,
						C.CARGO_CLIENTE,
						C.AREA_CLIENTE,
						TJ.FECHA_SOLICITUD,
						P.DESCRIPCION_PRIORIDAD,
						TJ.OBSERVACIONES,
						TJ.ESTADO_TARJETA,
						ET.DESCRIPCION_ESTADO_TAJETA
					FROM
						TARJETA TJ
					INNER JOIN TAREA T ON TJ.TAREA = T.ID_TAREA
					INNER JOIN SISTEMA S ON T.SISTEMA = S.ID_SISTEMA
					INNER JOIN CLIENTE C ON TJ.CLIENTE_SOLICITANTE = C.ID_CLIENTE
					INNER JOIN PRIORIDAD P ON TJ.PRIORIDAD = P.ID_PRIORIDAD
					INNER JOIN ESTADO_TARJETA ET ON TJ.ESTADO_TARJETA = ET.ID_ESTADO_TARJETA
					INNER JOIN TARJETA_USUARIO TU ON TJ.ID_TARJETA = TU.TARJETA
					WHERE
						C.EMPRESA = ".$_SESSION['empresa']."
					AND TJ.ESTADO_TARJETA = 3
					AND TU.FECHA_TERMINO = DATE(NOW())
					AND TJ.ESTADO_REGISTRO = 1
					ORDER BY
						TJ.ESTADO_TARJETA ASC, TJ.FECHA_SOLICITUD ASC";
						//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while($datos = mysql_fetch_assoc($record)){
					$arreglo[$i]['tarea'] = $datos['DESCRIPCION_SISTEMA']." - ".$datos['DESCRIPCION_TAREA'];			
					$arreglo[$i]['solicitante'] = $datos['NOMBRE_CLIENTE']." - ".$datos['CARGO_CLIENTE']." - ".$datos['AREA_CLIENTE'];
					$arreglo[$i]['fechaSolicitud'] = $datos['FECHA_SOLICITUD'];
					$arreglo[$i]['prioridad'] = $datos['DESCRIPCION_PRIORIDAD'];
					$arreglo[$i]['observaciones'] = $datos['OBSERVACIONES'];
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//var_dump($arreglo); die();
				foreach ($arreglo as $tarjeta) {
					$tarjetaJson=json_encode($tarjeta);
					echo "<tr><td style='background-color: #6ae96a; color: black; 
					border-radius: 0px 0px 50px 0px;
					-moz-border-radius: 0px 0px 50px 0px;
					-webkit-border-radius: 0px 0px 50px 0px;
					border: 5px solid #ffffff;'>";
					echo "<a style='color: black;' href='#' onclick='detalleTarjeta(".$tarjetaJson.")'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</a><br>";
					echo "<br></td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #6ae96a; color: black;
					border-radius: 10px 10px 10px 10px;
                    -moz-border-radius: 10px 10px 10px 10px;
                    -webkit-border-radius: 10px 10px 10px 10px;
                    border: 5px solid #ffffff'>";
				echo "<h6>NO EXISTEN TARJETAS TERMINADAS</h6>";
				echo "</td></tr>";
			}
				
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function muestraTarjetaImpedidas(){
    	try {
    		$sql="	SELECT
    					TJ.ID_TARJETA,
						S.DESCRIPCION_SISTEMA,
						T.DESCRIPCION_TAREA,
						C.NOMBRE_CLIENTE,
						C.CARGO_CLIENTE,
						C.AREA_CLIENTE,
						TJ.FECHA_SOLICITUD,
						P.DESCRIPCION_PRIORIDAD,
						TJ.OBSERVACIONES,
						TJ.ESTADO_TARJETA,
						ET.DESCRIPCION_ESTADO_TAJETA
					FROM
						TARJETA TJ
					INNER JOIN TAREA T ON TJ.TAREA = T.ID_TAREA
					INNER JOIN SISTEMA S ON T.SISTEMA = S.ID_SISTEMA
					INNER JOIN CLIENTE C ON TJ.CLIENTE_SOLICITANTE = C.ID_CLIENTE
					INNER JOIN PRIORIDAD P ON TJ.PRIORIDAD = P.ID_PRIORIDAD
					INNER JOIN ESTADO_TARJETA ET ON TJ.ESTADO_TARJETA = ET.ID_ESTADO_TARJETA
					WHERE
						C.EMPRESA = ".$_SESSION['empresa']."
					AND TJ.ESTADO_TARJETA = 4
					AND TJ.ESTADO_REGISTRO = 1
					ORDER BY
						TJ.ESTADO_TARJETA ASC, TJ.FECHA_SOLICITUD ASC";
						//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while($datos = mysql_fetch_assoc($record)){
					$arreglo[$i]['idTarjeta'] = $datos['ID_TARJETA'];
					$arreglo[$i]['tarea'] = $datos['DESCRIPCION_SISTEMA']." - ".$datos['DESCRIPCION_TAREA'];			
					$arreglo[$i]['solicitante'] = $datos['NOMBRE_CLIENTE']." - ".$datos['CARGO_CLIENTE']." - ".$datos['AREA_CLIENTE'];
					$arreglo[$i]['fechaSolicitud'] = $datos['FECHA_SOLICITUD'];
					$arreglo[$i]['prioridad'] = $datos['DESCRIPCION_PRIORIDAD'];
					$arreglo[$i]['observaciones'] = $datos['OBSERVACIONES'];
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//var_dump($arreglo); die();
				foreach ($arreglo as $tarjeta) {
					$tarjetaJson=json_encode($tarjeta);
					echo "<tr><td style='background-color: #fe2e2e; color: black;
					border-radius: 0px 0px 50px 0px;
					-moz-border-radius: 0px 0px 50px 0px;
					-webkit-border-radius: 0px 0px 50px 0px;
					border: 5px solid #ffffff;'>";
					echo "<a style='color: black;' href='#' onclick='detalleTarjeta(".$tarjetaJson.")'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</a><br>";
					echo "<br></td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #fe2e2e; color: black;
					border-radius: 10px 10px 10px 10px;
                    -moz-border-radius: 10px 10px 10px 10px;
                    -webkit-border-radius: 10px 10px 10px 10px;
                    border: 5px solid #ffffff'>";
				echo "<h6>NO EXISTEN TARJETAS IMPEDIDAS</h6>";
				echo "</td></tr>";
			}				
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function listaTarea(){
    	try {
    		$sql = "SELECT
						T.ID_TAREA,
						T.CATEGORIA,
						T.SISTEMA,
						T.DESCRIPCION_TAREA,
						T.DIFICULTAD,
						T.TIEMPO_ESTIMADO_TAREA,
						C.DESCRIPCION_CATEGORIA,
						S.DESCRIPCION_SISTEMA,
						D.DESCRIPCION_DIFICULTAD						
					FROM
						TAREA T
					INNER JOIN CATEGORIA C ON T.CATEGORIA = C.ID_CATEGORIA
					INNER JOIN SISTEMA S ON T.SISTEMA = S.ID_SISTEMA
					INNER JOIN DIFICULTAD D ON T.DIFICULTAD = D.ID_DIFICULTAD
					WHERE
						C.EMPRESA = $_SESSION[empresa]
					AND T.ESTADO_REGISTRO = 1";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idTarea'] = $datos['ID_TAREA'];
					$arreglo[$i]['idCategoria'] = $datos['CATEGORIA'];
					$arreglo[$i]['idSistema'] = $datos['SISTEMA'];
					$arreglo[$i]['tarea'] = $datos['DESCRIPCION_TAREA'];
					$arreglo[$i]['idDificultad'] = $datos['DIFICULTAD'];
					$arreglo[$i]['tiempoEstimado'] = $datos['TIEMPO_ESTIMADO_TAREA'];
					$arreglo[$i]['categoria'] = $datos['DESCRIPCION_CATEGORIA'];
					$arreglo[$i]['sistema'] = $datos['DESCRIPCION_SISTEMA'];
					$arreglo[$i]['dificultad'] = $datos['DESCRIPCION_DIFICULTAD'];
					$i++;
				}
				$indiceTarea=1;
				foreach ($arreglo as $tarea) {
					$tareaJson = json_encode($tarea);
					echo "<tr>";
					echo "<td>".$indiceTarea."</td>";
					echo "<td>".$tarea['categoria']."</td>";
					echo "<td>".$tarea['sistema']."</td>";
					echo "<td>".$tarea['tarea']."</td>";
					echo "<td>".$tarea['dificultad']."</td>";
					echo "<td>".$tarea['tiempoEstimado']."</td>";					
					echo "<td><button type='button' class='btn btn-default' onclick='editaTarea(".$tareaJson.")'><span class='glyphicon glyphicon-edit'></span></button></td>";
					echo "<td><button type='button' class='btn btn-default' onclick='eliminaTarea(".$tarea['idTarea'].")'><span class='glyphicon glyphicon-remove'></span></button></td>";
					echo "</tr>";
					$indiceTarea++;
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado tareas, si desea agregar una haga click <a href='#' data-toggle='modal' data-target='#modalAdd'>acá</a>.</h4></td></tr>";
				//echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado tareas, si desea agregar una haga click <button type='button' class='btn btn-link' data-toggle='modal' data-target='#modalAdd'>acá</button>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function creaTarea($datos){
    	try {
    		$tiempoEstimadoTarea = $datos['cboHH'].":".$datos['cboMM'].":"."00";
    		$sql="INSERT INTO TAREA (CATEGORIA, SISTEMA, DESCRIPCION_TAREA, DIFICULTAD, TIEMPO_ESTIMADO_TAREA, ESTADO_REGISTRO) 
	                VALUES (".$datos['cboCategoria'].", ".$datos['cboSistema'].", '".$datos['txtDescripcion']."', "
	                	.$datos['cboDificultad'].", '".$tiempoEstimadoTarea."', 1)";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al agregar tarea');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function editaTarea($datos){
    	try {
    		$tiempoEstimadoTarea = $datos['cboHHEdit'].":".$datos['cboMMEdit'].":"."00";
    		$sql="	UPDATE 	TAREA
    				SET 	CATEGORIA = ".$datos['cboCategoriaEdit'].",
							SISTEMA = ".$datos['cboSistemaEdit'].",
							DESCRIPCION_TAREA = '".$datos['txtDescripcionEdit']."',
							DIFICULTAD = ".$datos['cboDificultadEdit'].",
							TIEMPO_ESTIMADO_TAREA = '".$tiempoEstimadoTarea."'
					WHERE 	ID_TAREA = ".$datos['idEdit'];
			//echo $sql; die();
			if($record=$this->insertEasyTasks($sql)){	            
	            return 1;
	        } else {
	            echo "<script>alert('Error al editar tarea');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function eliminaTarea($datos){
    	try {
    		$sql = "UPDATE TAREA
					SET ESTADO_REGISTRO = 2
					WHERE
						ID_TAREA = ".$datos['idEdit'];
			//echo $sql; die();
    	if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al eliminar tarea');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function listaUsuario(){
    	try {
    		$sql = "SELECT
    					U.ID_USUARIO,
						U.NOMBRES,
						U.APELLIDOS,
						U.EMAIL,
						U.TELEFONO,
						U.USERNAME,
						U.PERFIL,
						P.DESCRIPCION_PERFIL
					FROM
						USUARIO U
					INNER JOIN
						PERFIL P
					ON
						U.PERFIL = P.ID_PERFIL
					WHERE
						U.EMPRESA = $_SESSION[empresa]
					AND U.ESTADO_REGISTRO = 1
					ORDER BY
						U.PERFIL DESC";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idUsuario'] = $datos['ID_USUARIO'];
					$arreglo[$i]['nombres'] = $datos['NOMBRES'];
					$arreglo[$i]['apellidos'] = $datos['APELLIDOS'];
					$arreglo[$i]['email'] = $datos['EMAIL'];
					$arreglo[$i]['telefono'] = $datos['TELEFONO'];
					$arreglo[$i]['username'] = $datos['USERNAME'];
					$arreglo[$i]['idPerfil'] = $datos['PERFIL'];
					$arreglo[$i]['perfil'] = $datos['DESCRIPCION_PERFIL'];
					$i++;
				}
				$indiceUsuario=1;
				foreach ($arreglo as $usuario) {
					$usuarioJson = json_encode($usuario);
					echo "<tr>";
					echo "<td>".$indiceUsuario."</td>";
					echo "<td>".$usuario['nombres']." ".$usuario['apellidos'],"</td>";
					echo "<td>".$usuario['email']."</td>";
					echo "<td>".$usuario['telefono']."</td>";
					echo "<td>".$usuario['username']."</td>";
					echo "<td>".$usuario['perfil']."</td>";
					echo "<td><button type='button' class='btn btn-default' onclick='editaUsuario(".$usuarioJson.")'><span class='glyphicon glyphicon-edit'></span></button></td>";
					echo "<td><button type='button' class='btn btn-default' onclick='eliminaUsuario(".$usuario['idUsuario'].")'><span class='glyphicon glyphicon-remove'></span></button></td>";
					echo "</tr>";
					$indiceUsuario++;
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado usuarios, si desea agregar una haga click <a href='#' data-toggle='modal' data-target='#modalAdd'>acá</a>.</h4></td></tr>";
				//echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado tareas, si desea agregar una haga click <button type='button' class='btn btn-link' data-toggle='modal' data-target='#modalAdd'>acá</button>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function creaUsuario($datos){
    	try {
    		$nombreUsername = explode(" ", utf8_decode($datos['txtNombre']));    		
    		$apellidoUsername = explode(" ", utf8_decode($datos['txtApellidos']));
    		$username = substr($nombreUsername[0], 0, 1).$apellidoUsername[0];
    		$sql="INSERT INTO USUARIO (NOMBRES, APELLIDOS, EMPRESA, EMAIL, TELEFONO, USERNAME, PASSWORD, PERFIL, ESTADO_REGISTRO) 
	                VALUES ('".utf8_decode($datos['txtNombre'])."', '".utf8_decode($datos['txtApellidos'])."', 1, '".$datos['txtEmail']."',
	                	'".$datos['txtTelefono']."', '".strtoupper($username)."', '".strtoupper($username)."', $datos[cboPerfil], 1)";
			//echo $sql;die();	        
	        if($record=$this->insertEasyTasks($sql)){
            	return 1;
	        } else {
	            echo "<script>alert('Error al crear usuario');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
	        
    }

    function editaUsuario($datos){
    	try {
    		$sql="	UPDATE 	USUARIO
    				SET 	NOMBRES 	= '$datos[txtNombreEdit]',
							APELLIDOS 	= '$datos[txtApellidosEdit]',
							EMAIL 		= '$datos[txtEmailEdit]',
							TELEFONO 	= '$datos[txtTelefonoEdit]',
							PERFIL 		= $datos[cboPerfilEdit]
					WHERE 	ID_USUARIO 	= $datos[idEdit]";
			//echo $sql; die();
			if($record=$this->insertEasyTasks($sql)){	            
	            return 1;
	        } else {
	            echo "<script>alert('Error al editar usuario');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function eliminaUsuario($datos){
    	try {
    		$sql = "UPDATE USUARIO
					SET ESTADO_REGISTRO = 2
					WHERE
						ID_USUARIO = ".$datos['idEdit'];
			//echo $sql; die();
    	if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al eliminar tarea');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function listaSolicitante(){
    	try {
    		$sql = "SELECT
    					C.ID_CLIENTE,
						C.NOMBRE_CLIENTE,
						C.AREA_CLIENTE,
						C.CARGO_CLIENTE
					FROM
						CLIENTE C
					WHERE
						C.EMPRESA = $_SESSION[empresa]
					AND C.ESTADO_REGISTRO = 1";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idCliente'] = $datos['ID_CLIENTE'];
					$arreglo[$i]['nombreCliente'] = $datos['NOMBRE_CLIENTE'];
					$arreglo[$i]['areaCliente'] = $datos['AREA_CLIENTE'];
					$arreglo[$i]['cargoCliente'] = $datos['CARGO_CLIENTE'];
					$i++;
				}
				$indiceLista=1;
				foreach ($arreglo as $solicitante) {
					$json = json_encode($solicitante);
					echo "<tr>";
					echo "<td>".$indiceLista."</td>";
					echo "<td>".$solicitante['nombreCliente']."</td>";
					echo "<td>".$solicitante['areaCliente']."</td>";
					echo "<td>".$solicitante['cargoCliente']."</td>";					
					echo "<td><button type='button' class='btn btn-default' onclick='editaSolicitante(".$json.")'><span class='glyphicon glyphicon-edit'></span></button></td>";
					echo "<td><button type='button' class='btn btn-default' onclick='eliminaSolicitante(".$solicitante['idCliente'].")'><span class='glyphicon glyphicon-remove'></span></button></td>";
					echo "</tr>";
					$indiceLista++;
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado solicitantes, si desea agregar una haga click <a href='#' data-toggle='modal' data-target='#modalAdd'>acá</a>.</h4></td></tr>";
				//echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado tareas, si desea agregar una haga click <button type='button' class='btn btn-link' data-toggle='modal' data-target='#modalAdd'>acá</button>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }
    
    function creaSolicitante($datos){
    	try {
    		$sql="INSERT INTO CLIENTE (NOMBRE_CLIENTE, EMPRESA, AREA_CLIENTE, CARGO_CLIENTE, ESTADO_REGISTRO) 
	                VALUES ('$datos[txtNombre]', $_SESSION[empresa], '$datos[txtArea]', '$datos[txtCargo]', 1)";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al agregar solicitante');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function editaSolicitante($datos){
    	try {
			$sql="	UPDATE 	CLIENTE
    				SET 	NOMBRE_CLIENTE 	= '$datos[txtNombreEdit]',
							AREA_CLIENTE 	= '$datos[txtAreaEdit]',
							CARGO_CLIENTE	= '$datos[txtCargoEdit]'
					WHERE 	ID_CLIENTE	 	= $datos[idEdit]";
			//echo $sql; die();
			if($record=$this->insertEasyTasks($sql)){	            
	            return 1;
	        } else {
	            echo "<script>alert('Error al editar solicitante');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function eliminaSolicitante($datos){
    	try {
    		$sql = "UPDATE CLIENTE
					SET ESTADO_REGISTRO = 2
					WHERE
						ID_CLIENTE = ".$datos['idEdit'];
			//echo $sql; die();
    	if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al eliminar solicitante');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function listaCategoria(){
    	try {
    		$sql = "SELECT
    					C.ID_CATEGORIA,
						C.DESCRIPCION_CATEGORIA
					FROM
						CATEGORIA C
					WHERE
						C.EMPRESA = $_SESSION[empresa]
					AND C.ESTADO_REGISTRO = 1";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idCategoria'] = $datos['ID_CATEGORIA'];
					$arreglo[$i]['descripcionCategoria'] = $datos['DESCRIPCION_CATEGORIA'];
					$i++;
				}
				$indiceLista=1;
				foreach ($arreglo as $categoria) {
					$json = json_encode($categoria);
					echo "<tr>";
					echo "<td>".$indiceLista."</td>";
					echo "<td>".$categoria['descripcionCategoria']."</td>";
					echo "<td><button type='button' class='btn btn-default' onclick='editaCategoria(".$json.")'><span class='glyphicon glyphicon-edit'></span></button></td>";
					echo "<td><button type='button' class='btn btn-default' onclick='eliminaCategoria(".$categoria['idCategoria'].")'><span class='glyphicon glyphicon-remove'></span></button></td>";
					echo "</tr>";
					$indiceLista++;
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado areas, si desea agregar una haga click <a href='#' data-toggle='modal' data-target='#modalAdd'>acá</a>.</h4></td></tr>";
				//echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado tareas, si desea agregar una haga click <button type='button' class='btn btn-link' data-toggle='modal' data-target='#modalAdd'>acá</button>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }
    
    function creaCategoria($datos){
    	try {
    		$sql="INSERT INTO CATEGORIA (DESCRIPCION_CATEGORIA, EMPRESA, ESTADO_REGISTRO) 
	                VALUES ('$datos[txtDescripcion]', $_SESSION[empresa], 1)";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al agregar categoria');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function editaCategoria($datos){
    	try {
			$sql="	UPDATE 	CATEGORIA
    				SET 	DESCRIPCION_CATEGORIA = '$datos[txtDescripcionEdit]'
					WHERE 	ID_CATEGORIA = $datos[idEdit]";
			//echo $sql; die();
			if($record=$this->insertEasyTasks($sql)){	            
	            return 1;
	        } else {
	            echo "<script>alert('Error al editar categoría');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function eliminaCategoria($datos){
    	try {
    		$sql = "UPDATE CATEGORIA
					SET ESTADO_REGISTRO = 2
					WHERE
						ID_CATEGORIA = ".$datos['idEdit'];
			//echo $sql; die();
    	if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al eliminar categoría');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

	function listaSistema(){
    	try {
    		$sql = "SELECT
    					S.ID_SISTEMA,
						S.DESCRIPCION_SISTEMA
					FROM
						SISTEMA S
					WHERE
						S.EMPRESA = $_SESSION[empresa]
					AND S.ESTADO_REGISTRO = 1";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idSistema'] = $datos['ID_SISTEMA'];
					$arreglo[$i]['descripcionSistema'] = $datos['DESCRIPCION_SISTEMA'];
					$i++;
				}
				$indiceLista=1;
				foreach ($arreglo as $sistema) {
					$json = json_encode($sistema);
					echo "<tr>";
					echo "<td>".$indiceLista."</td>";
					echo "<td>".$sistema['descripcionSistema']."</td>";
					echo "<td><button type='button' class='btn btn-default' onclick='editaSistema(".$json.")'><span class='glyphicon glyphicon-edit'></span></button></td>";
					echo "<td><button type='button' class='btn btn-default' onclick='eliminaSistema(".$sistema['idSistema'].")'><span class='glyphicon glyphicon-remove'></span></button></td>";
					echo "</tr>";
					$indiceLista++;
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado sistemas, si desea agregar una haga click <a href='#' data-toggle='modal' data-target='#modalAdd'>acá</a>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }
    
    function creaSistema($datos){
    	try {
    		$sql="INSERT INTO SISTEMA (DESCRIPCION_SISTEMA, EMPRESA, ESTADO_REGISTRO) 
	                VALUES ('$datos[txtDescripcion]', $_SESSION[empresa], 1)";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al agregar sistema');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function editaSistema($datos){
    	try {
			$sql="	UPDATE 	SISTEMA
    				SET 	DESCRIPCION_SISTEMA = '$datos[txtDescripcionEdit]'
					WHERE 	ID_SISTEMA = $datos[idEdit]";
			//echo $sql; die();
			if($record=$this->insertEasyTasks($sql)){	            
	            return 1;
	        } else {
	            echo "<script>alert('Error al editar sistema');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function eliminaSistema($datos){
    	try {
    		$sql = "UPDATE SISTEMA
					SET ESTADO_REGISTRO = 2
					WHERE
						ID_SISTEMA = ".$datos['idEdit'];
			//echo $sql; die();
    	if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al eliminar sistema');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function asignaTarjeta($datos){
    	try {
    		$sql="INSERT INTO TARJETA_USUARIO (TARJETA, USUARIO_RESPONSABLE) 
	                VALUES ($datos[idTarjetaAsignar], $datos[txtUsuarioAsignado])";
	                //VALUES ($datos[idTarjeta], $datos[txtUsuarioAsignado], DATE(NOW()), TIME(NOW()))";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al asignar tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function autoAsignaTarjeta($datos){
    	try {
    		$sql="INSERT INTO TARJETA_USUARIO (TARJETA, USUARIO_RESPONSABLE, FECHA_INICIO, HORA_INICIO) 
	                VALUES ($datos[idTarjetaAutoAsignar], $_SESSION[idUsuario], DATE(NOW()), TIME(NOW()))";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            $sql2="UPDATE TARJETA SET ESTADO_TARJETA = 2 WHERE ID_TARJETA = $datos[idTarjetaAutoAsignar]";
	            //echo $sql2;die();
	            if($record=$this->insertEasyTasks($sql2)){
	            	$_SESSION['tarjetaVigente'] = 1;
    				$_SESSION['idTarjetaVigente'] = $datos['idTarjetaAutoAsignar'];
	            	return 1;
	            } else {
	            	echo "<script>alert('Error al autoasignar tarjeta, no se ha podido actualizar el estado de la tajeta');</script>";
	            	echo "<script>window.history.back();</script>";
	            }	            
	        } else {
	            echo "<script>alert('Error al autoasignar tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }
    
    function validaTareaVigente(){
    	try {
    		$sql="	SELECT 	TARJETA, FECHA_INICIO 
    				FROM 	TARJETA_USUARIO 
    				WHERE 	USUARIO_RESPONSABLE = $_SESSION[idUsuario] 
    				AND 	FECHA_TERMINO = '0000-00-00' 
    				AND 	RAZON_ESTADO_IMPEDIDO IS NULL";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
	        	while ($datos = mysql_fetch_assoc($record)) {
					$tarjeta['idTarjeta'] = $datos['TARJETA'];
					$tarjeta['fechaInicio'] = $datos['FECHA_INICIO'];
				}
	        	return $tarjeta;
			} else {
				return 0;
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function finalizaTarea(){
    	try {
    		$sql = "UPDATE TARJETA_USUARIO
					SET FECHA_TERMINO = DATE(NOW()), 
					HORA_TERMINO = TIME(NOW()), 
					DURACION_TOTAL = 					
						SEC_TO_TIME(
							TIMESTAMPDIFF(
								SECOND,
								CONCAT(FECHA_INICIO,' ',HORA_INICIO),
								NOW()
							)
						)
					WHERE TARJETA = $_SESSION[idTarjetaVigente]
					AND USUARIO_RESPONSABLE = $_SESSION[idUsuario]";
			//echo $sql; die();
    		if($record=$this->insertEasyTasks($sql)){
    			$sql2 = "UPDATE TARJETA SET ESTADO_TARJETA = 3 WHERE ID_TARJETA = $_SESSION[idTarjetaVigente]";
    			if($record=$this->insertEasyTasks($sql2)){
    				$_SESSION['tarjetaVigente'] = 0;
    				$_SESSION['idTarjetaVigente'] = "";
	            	return 1;	
    			}    			
	        } else {
	            echo "<script>alert('Error al finalizar tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function reactivarImpedida($datos){
    	try {
    		$sql = "INSERT INTO TARJETA (TAREA, CLIENTE_SOLICITANTE, FECHA_SOLICITUD, PRIORIDAD, OBSERVACIONES, ADJUNTO, ESTADO_TARJETA, ESTADO_REGISTRO)
					SELECT TAREA, CLIENTE_SOLICITANTE, FECHA_SOLICITUD, PRIORIDAD, OBSERVACIONES, ADJUNTO, 1 AS ESTADO_TARJETA, ESTADO_REGISTRO 
					FROM TARJETA WHERE ID_TARJETA = $datos[idTarjetaAutoAsignar]";
			//echo $sql; die();
    		if($record=$this->insertEasyTasks($sql)){
    			$sql2 = "UPDATE TARJETA SET ESTADO_REGISTRO = 2 WHERE ID_TARJETA = $datos[idTarjetaAutoAsignar]";
    			if($record=$this->insertEasyTasks($sql2)){
	            	return 1;	
    			}    			
	        } else {
	            echo "<script>alert('Error al reactivar tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

	function eliminarImpedida($datos){
    	try {
    		$sql = "UPDATE TARJETA SET ESTADO_REGISTRO = 2 WHERE ID_TARJETA = $datos[idTarjetaAutoAsignar]";
			//echo $sql; die();
    		if($record=$this->insertEasyTasks($sql)){
	            	return 1;	
	        } else {
	            echo "<script>alert('Error al reactivar tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function verTarjetaAsignada($idTarjeta){
    	try {
    		$sql="	SELECT
						S.DESCRIPCION_SISTEMA,
						T.DESCRIPCION_TAREA,
						C.NOMBRE_CLIENTE,
						C.CARGO_CLIENTE,
						C.AREA_CLIENTE,
						TJ.FECHA_SOLICITUD,
						P.DESCRIPCION_PRIORIDAD,
						TJ.OBSERVACIONES
					FROM
						TARJETA TJ
					INNER JOIN TAREA T ON TJ.TAREA = T.ID_TAREA
					INNER JOIN SISTEMA S ON T.SISTEMA = S.ID_SISTEMA
					INNER JOIN CLIENTE C ON TJ.CLIENTE_SOLICITANTE = C.ID_CLIENTE
					INNER JOIN PRIORIDAD P ON TJ.PRIORIDAD = P.ID_PRIORIDAD
					WHERE
						TJ.ID_TARJETA = $idTarjeta";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
	        	while ($datos = mysql_fetch_assoc($record)) {
					$tarjeta['tarea'] = $datos['DESCRIPCION_SISTEMA']." - ".$datos['DESCRIPCION_TAREA'];
					$tarjeta['solicitante'] = $datos['NOMBRE_CLIENTE']." - ".$datos['CARGO_CLIENTE']." - ".$datos['AREA_CLIENTE'];
					$tarjeta['fechaSolicitud'] = $datos['FECHA_SOLICITUD'];
					$tarjeta['prioridad'] = $datos['DESCRIPCION_PRIORIDAD'];
					$tarjeta['observaciones'] = $datos['OBSERVACIONES'];
				}
	        	return $tarjeta;
			} else {
				return 0;
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function iniciarTarjeta(){
    	try {
    		$sql= " UPDATE TARJETA_USUARIO 
	                SET FECHA_INICIO = DATE(NOW()), HORA_INICIO = TIME(NOW())
	                WHERE TARJETA = $_SESSION[idTarjetaVigente]
	                AND USUARIO_RESPONSABLE = $_SESSION[idUsuario]";
	                //echo $sql; die();
	        if($record=$this->insertEasyTasks($sql)){
	        	$sql2 = "UPDATE TARJETA SET ESTADO_TARJETA = 2 WHERE ID_TARJETA = $_SESSION[idTarjetaVigente]";
	        	if($record=$this->insertEasyTasks($sql2)){
		            return 1;
	        	} else {
	        		echo "<script>alert('Error al cambiar estado de tarjeta asignada');</script>";
	            	echo "<script>window.history.back();</script>";
	        	}		            
	        } else {
	            echo "<script>alert('Error al dar inicio a tarjeta asignada');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function validaRazonImpedimento($datos){
    	try {
    		$sql= " UPDATE TARJETA_USUARIO 
	                SET RAZON_ESTADO_IMPEDIDO = $datos[cboRazonImpedimento], 
	                FECHA_IMPEDIDO = DATE(NOW()), 
	                HORA_IMPEDIDO = TIME(NOW()),
	                DURACION_TOTAL = 					
						SEC_TO_TIME(
							TIMESTAMPDIFF(
								SECOND,
								CONCAT(FECHA_INICIO,' ',HORA_INICIO),
								NOW()
							)
						)
	                WHERE TARJETA = $_SESSION[idTarjetaVigente]
	                AND USUARIO_RESPONSABLE = $_SESSION[idUsuario]";
	                //echo $sql; die();
	        if($record=$this->insertEasyTasks($sql)){
	        	$sql2 = "UPDATE TARJETA SET ESTADO_TARJETA = 4 WHERE ID_TARJETA = $_SESSION[idTarjetaVigente]";
	        	if($record=$this->insertEasyTasks($sql2)){
	        		$_SESSION['tarjetaVigente'] = 0;
    				$_SESSION['idTarjetaVigente'] = "";
		            return 1;
	        	} else {
	        		echo "<script>alert('Error al cambiar estado de tarjeta a impedida');</script>";
	            	echo "<script>window.history.back();</script>";
	        	}		            
	        } else {
	            echo "<script>alert('Error al declarar impedida la tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }


    //FUNCIONES RELACIONADAS A ENCUESTAS Y EVALUACIÓN

    function listaPreguntas(){
    	try {
    		$sql = "SELECT
    					P.ID_PREGUNTA,
						P.PREGUNTA
					FROM
						PREGUNTA P
					WHERE
						P.EMPRESA = $_SESSION[empresa]
					AND P.ESTADO_REGISTRO = 1";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idPregunta'] = $datos['ID_PREGUNTA'];
					$arreglo[$i]['pregunta'] = $datos['PREGUNTA'];
					$i++;
				}
				$indiceLista=1;
				foreach ($arreglo as $pregunta) {
					$json = json_encode($pregunta);
					echo "<tr>";
					echo "<td>".$indiceLista."</td>";
					echo "<td>".$pregunta['pregunta']."</td>";
					echo "<td><button type='button' class='btn btn-default' onclick='editaPregunta(".$json.")'><span class='glyphicon glyphicon-edit'></span></button></td>";
					echo "<td><button type='button' class='btn btn-default' onclick='eliminaPregunta(".$pregunta['idPregunta'].")'><span class='glyphicon glyphicon-remove'></span></button></td>";
					echo "</tr>";
					$indiceLista++;
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado preguntas, si desea agregar una haga click <a href='#' data-toggle='modal' data-target='#modalAdd'>acá</a>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }
    
    function creaPregunta($datos){
    	try {
    		$sql="INSERT INTO PREGUNTA (PREGUNTA, EMPRESA, ESTADO_REGISTRO) 
	                VALUES ('$datos[txtDescripcion]', $_SESSION[empresa], 1)";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al agregar pregunta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function editaPregunta($datos){
    	try {
			$sql="	UPDATE 	PREGUNTA
    				SET 	PREGUNTA = '$datos[txtDescripcionEdit]'
					WHERE 	ID_PREGUNTA = $datos[idEdit]";
			//echo $sql; die();
			if($record=$this->insertEasyTasks($sql)){	            
	            return 1;
	        } else {
	            echo "<script>alert('Error al editar pregunta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function eliminaPregunta($datos){
    	try {
    		$sql = "UPDATE PREGUNTA
					SET ESTADO_REGISTRO = 2
					WHERE
						ID_PREGUNTA = ".$datos['idEdit'];
			//echo $sql; die();
    	if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al eliminar pregunta');</script>";
	            echo "<script>window.history.back();</script>";
	        }	
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function listaEncuestas(){					
    	try {
    		$sql = "SELECT 		E.ID_ENCUESTA, E.ANIO, E.PERIODO, E.TIPO_ENCUESTA, E.ESTADO_ENCUESTA, TE.DESCRIPCION_TIPO_ENCUESTA
					FROM 		ENCUESTA E
					INNER JOIN 	TIPO_ENCUESTA TE
					ON 			E.TIPO_ENCUESTA = TE.ID_TIPO_ENCUESTA
					WHERE 		E.EMPRESA = $_SESSION[empresa]
					AND 		E.ESTADO_REGISTRO = 1
					ORDER BY 	E.ANIO DESC";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idEncuesta'] = $datos['ID_ENCUESTA'];
					$arreglo[$i]['anio'] = substr($datos['ANIO'], 0, 4);
					$arreglo[$i]['periodo'] = $datos['PERIODO'];
					$arreglo[$i]['idTipoEncuesta'] = $datos['TIPO_ENCUESTA'];
					$arreglo[$i]['tipoEncuesta'] = $datos['DESCRIPCION_TIPO_ENCUESTA'];
					$arreglo[$i]['estadoEncuesta'] = $datos['ESTADO_ENCUESTA'];
					$i++;
				}
				foreach ($arreglo as $encuesta) {
					$json = json_encode($encuesta);
					echo "<tr>";
					echo "<td>".substr($encuesta['anio'], 0, 4)."</td>";
					echo "<td>".$encuesta['periodo']."</td>";
					echo "<td>".$encuesta['tipoEncuesta']."</td>";
					echo "<td class='text-center'><button type='button' class='btn btn-default' onclick=window.open('detalleEncuesta.php?encuesta=$encuesta[idEncuesta]','detalleEncuesta','width=1024,height=480')><span class='glyphicon glyphicon-eye-open'></span></button></td>";
					//echo "<td class='text-center'><button type='button' class='btn btn-default' onclick='asignaPregunta(".$encuesta['idEncuesta'].")'><span class='glyphicon glyphicon-plus'></span></button></td>";
					echo "<td class='text-center'><button type='button' class='btn btn-default' onclick='publicaEncuesta(".$encuesta['idEncuesta'].")'><span class='glyphicon glyphicon-share'></span></button></td>";
					if($encuesta['estadoEncuesta'] == 0){ $estadoEncuesta = "Inactiva"; } elseif($encuesta['estadoEncuesta'] == 1) { $estadoEncuesta = "Activa"; } elseif($encuesta['estadoEncuesta'] == 2) { $estadoEncuesta = "Finalizada"; }
					echo "<td>$estadoEncuesta</td>";
					echo "<td><button type='button' class='btn btn-default' onclick='editaEncuesta(".$json.")'><span class='glyphicon glyphicon-edit'></span></button></td>";
					echo "<td><button type='button' class='btn btn-default' onclick='eliminaEncuesta(".$encuesta['idEncuesta'].")'><span class='glyphicon glyphicon-remove'></span></button></td>";
					echo "</tr>";
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado encuestas, si desea agregar una haga click <a href='#' data-toggle='modal' data-target='#modalAdd'>acá</a>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }
    
    function creaEncuesta($datos){
    	try {
    		$annio = $datos['txtAnio']."-00-00";
    		$sql="INSERT INTO ENCUESTA (TIPO_ENCUESTA, PERIODO, ANIO, ESTADO_ENCUESTA, EMPRESA, ESTADO_REGISTRO) 
	                VALUES ($datos[cboTipoEncuesta], '$datos[txtPeriodo]', '$annio', 0, $_SESSION[empresa], 1)";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al agregar encuesta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function editaEncuesta($datos){
    	try {
    		$sql2 = "	SELECT 	ESTADO_ENCUESTA
    					FROM 	ENCUESTA
    					WHERE 	ID_ENCUESTA = $datos[idEdit]";
    		$record = $this->selectEasyTasks($sql2);
    		if($estEnc = mysql_fetch_assoc($record)){
				$estadoEncuesta = $estEnc["ESTADO_ENCUESTA"];
			}
			if ($estadoEncuesta == 0) {
				$annio = $datos['txtAnioEdit']."-00-00";
				$sql="	UPDATE 	ENCUESTA
	    				SET 	ANIO = '$annio', PERIODO = '$datos[txtPeriodoEdit]', TIPO_ENCUESTA = $datos[cboTipoEncuestaEdit]
						WHERE 	ID_ENCUESTA = $datos[idEdit]";
				//echo $sql; die();
				if($record=$this->insertEasyTasks($sql)){	            
		            return 1;
		        } else {
		            echo "<script>alert('Error al editar encuesta');</script>";
		            echo "<script>window.history.back();</script>";
		        }
			} else {
				echo "<script>alert('Esta encuesta no puede ser editada');</script>";
		        echo "<script>window.history.back();</script>";
	    	}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function eliminaEncuesta($datos){
    	try {
    		$sql2 = "	SELECT 	ESTADO_ENCUESTA
    					FROM 	ENCUESTA
    					WHERE 	ID_ENCUESTA = $datos[idEdit]";
    		$record = $this->selectEasyTasks($sql2);
    		if($estEnc = mysql_fetch_assoc($record)){
				$estadoEncuesta = $estEnc["ESTADO_ENCUESTA"];
			}
			if ($estadoEncuesta == 0) {
				$sql = "UPDATE ENCUESTA
						SET ESTADO_REGISTRO = 2
						WHERE
							ID_ENCUESTA = $datos[idEdit]";				
	    		if($record=$this->insertEasyTasks($sql)){
		            return 1;
		        } else {
		            echo "<script>alert('Error al eliminar encuesta');</script>";
		            echo "<script>window.history.back();</script>";
		        }
			} else {
				echo "<script>alert('Esta encuesta no puede ser eliminada');</script>";
		        echo "<script>window.history.back();</script>";
			}	    			
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function asignaPregunta($datos){
    	try {
    		$sql="INSERT INTO PREGUNTA_ENCUESTA (ENCUESTA, PREGUNTA) 
	                VALUES ($datos[idEncuesta], $datos[cboPreguntaAsignada])";
	            //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarea fue agregada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al asignar pregunta a encuesta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function borraPreguntaEncuesta($datos){
    	try {
    		$sql="	DELETE 		PE.*
    				FROM 		PREGUNTA_ENCUESTA PE
    				INNER JOIN 	ENCUESTA E
    				ON 			PE.ENCUESTA = E.ID_ENCUESTA
    				WHERE 		PE.ENCUESTA = $datos[encuesta]
    				AND 		PE.PREGUNTA = $datos[pregunta]
    				AND 		E.ESTADO_ENCUESTA = 0";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            return 1;
	        } else {
	            echo "<script>alert('Error al desvincular pregunta de esta encuesta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function verPeriodoEncuesta($idEncuesta){
    	try {
    		$sql="	SELECT 		E.PERIODO, E.ANIO, EMPRESA.DESCRIPCION_EMPRESA
					FROM 		ENCUESTA E
					INNER JOIN 	EMPRESA
					ON 			E.EMPRESA = EMPRESA.ID_EMPRESA
					WHERE 		E.ID_ENCUESTA = $idEncuesta";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
				if($datos = mysql_fetch_assoc($record)) {
					$arreglo['periodo'] = $datos['PERIODO'];
					$arreglo['anio'] = $datos['ANIO'];
					$arreglo['empresa'] = $datos['DESCRIPCION_EMPRESA'];
				}
				return $arreglo;
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function verPreguntasEncuesta($idEncuesta,$tipo){
    	try {
    		$sql="	SELECT 		PE.PREGUNTA AS ID_PREGUNTA, P.PREGUNTA
					FROM 		PREGUNTA_ENCUESTA PE
					INNER JOIN 	PREGUNTA P
					ON 			PE.PREGUNTA = P.ID_PREGUNTA
					WHERE 		PE.ENCUESTA = $idEncuesta";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idEncuesta'] = $idEncuesta;
					$arreglo[$i]['idPregunta'] = $datos['ID_PREGUNTA'];
					$arreglo[$i]['pregunta'] = $datos['PREGUNTA'];
					$i++;
				}
				$valorIndice = 1;
				foreach ($arreglo as $pregunta) {
					$json = json_encode($pregunta);
					echo "<div>$valorIndice - $pregunta[pregunta]: ";
					if ($tipo == 1) { //Si $tipo = 1, la función es llamada desde 'detalleEncuesta.php', por lo que debe mostrar el icono para borrar pregunta, si $tipo = 2, la función es llamada desde 'encuesta.php', por lo que no se debe mostrar el icono de eliminar. 
						echo "<a href='#' onclick='borraPreguntaEncuesta($json)' style='color:black;'><span class='glyphicon glyphicon-trash'></span></a></div>";
					}
					echo "<div class='radio'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<label class='radio-inline'><input type='radio' id='respuesta$valorIndice' name='respuesta$valorIndice' value='1' checked='true'>1 &nbsp;</label>";
					echo "<label class='radio-inline'><input type='radio' id='respuesta$valorIndice' name='respuesta$valorIndice' value='2'>2 &nbsp;</label>";
					echo "<label class='radio-inline'><input type='radio' id='respuesta$valorIndice' name='respuesta$valorIndice' value='3'>3 &nbsp;</label>";
					echo "<label class='radio-inline'><input type='radio' id='respuesta$valorIndice' name='respuesta$valorIndice' value='4'>4 &nbsp;</label>";
					echo "<label class='radio-inline'><input type='radio' id='respuesta$valorIndice' name='respuesta$valorIndice' value='5'>5 &nbsp;</label>";
					echo "</div>";
					$valorIndice++;
				}
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function publicaEncuesta($idEncuesta){
    	try {
    		$sqlDatosEncuesta = "	SELECT 	TIPO_ENCUESTA, ESTADO_ENCUESTA
    								FROM 	ENCUESTA 
    								WHERE 	ID_ENCUESTA = $idEncuesta";
    		if ($record = $this->selectEasyTasks($sqlDatosEncuesta)){ //RESCATA DATOS PARA FILTRAR SI SE PUBLICA Y DE QUE FORMA LA ENCUESTA SELECCIONADA
    			if($datos = mysql_fetch_assoc($record)){
    				$tipoEncuesta = $datos["TIPO_ENCUESTA"];
    				$estadoEncuesta = $datos["ESTADO_ENCUESTA"];
    			}
    			$sql = "SELECT 	ID_USUARIO
						FROM 	USUARIO
						WHERE 	EMPRESA = $_SESSION[empresa]
						AND 	PERFIL = 3
						AND 	ESTADO_REGISTRO = 1";
	    		if($record = $this->selectEasyTasks($sql)){
					$i=0;
					while($datos = mysql_fetch_assoc($record)){
						$arreglo[$i] = $datos['ID_USUARIO'];
						$i++;
					}
					foreach ($arreglo as $usuario){
    					if ($tipoEncuesta == 1 && $estadoEncuesta == 0){ //SI EL TIPO DE ENCUESTA ES AUTOEVALUACIÓN Y ESTÁ EN ESTADO INACTIVO (NO PUBLICADO NI FINALIZADO)
    						$sql4 = "	SELECT 	ID_EVALUACION_COORDINADOR
    									FROM 	USUARIO_ENCUESTA 
    									WHERE 	ID_AUTOEVALUACION IS NULL
    									AND 	USUARIO = $usuario";
    						if($record = $this->selectEasyTasks($sql4)){
    							if ($id = mysql_fetch_assoc($record)) {
    								$idEvalCoord = $id["ID_EVALUACION_COORDINADOR"];
    							}
    							$sql2 = "	UPDATE USUARIO_ENCUESTA SET ID_AUTOEVALUACION = $idEncuesta
    										WHERE USUARIO = $usuario AND ID_EVALUACION_COORDINADOR = $idEvalCoord";
    						} else {
    							$sql2 = "	INSERT INTO USUARIO_ENCUESTA (USUARIO, ID_AUTOEVALUACION)
											VALUES ($usuario, $idEncuesta)";
    						}
    					} elseif ($tipoEncuesta == 2 && $estadoEncuesta == 0) { //SI EL TIPO DE ENCUESTA ES EVALUACIÓN COORDINADOR Y ESTÁ EN ESTADO INACTIVO (NO PUBLICADO NI FINALIZADO)
    						$sql4 = "	SELECT 	ID_AUTOEVALUACION
    									FROM 	USUARIO_ENCUESTA 
    									WHERE 	ID_EVALUACION_COORDINADOR IS NULL
    									AND 	USUARIO = $usuario";
    						if($record = $this->selectEasyTasks($sql4)){
    							if ($id = mysql_fetch_assoc($record)) {
    								$idAutoEval = $id["ID_AUTOEVALUACION"];
    							}
    							$sql2 = "	UPDATE USUARIO_ENCUESTA SET ID_EVALUACION_COORDINADOR = $idEncuesta
    										WHERE USUARIO = $usuario AND ID_AUTOEVALUACION = $idAutoEval";
    						} else {
    							$sql2 = "	INSERT INTO USUARIO_ENCUESTA (USUARIO, ID_EVALUACION_COORDINADOR)
											VALUES ($usuario, $idEncuesta)";
    						}
    					} elseif ($estadoEncuesta != 0) {
    						echo "<script>alert('Esta encuesta no est\u00E1 disponible para su publicaci\u00F3n');</script>";
        					echo "<script>window.location='../listaEncuesta.php';</script>";
    					} else {
    						echo "<script>alert('Esta encuesta no ha podidio ser publicada');</script>";
        					echo "<script>window.location='../listaEncuesta.php';</script>";
    					}
						if($record=$this->insertEasyTasks($sql2)){ $flag=1; } else { $flag=0; }
					}
					if($flag == 1){
						$sql3 = "	UPDATE ENCUESTA
									SET ESTADO_ENCUESTA = 1
									WHERE ID_ENCUESTA = $idEncuesta";
						if ($record=$this->insertEasyTasks($sql3)) {
							return 1;
						} else {
							echo "<script>alert('Error al actualizar el estado de encuesta');</script>";
	            			echo "<script>window.location='../listaEncuesta.php';</script>";
						}
					} else {
						echo "<script>alert('Error al asignar usuarios a encuesta');</script>";
	            		echo "<script>window.location='../listaEncuesta.php';</script>";
					}
				} else {
					echo "<script>alert('Error al seleccionar usuarios a asignar en encuesta');</script>";
		            echo "<script>window.location='../listaEncuesta.php';</script>";
				}
    		} else {
    			echo "<script>alert('Error al buscar tipo y estado de encuesta');</script>";
    			echo "<script>window.location='../listaEncuesta.php';</script>";
    		}  				
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function validaExistenciaEncuesta(){					
    	try {
    		$sql="	SELECT 	UE.ID_AUTOEVALUACION
					FROM 	USUARIO_ENCUESTA UE
					WHERE 	UE.USUARIO = $_SESSION[idUsuario]
					AND 	UE.PUNTAJE_USUARIO IS NULL";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
				if ($datos = mysql_fetch_assoc($record)) {
					$idEncuesta = $datos['ID_AUTOEVALUACION'];
				}
				return $idEncuesta;
			} else {
				return 0;
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function guardaResultadoEncuesta($respuestas){
    	try {
			$sql="	SELECT 	PUNTAJE_USUARIO, PUNTAJE_COORDINADOR
					FROM 	USUARIO_ENCUESTA
					WHERE 	USUARIO = $_SESSION[idUsuario]
					AND 	ID_AUTOEVALUACION = $_SESSION[idEncuesta]";
					//echo "$sql";
			if($record = $this->selectEasyTasks($sql)){
				if ($datos = mysql_fetch_assoc($record)) {
					$puntajeUsuario = $datos['PUNTAJE_USUARIO'];
					$puntajeCoordinador = $datos['PUNTAJE_COORDINADOR'];
				} else {
					$puntajeUsuario = 0;
					$puntajeCoordinador = 0;
				}
				//Acá se calcula el promedio de las respuestas.
				$sumaRespuesta = 0;
				$cantidadRespuesta = 0;
				for ($i=1; $i<count($respuestas); $i++) {
					$sumaRespuesta += $respuestas["respuesta$i"];
					$cantidadRespuesta += 1;
					#echo $respuestas["respuesta$i"]."<br>";
				}
				$promedio = $sumaRespuesta/$cantidadRespuesta;
				#echo $sumaRespuesta."/$cantidadRespuesta<br>$promedio";die();
				//Fin de cálculo de promedio.
				if($puntajeCoordinador != 0){
					$puntajePromedio = ($promedio+$puntajeCoordinador)/2;
					$insertSql2 = "UPDATE USUARIO_ENCUESTA SET PUNTAJE_USUARIO = $promedio, PUNTAJE_PROMEDIO = $puntajePromedio";
					#echo "$puntajePromedio";die();
				} elseif($puntajeCoordinador == 0){
					$insertSql2 = "UPDATE USUARIO_ENCUESTA SET PUNTAJE_USUARIO = $promedio";
				}
				$sql2 = $insertSql2." WHERE USUARIO = $_SESSION[idUsuario] AND ID_AUTOEVALUACION = $_SESSION[idEncuesta]";
		        #echo "$sql2";die();
		        if($record=$this->insertEasyTasks($sql2)){
		        	$_SESSION['idEncuesta'] = 0;
		        	echo "<script>alert('Su evaluaci\u00F3n fue enviada satisfactoriamente');</script>";
		        	echo "<script>window.opener.document.location.reload();</script>";
		            echo "<script>window.close();</script>";
		        } else {
		            echo "<script>alert('Error al enviar los datos de su evaluaci\u00F3n');</script>";
		            echo "<script>window.history.back();</script>";
		        }
			} else {
				echo "<script>alert('Error al rescatar datos previos de su evaluaci\u00F3n');</script>";
		        echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}    	
    }

    function guardaResultadoEncuestaCoordinador($respuestas){
    	try {
			$sql="	SELECT 	PUNTAJE_USUARIO, PUNTAJE_COORDINADOR
					FROM 	USUARIO_ENCUESTA
					WHERE 	USUARIO = $respuestas[usuario]
					AND 	ID_EVALUACION_COORDINADOR = $respuestas[encuesta]";
					#echo "$sql";die();
			if($record = $this->selectEasyTasks($sql)){
				if ($datos = mysql_fetch_assoc($record)) {
					$puntajeUsuario = $datos['PUNTAJE_USUARIO'];
					$puntajeCoordinador = $datos['PUNTAJE_COORDINADOR'];
				} else {
					$puntajeUsuario = 0;
					$puntajeCoordinador = 0;
				}
				//Acá se calcula el promedio de las respuestas.
				$sumaRespuesta = 0;
				$cantidadRespuesta = 0;
				for ($i=1; $i<count($respuestas)-3; $i++) {
					$sumaRespuesta += $respuestas["respuesta$i"];
					$cantidadRespuesta += 1;
					#echo $respuestas["respuesta$i"]."<br>";
				}
				$promedio = $sumaRespuesta/$cantidadRespuesta;
				#echo $sumaRespuesta."/$cantidadRespuesta<br>$promedio";die();
				//Fin de cálculo de promedio.
				if($puntajeUsuario != 0){
					$puntajePromedio = ($promedio+$puntajeUsuario)/2;
					$insertSql2 = "UPDATE USUARIO_ENCUESTA SET PUNTAJE_COORDINADOR = $promedio, PUNTAJE_PROMEDIO = $puntajePromedio";
					#echo "$puntajePromedio";die();
				} elseif($puntajeUsuario == 0){
					$insertSql2 = "UPDATE USUARIO_ENCUESTA SET PUNTAJE_COORDINADOR = $promedio";
				}
				$sql2 = $insertSql2." WHERE USUARIO = $respuestas[usuario] AND ID_EVALUACION_COORDINADOR = $respuestas[encuesta]";
		        #echo "$sql2";die();
		        if($record=$this->insertEasyTasks($sql2)){
		        	echo "<script>alert('Su evaluaci\u00F3n fue enviada satisfactoriamente');</script>";
		        	echo "<script>window.opener.document.location.reload();</script>";
		            echo "<script>window.close();</script>";
		        } else {
		            echo "<script>alert('Error al enviar los datos de su evaluaci\u00F3n');</script>";
		            echo "<script>window.history.back();</script>";
		        }
			} else {
				echo "<script>alert('Error al rescatar datos previos de su evaluaci\u00F3n');</script>";
		        echo "<script>window.history.back();</script>";
			}   
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}    	
    }

    function listaEvaluacion(){					
    	try {
    		$sql = "SELECT 		E.ID_ENCUESTA, E.ANIO, E.PERIODO, E.ESTADO_ENCUESTA
					FROM 		ENCUESTA E
					WHERE 		E.EMPRESA = $_SESSION[empresa]
					AND 		TIPO_ENCUESTA = 2
					AND 		E.ESTADO_REGISTRO = 1
					ORDER BY 	E.ANIO DESC";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idEncuesta'] = $datos['ID_ENCUESTA'];
					$arreglo[$i]['anio'] = substr($datos['ANIO'], 0, 4);
					$arreglo[$i]['periodo'] = $datos['PERIODO'];
					$arreglo[$i]['estadoEncuesta'] = $datos['ESTADO_ENCUESTA'];
					$i++;
				}
				foreach ($arreglo as $encuesta) {
					$json = json_encode($encuesta);
					echo "<tr>";
					echo "<td>".substr($encuesta['anio'], 0, 4)."</td>";
					echo "<td>".$encuesta['periodo']."</td>";
					echo "<td class='text-center'><a class='btn btn-default' href='detalleListaEncuesta.php?encuesta=$encuesta[idEncuesta]' role='button'><span class='glyphicon glyphicon-eye-open'></span></a></td>";
					if($encuesta['estadoEncuesta'] == 0){ $estadoEncuesta = "Inactiva"; } elseif($encuesta['estadoEncuesta'] == 1) { $estadoEncuesta = "Activa"; } elseif($encuesta['estadoEncuesta'] == 2) { $estadoEncuesta = "Finalizada"; }
					echo "<td>$estadoEncuesta</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado encuestas, si desea agregar una haga click <a href='listaEncuesta.php'>acá</a>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function listaEvaluacionPorPeriodo($idEncuesta){
    	try {
    		$sql = "SELECT 		UE.USUARIO, U.NOMBRES, U.APELLIDOS, UE.PUNTAJE_USUARIO, UE.PUNTAJE_COORDINADOR, UE.PUNTAJE_PROMEDIO, UE.PUNTAJE_REAL
					FROM 		USUARIO_ENCUESTA UE
					INNER JOIN 	USUARIO U
					ON 			UE.USUARIO = U.ID_USUARIO
					WHERE 		ID_EVALUACION_COORDINADOR = $idEncuesta";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['idUsuario'] = $datos['USUARIO'];
					$arreglo[$i]['nombres'] = $datos['NOMBRES'];
					$arreglo[$i]['apellidos'] = $datos['APELLIDOS'];
					$arreglo[$i]['puntajeUsuario'] = $datos['PUNTAJE_USUARIO'];
					$arreglo[$i]['puntajeCoordinador'] = $datos['PUNTAJE_COORDINADOR'];
					$arreglo[$i]['puntajePromedio'] = $datos['PUNTAJE_PROMEDIO'];
					$arreglo[$i]['puntajeReal'] = $datos['PUNTAJE_REAL'];
					$i++;
				}
				foreach ($arreglo as $encuesta) {
					
					
					
					
					#$json = json_encode($encuesta);
					echo "<tr>";
					echo "<td>".$encuesta['nombres']." ".$encuesta['apellidos']."</td>";
					echo "<td class='text-center'><button type='button' class='btn btn-default' onclick=window.open('encuestaCoordinador.php?encuesta=$idEncuesta&nom=$encuesta[nombres]&ape=$encuesta[apellidos]&usr=$encuesta[idUsuario]','encuesta','width=1024,height=480')><span class='glyphicon glyphicon-pencil'></span></button></td>";
					echo "<td class='text-center'>";if(!($encuesta['puntajeUsuario'])){ echo "Sin evaluar"; } else { echo round($encuesta['puntajeUsuario'],1); } echo "</td>";
					echo "<td class='text-center'>";if(!($encuesta['puntajeCoordinador'])){ echo "Sin evaluar"; } else { echo round($encuesta['puntajeCoordinador'],1); } echo "</td>";
					echo "<td class='text-center'>";if(!($encuesta['puntajePromedio'])){ echo "--"; } else { echo round($encuesta['puntajePromedio'],1); } echo "</td>";
					echo "<td class='text-center'>";if(!($encuesta['puntajeReal'])){ echo "--"; } else { echo round($encuesta['puntajeReal'],1); } echo "</td>";
					echo "<td class='text-center'><button type='button' class='btn btn-default' onclick='alert($)')><span class='glyphicon glyphicon-pencil'></span></button></td>";
					echo "</tr>";
				}
			} else {
				echo "<tr class='text-center'><td colspan='8'><h4>Aún no se han agregado encuestas, si desea agregar una haga click <a href='listaEncuesta.php'>acá</a>.</h4></td></tr>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
			    	
    }


    //FUNCIONES RELACIONADAS A ENCUESTAS Y EVALUACIÓN

    function nombreUsuario($usuario){
    	try {					
    		$sql = "SELECT 		CONCAT(U.NOMBRES, ' ', U.APELLIDOS) AS NOMBRE, E.DESCRIPCION_EMPRESA, U.EMAIL
					FROM 		USUARIO U
					INNER JOIN 	EMPRESA E
					ON 			U.EMPRESA = E.ID_EMPRESA
					WHERE 		ID_USUARIO = $usuario";
			if($record = $this->selectEasyTasks($sql)){
				if($datos = mysql_fetch_assoc($record)) {
					$arreglo['nombre'] = $datos['NOMBRE'];
					$arreglo['empresa'] = $datos['DESCRIPCION_EMPRESA'];
					$arreglo['email'] = $datos['EMAIL'];
				}				
				return $arreglo;
			} else {
				echo "<script>alert('Usuario no encontrado');</script>";
		        echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function datosUltimaEncuesta($usuario){			    	
		try {					
    		$sql = "SELECT 		SUBSTR(E.ANIO,1,4) AS ANIO, E.PERIODO, UE.PUNTAJE_USUARIO, UE.PUNTAJE_COORDINADOR, UE.PUNTAJE_PROMEDIO, UE.PUNTAJE_REAL
					FROM 		USUARIO_ENCUESTA UE
					INNER JOIN 	ENCUESTA E
					ON 			E.ID_ENCUESTA = UE.ID_AUTOEVALUACION
					WHERE 		UE.USUARIO = $usuario
					AND 		UE.ID_AUTOEVALUACION = (
								SELECT 	MAX(ID_ENCUESTA) 
								FROM 	ENCUESTA 
								WHERE 	TIPO_ENCUESTA =1 
								AND 	ESTADO_ENCUESTA = 1 
								AND 	EMPRESA = $_SESSION[empresa] 
								AND 	ESTADO_REGISTRO = 1 
								AND 	ANIO = (
										SELECT 	MAX(ANIO) 
										FROM 	ENCUESTA 
										WHERE 	TIPO_ENCUESTA = 1 
										AND 	ESTADO_ENCUESTA = 1 
										AND 	EMPRESA = $_SESSION[empresa] 
										AND 	ESTADO_REGISTRO = 1))";
			if($record = $this->selectEasyTasks($sql)){
				if($datos = mysql_fetch_assoc($record)) {
					$arreglo['anio'] = $datos['ANIO'];
					$arreglo['periodo'] = $datos['PERIODO'];
					if(!($datos['PUNTAJE_USUARIO'])){$arreglo['puntajeUsuario']="N/A";} else {$arreglo['puntajeUsuario'] = round($datos['PUNTAJE_USUARIO'],1);}
					if(!($datos['PUNTAJE_COORDINADOR'])){$arreglo['puntajeCoordinador']="N/A";} else {$arreglo['puntajeCoordinador'] = round($datos['PUNTAJE_COORDINADOR'],1);}
					if(!($datos['PUNTAJE_PROMEDIO'])){$arreglo['puntajePromedio']="N/A";} else {$arreglo['puntajePromedio'] = round($datos['PUNTAJE_PROMEDIO'],1);}
					if(!($datos['PUNTAJE_REAL'])){$arreglo['puntajeReal']="N/A";} else {$arreglo['puntajeReal'] = round($datos['PUNTAJE_REAL'],1);}
				}
				return $arreglo;
			} else {
				echo "<script>alert('Usuario no registra evaluaciones');</script>";
		        echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }
    
    function dashboardUserFinalizacionTarjetas($usuario, $desde, $hasta){
    	try {					
    		$sql = "SELECT 		COUNT(T.ID_TARJETA) AS CANTIDAD, ET.DESCRIPCION_ESTADO_TAJETA
					FROM 		TARJETA T
					INNER JOIN 	ESTADO_TARJETA ET
					ON 			T.ESTADO_TARJETA = ET.ID_ESTADO_TARJETA
					INNER JOIN 	TARJETA_USUARIO TU
					ON 			T.ID_TARJETA = TU.TARJETA
					WHERE 		TU.USUARIO_RESPONSABLE = $usuario
					AND 		TU.FECHA_INICIO BETWEEN '$desde' AND '$hasta'
					GROUP BY 	T.ESTADO_TARJETA";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				$arregloGrafico = "";
				foreach ($arreglo as $dato) {
					$cantidad = round(($dato['cantidad']/$totalCantidad)*100, 2);
					$arregloGrafico .= "['$dato[estado]S ($dato[cantidad])',$cantidad],";
				}
				$arregloGrafico = trim($arregloGrafico, ',');
				echo $arregloGrafico;
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function dashboardUserDetalleImpedidas($usuario, $desde, $hasta){					
    	try {					
    		$sql = "SELECT 		COUNT(TU.RAZON_ESTADO_IMPEDIDO) AS CANTIDAD, RI.DESCRIPCION_RAZON
					FROM 		TARJETA_USUARIO TU
					INNER JOIN 	RAZON_IMPEDIMENTO RI
					ON 			TU.RAZON_ESTADO_IMPEDIDO = RI.ID_RAZON
					INNER JOIN 	TARJETA T
					ON 			TU.TARJETA = T.ID_TARJETA
					WHERE 		TU.USUARIO_RESPONSABLE = $usuario
					AND 		TU.FECHA_INICIO BETWEEN '$desde' AND '$hasta'
					GROUP BY 	RI.ID_RAZON";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_RAZON'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				$arregloGrafico = "";
				foreach ($arreglo as $dato) {
					$cantidad = round(($dato['cantidad']/$totalCantidad)*100, 2);
					$arregloGrafico .= "['$dato[estado] ($dato[cantidad])',$cantidad],";
				}
				$arregloGrafico = trim($arregloGrafico, ',');
				echo $arregloGrafico;
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function dashboardUserTiemposCumplimiento($usuario, $desde, $hasta){					
    	try {					
    		$sql = "SELECT 		COUNT(TJ.ID_TARJETA) AS CANTIDAD, IF(TIMEDIFF(T.TIEMPO_ESTIMADO_TAREA,TU.DURACION_TOTAL) >= '00:00:00','DENTRO DEL TIEMPO','FUERA DE TIEMPO') AS ESTADO_TIEMPO
					FROM 		TARJETA TJ
					INNER JOIN 	TARJETA_USUARIO TU
					ON 			TJ.ID_TARJETA = TU.TARJETA
					INNER JOIN 	TAREA T
					ON 			T.ID_TAREA = TJ.TAREA
					WHERE 		TU.USUARIO_RESPONSABLE = $usuario
					AND 		TU.FECHA_INICIO BETWEEN '$desde' AND '$hasta'
					AND 		TJ.ESTADO_TARJETA = 3
					GROUP BY 	ESTADO_TIEMPO";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['estado'] = $datos['ESTADO_TIEMPO'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				$arregloGrafico = "";
				foreach ($arreglo as $dato) {
					$cantidad = round(($dato['cantidad']/$totalCantidad)*100, 2);
					$arregloGrafico .= "['$dato[estado] ($dato[cantidad])',$cantidad],";
				}
				$arregloGrafico = trim($arregloGrafico, ',');
				echo $arregloGrafico;
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function rankingTareasSolicitadas($desde, $hasta){
    	try {					
    		$sql = "SELECT 		COUNT(TJ.TAREA) AS CANTIDAD, CONCAT(S.DESCRIPCION_SISTEMA,'-',T.DESCRIPCION_TAREA) AS TAREA
					FROM 		TARJETA TJ
					INNER JOIN 	TAREA T
					ON 			TJ.TAREA = T.ID_TAREA
					INNER JOIN 	SISTEMA S
					ON 			T.SISTEMA = S.ID_SISTEMA
					WHERE 		S.EMPRESA = $_SESSION[empresa]
					AND 		TJ.FECHA_SOLICITUD BETWEEN '$desde' AND '$hasta'
					GROUP BY 	T.ID_TAREA
					ORDER BY 	CANTIDAD DESC
					LIMIT 		5";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['tarea'] = $datos['TAREA'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				return $arreglo;
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        #echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function graficoRankingTareasSolicitadas($desde, $hasta){
    	try {					
    		$sql = "SELECT 		COUNT(TJ.TAREA) AS CANTIDAD, CONCAT(S.DESCRIPCION_SISTEMA,'-',T.DESCRIPCION_TAREA) AS TAREA
					FROM 		TARJETA TJ
					INNER JOIN 	TAREA T
					ON 			TJ.TAREA = T.ID_TAREA
					INNER JOIN 	SISTEMA S
					ON 			T.SISTEMA = S.ID_SISTEMA
					WHERE 		S.EMPRESA = $_SESSION[empresa]
					AND 		TJ.FECHA_SOLICITUD BETWEEN '$desde' AND '$hasta'
					GROUP BY 	T.ID_TAREA
					ORDER BY 	CANTIDAD DESC
					LIMIT 		5";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['tarea'] = $datos['TAREA'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				$arregloGrafico = "";
				foreach ($arreglo as $dato) {
					$cantidad = round(($dato['cantidad']/$totalCantidad)*100, 2);
					$arregloGrafico .= "{name: '$dato[tarea] ($dato[cantidad])', y: $cantidad, drilldown: '$dato[tarea] ($dato[cantidad])'},";
				}
				$arregloGrafico = trim($arregloGrafico, ',');
				echo $arregloGrafico;
				#var_dump($arreglo); die();
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        #echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function rankingTareasRealizadas($desde, $hasta){
    	try {					
    		$sql = "SELECT 		COUNT(TJ.TAREA) AS CANTIDAD, CONCAT(S.DESCRIPCION_SISTEMA,'-',T.DESCRIPCION_TAREA) AS TAREA
					FROM 		TARJETA TJ
					INNER JOIN 	TAREA T
					ON 			TJ.TAREA = T.ID_TAREA
					INNER JOIN 	SISTEMA S
					ON 			T.SISTEMA = S.ID_SISTEMA
					WHERE 		S.EMPRESA = $_SESSION[empresa]
					AND 		TJ.ESTADO_TARJETA = 3
					AND 		TJ.FECHA_SOLICITUD BETWEEN '$desde' AND '$hasta'
					GROUP BY 	T.ID_TAREA
					ORDER BY 	CANTIDAD DESC
					LIMIT 		5";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['tarea'] = $datos['TAREA'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				return $arreglo;
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        #echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function graficoRankingTareasRealizadas($desde, $hasta){
    	try {					
    		$sql = "SELECT 		COUNT(TJ.TAREA) AS CANTIDAD, CONCAT(S.DESCRIPCION_SISTEMA,'-',T.DESCRIPCION_TAREA) AS TAREA
					FROM 		TARJETA TJ
					INNER JOIN 	TAREA T
					ON 			TJ.TAREA = T.ID_TAREA
					INNER JOIN 	SISTEMA S
					ON 			T.SISTEMA = S.ID_SISTEMA
					WHERE 		S.EMPRESA = $_SESSION[empresa]
					AND 		TJ.ESTADO_TARJETA = 3
					AND 		TJ.FECHA_SOLICITUD BETWEEN '$desde' AND '$hasta'
					GROUP BY 	T.ID_TAREA
					ORDER BY 	CANTIDAD DESC
					LIMIT 		5";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['tarea'] = $datos['TAREA'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				$arregloGrafico = "";
				foreach ($arreglo as $dato) {
					$cantidad = round(($dato['cantidad']/$totalCantidad)*100, 2);
					$arregloGrafico .= "{name: '$dato[tarea] ($dato[cantidad])', y: $cantidad, drilldown: '$dato[tarea] ($dato[cantidad])'},";
				}
				$arregloGrafico = trim($arregloGrafico, ',');
				echo $arregloGrafico;
				#var_dump($arreglo); die();
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        #echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function rankingTareasImpedidas($desde, $hasta){
    	try {					
    		$sql = "SELECT 		COUNT(TJ.TAREA) AS CANTIDAD, CONCAT(S.DESCRIPCION_SISTEMA,'-',T.DESCRIPCION_TAREA) AS TAREA
					FROM 		TARJETA TJ
					INNER JOIN 	TAREA T
					ON 			TJ.TAREA = T.ID_TAREA
					INNER JOIN 	SISTEMA S
					ON 			T.SISTEMA = S.ID_SISTEMA
					WHERE 		S.EMPRESA = $_SESSION[empresa]
					AND 		TJ.ESTADO_TARJETA = 4
					AND 		TJ.FECHA_SOLICITUD BETWEEN '$desde' AND '$hasta'
					GROUP BY 	T.ID_TAREA
					ORDER BY 	CANTIDAD DESC
					LIMIT 		5";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['tarea'] = $datos['TAREA'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				return $arreglo;
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        #echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

    function graficoRankingTareasImpedidas($desde, $hasta){
    	try {					
    		$sql = "SELECT 		COUNT(TJ.TAREA) AS CANTIDAD, CONCAT(S.DESCRIPCION_SISTEMA,'-',T.DESCRIPCION_TAREA) AS TAREA
					FROM 		TARJETA TJ
					INNER JOIN 	TAREA T
					ON 			TJ.TAREA = T.ID_TAREA
					INNER JOIN 	SISTEMA S
					ON 			T.SISTEMA = S.ID_SISTEMA
					WHERE 		S.EMPRESA = $_SESSION[empresa]
					AND 		TJ.ESTADO_TARJETA = 4
					AND 		TJ.FECHA_SOLICITUD BETWEEN '$desde' AND '$hasta'
					GROUP BY 	T.ID_TAREA
					ORDER BY 	CANTIDAD DESC
					LIMIT 		5";
					//echo $sql; die();
			if($record = $this->selectEasyTasks($sql)){
				$i=0;
				$totalCantidad = 0;
				while ($datos = mysql_fetch_assoc($record)) {
					$arreglo[$i]['cantidad'] = $datos['CANTIDAD'];
					$arreglo[$i]['tarea'] = $datos['TAREA'];
					$totalCantidad += $datos['CANTIDAD'];
					$i++;
				}
				$arregloGrafico = "";
				foreach ($arreglo as $dato) {
					$cantidad = round(($dato['cantidad']/$totalCantidad)*100, 2);
					$arregloGrafico .= "{name: '$dato[tarea] ($dato[cantidad])', y: $cantidad, drilldown: '$dato[tarea] ($dato[cantidad])'},";
				}
				$arregloGrafico = trim($arregloGrafico, ',');
				echo $arregloGrafico;
				#var_dump($arreglo); die();
			} else {
				echo "<script>alert('Datos no encontrados');</script>";
		        #echo "<script>window.history.back();</script>";
			}
    	} catch (Exception $e) {
    		echo "<script>alert('".$e->getMessage()."');</script>";
    	}
    }

}
?>