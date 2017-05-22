<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require("Conexion.class.php");

class Funciones extends Conexion{

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

    function muestraTablero(){
    	try {
    		$sql="	SELECT
						S.DESCRIPCION_SISTEMA,
						T.DESCRIPCION_TAREA,
						C.NOMBRE_CLIENTE,
						C.CARGO_CLIENTE,
						C.AREA_CLIENTE,
						TJ.FECHA_SOLICITUD,
						P.DESCRIPCION_PRIORIDAD,
						TJ.ESTADO_TARJETA
					FROM
						TARJETA TJ
					INNER JOIN TAREA T ON TJ.TAREA = T.ID_TAREA
					INNER JOIN SISTEMA S ON T.SISTEMA = S.ID_SISTEMA
					INNER JOIN CLIENTE C ON TJ.CLIENTE_SOLICITANTE = C.ID_CLIENTE
					INNER JOIN PRIORIDAD P ON TJ.PRIORIDAD = P.ID_PRIORIDAD
					WHERE
						C.EMPRESA = 1
					AND TJ.ESTADO_REGISTRO = 1
					ORDER BY
						TJ.ESTADO_TARJETA ASC, TJ.FECHA_SOLICITUD ASC";
						echo $sql; die();
			//$record = $this->selectEasyTasks($sql);
			$i=0;
			while($datos = mysql_fetch_assoc($record)){
				$arreglo['tarea'][$i] = $datos['DESCRIPCION_SISTEMA']." - ".$datos['DESCRIPCION_TAREA'];			
				$arreglo['solicitante'][$i] = $datos['NOMBRE_CLIENTE']." - ".$datos['CARGO_CLIENTE']." - ".$datos['AREA_CLIENTE'];
				$arreglo['fechaSolicitud'][$i] = $datos['FECHA_SOLICITUD'];
				$arreglo['prioridad'][$i] = $datos['DESCRIPCION_PRIORIDAD'];
				$arreglo['estado'][$i] = $datos['ESTADO_TARJETA'];
				$i++;
			}
			var_dump($arreglo); die();
			/*while ($arreglo) {
				//Armar tablas de cuadro kanban
			}*/
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


}
?>