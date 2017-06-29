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
    		$sql="	SELECT 		U.ID_USUARIO, U.NOMBRES, U.APELLIDOS, U.EMPRESA, U.PERFIL
					FROM 		USUARIO U
					WHERE 		U.USERNAME = '".$datos['txtUsuario']."' 
					AND 		U.PASSWORD = '".$datos['txtPassword']."'
					AND 		U.ESTADO_REGISTRO = 1";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
				while($datos = mysql_fetch_assoc($record)){
					$arreglo['idUsuario'] = $datos['ID_USUARIO'];
					$arreglo['nombreUsuario'] = $datos['NOMBRES']." ".$datos['APELLIDOS'];			
					$arreglo['empresa'] = $datos['EMPRESA'];
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
				WHERE U.ID_USUARIO NOT IN (SELECT TU.USUARIO_RESPONSABLE FROM TARJETA_USUARIO TU WHERE TU.FECHA_TERMINO = '0000-00-00')
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

    function creaTarjeta($datos){
    	try {
    		if ($_SESSION['perfil'] == 3) {
    			$sql="INSERT INTO TARJETA (TAREA, CLIENTE_SOLICITANTE, FECHA_SOLICITUD, PRIORIDAD, OBSERVACIONES, ADJUNTO, ESTADO_TARJETA, ESTADO_REGISTRO) 
	                	VALUES ($datos[cboTarea], $datos[txtSolicitante], NOW(), 1, '$datos[txtObservaciones]', '$datos[fileAdjunto]', 2, 1)";
	            if($record=$this->insertEasyTasks($sql)){
	            	$ultimaTarjeta = $this->selectId();
	            	$sql2="INSERT INTO TARJETA_USUARIO (TARJETA, USUARIO_RESPONSABLE, FECHA_INICIO, HORA_INICIO)
	            	VALUES ($ultimaTarjeta, $_SESSION[idUsuario], DATE(NOW()), TIME(NOW()))";
	            	if($record=$this->insertEasyTasks($sql2)){
	            		return 1;
	            	} else {
	            		echo "<script>alert('Error al autoasignar tarjeta');</script>";
	            		echo "<script>window.history.back();</script>";
	            	}
	            } else {
	            	echo "<script>alert('Error al crear tarjeta');</script>";
	            	echo "<script>window.history.back();</script>";
	            }
    		} elseif ($_SESSION['perfil'] != 1) {//CAMBIAR POR $_SESSION['perfil'] == 2
    			$sql="INSERT INTO TARJETA (TAREA, CLIENTE_SOLICITANTE, FECHA_SOLICITUD, PRIORIDAD, OBSERVACIONES, ADJUNTO, ESTADO_TARJETA, ESTADO_REGISTRO) 
		                VALUES ($datos[cboTarea], $datos[txtSolicitante], NOW(), 1, '$datos[txtObservaciones]', '$datos[fileAdjunto]', 1, 1)";
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
					echo "<tr><td style='background-color: #FFFF00'>";
					echo "<a style='color: black;' href='#' onclick='detalleTarjeta(".$tarjetaJson.")'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</a><br>";
					if ($_SESSION['perfil'] != 3) {
						//echo "<button type='button' class='btn btn-default' onclick='editaTarjeta($tarjetaJson);'><span class='glyphicon glyphicon-edit'></span></button>";
						//echo "<a href='#' style='color: black' class='glyphicon glyphicon-edit' onclick='editaTarjeta($tarjetaJson);'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<a href='#' title='Editar tarjeta' style='color: black' class='material-icons' onclick='editaTarjeta($tarjetaJson);'>&#xe254;</a>&nbsp;&nbsp;";
						echo "<a href='#' title='Asignar usuario' style='color: black' class='material-icons' onclick='muestraAsignarTarjeta($tarjeta[idTarjeta]);'>&#xe7f0;</i>";
					}					
					echo "</td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #FFFF00'>";
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
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//var_dump($arreglo); die();
				foreach ($arreglo as $tarjeta) {
					echo "<tr><td style='background-color: #0000FF'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #0000FF'>";
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
					AND TJ.ESTADO_TARJETA = 3
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
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//var_dump($arreglo); die();
				foreach ($arreglo as $tarjeta) {
					echo "<tr><td style='background-color: #00FF00'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #00FF00'>";
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
						S.DESCRIPCION_SISTEMA,
						T.DESCRIPCION_TAREA,
						C.NOMBRE_CLIENTE,
						C.CARGO_CLIENTE,
						C.AREA_CLIENTE,
						TJ.FECHA_SOLICITUD,
						P.DESCRIPCION_PRIORIDAD,
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
					$arreglo[$i]['tarea'] = $datos['DESCRIPCION_SISTEMA']." - ".$datos['DESCRIPCION_TAREA'];			
					$arreglo[$i]['solicitante'] = $datos['NOMBRE_CLIENTE']." - ".$datos['CARGO_CLIENTE']." - ".$datos['AREA_CLIENTE'];
					$arreglo[$i]['fechaSolicitud'] = $datos['FECHA_SOLICITUD'];
					$arreglo[$i]['prioridad'] = $datos['DESCRIPCION_PRIORIDAD'];
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//var_dump($arreglo); die();
				foreach ($arreglo as $tarjeta) {
					echo "<tr><td style='background-color: #FF0000'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #FF0000'>";
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
					AND U.ESTADO_REGISTRO = 1";
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


}
?>