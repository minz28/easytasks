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
    		$sql="	SELECT 		U.NOMBRES, U.APELLIDOS, U.EMPRESA, PU.PERFIL
					FROM 		USUARIO U
					INNER JOIN 	PERFIL_USUARIO PU
					ON 			U.ID_USUARIO = PU.USUARIO
					WHERE 		U.USERNAME = '".$datos['txtUsuario']."' 
					AND 		U.PASSWORD = '".$datos['txtPassword']."'
					AND 		U.ESTADO_REGISTRO = 1";
	                //echo $sql;die();
	        if($record = $this->selectEasyTasks($sql)){
	        	$i=0;
				while($datos = mysql_fetch_assoc($record)){
					$arreglo['nombreUsuario'] = $datos['NOMBRES']." ".$datos['APELLIDOS'];			
					$arreglo['empresa'] = $datos['EMPRESA'];
					$arreglo['perfil'][$i] = $datos['PERFIL'];
					$i++;
				}
				//var_dump($arreglo); die();
				return $arreglo;
	        } else {
	        	return 0;
	        }				
    	} catch (Exception $e) {
    		echo 'Error: ', $e->getMessage(), "\n";
    	}
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
		//$arreglo['cboTarea']="";
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

    function creaTarjeta($datos){
    	try {
    		$sql="INSERT INTO TARJETA (TAREA, CLIENTE_SOLICITANTE, FECHA_SOLICITUD, PRIORIDAD, OBSERVACIONES, ADJUNTO, ESTADO_TARJETA, ESTADO_REGISTRO) 
	                VALUES (".$datos['cboTarea'].",".$datos['txtSolicitante'].", NOW(), ".$datos['cboPrioridad'].", '".$datos['txtObservaciones']."', '"
	                	.$datos['fileAdjunto']."', ".$datos['cboEstado'].", 1)";
	                //echo $sql;die();
	        if($record=$this->insertEasyTasks($sql)){
	            //echo "<script>alert('La tarjeta fue creada exitosamente');</script>";
	            return 1;
	        } else {
	            echo "<script>alert('Error al crear tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo 'Error: ', $e->getMessage(), "\n";
    		//echo "<script>alert('".$e->getMessage()."');</script>";
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
					$arreglo[$i]['observaciones'] = $datos['OBSERVACIONES'];
					$arreglo[$i]['idEstado'] = $datos['ESTADO_TARJETA'];
					$arreglo[$i]['estado'] = $datos['DESCRIPCION_ESTADO_TAJETA'];
					$i++;
				}
				//return $arreglo;
				foreach ($arreglo as $tarjeta) {
					//echo "<tr><td class='warning' style='background: url(ruta de la imagen);'>";
					$tarjetaJson=json_encode($tarjeta);
					//echo $tarjetaJson; die();
					echo "<tr><td style='background-color: #FFFF00'>";
					//echo "<a style='color: black;' href='#' data-toggle='modal' data-target='#modalDetalleTarjeta'>";
					echo "<a style='color: black;' href='#' onclick='detalleTarjeta(".$tarjetaJson.")'>";
					echo "<h6>".$tarjeta['tarea']."</h6>";
					echo "<small>Solicitada por: ".$tarjeta['solicitante']."</small>";
					echo "</a>";
					echo "</td></tr>";
				}
			} else {
				echo "<tr><td style='background-color: #FFFF00'>";
				echo "<h6>NO EXISTEN TARJETAS PENDIENTES</h6>";
				echo "</td></tr>";
			}
				
    	} catch (Exception $e) {
    		echo 'Error: ', $e->getMessage(), "\n";
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
    		echo 'Error: ', $e->getMessage(), "\n";
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
    		echo 'Error: ', $e->getMessage(), "\n";
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
    		echo 'Error: ', $e->getMessage(), "\n";
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
    		echo 'Error: ', $e->getMessage(), "\n";
    	}
    }

    function creaUsuario($datos){
    	try {
    		$nombreUsername = explode(" ", utf8_decode($datos['txtNombre']));    		
    		$apellidoUsername = explode(" ", utf8_decode($datos['txtApellidos']));
    		$username = substr($nombreUsername[0], 0, 1).$apellidoUsername[0];
    		$sql="INSERT INTO USUARIO (NOMBRES, APELLIDOS, EMPRESA, EMAIL, TELEFONO, USERNAME, PASSWORD, ESTADO_REGISTRO) 
	                VALUES ('".utf8_decode($datos['txtNombre'])."', '".utf8_decode($datos['txtApellidos'])."', 1, '".$datos['txtEmail']."',
	                	'".$datos['txtTelefono']."', '".strtoupper($username)."', '".strtoupper($username)."', 1)";
			//echo $sql;die();	        
	        if($record=$this->insertEasyTasks($sql)){
	            $ultimoId = $this->selectId();
	            $sql2="INSERT INTO PERFIL_USUARIO
	            		VALUES ($ultimoId, ".$datos['cboPerfil'].")";
	            if($record2=$this->insertEasyTasks($sql2)){
	            	//echo "<script>alert('La tarjeta fue creada exitosamente');</script>";
	            	return 1;
	            }
	        } else {
	            echo "<script>alert('Error al crear tarjeta');</script>";
	            echo "<script>window.history.back();</script>";
	        }
    	} catch (Exception $e) {
    		echo 'Error: ', $e->getMessage(), "\n";
    		//echo "<script>alert('".$e->getMessage()."');</script>";
    	}
	        
    }


}
?>