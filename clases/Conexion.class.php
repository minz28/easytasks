<?php

/**********************************************************************************************************
*** Conexion.class.php: CONTIENE LAS CONEXIONES A LAS BASES DE DATOS									***
***																										***
***																										***
***	Referencia		Autor				Descripcion														***
***	----------		---------------		---------------------------------------------					***
***	<01>			Miguel Inzunza		Conexión a base de datos intranetv2  							***
***	<02>			Miguel Inzunza		Query's de lectura base de datos intranetv2		    			***
***	<03>			Miguel Inzunza		Query's de escritura base de datos intranetv2					***
***	<04>			Miguel Inzunza		***
***	<05>			Miguel Inzunza		***
***	<06>			Miguel Inzunza		***
***	<07>			Miguel Inzunza		***
***	<xx>			Miguel Inzunza		***
***	<xx>			Miguel Inzunza		***
***	<xx>			Miguel Inzunza		***
***	<xx>			Miguel Inzunza		***
***********************************************************************************************************/


class Conexion{
    
    /*Variables para conexión a bd easytasks*/    
    var $host = "localhost";
	var $db	  = "easytasks";
    var $user = "root";
	//var $pass = "";//LAPTOP
    var $pass = "root";//PC TRABAJO
    
    
    /*<01> Conexión a base de datos intranetv2*/	
	public function conectaEasyTasks(){
        if(!($link=mysql_connect($this->host, $this->user, $this->pass))){
    		$link = false;//"<h1> [:(] Error al conectar la base de datos</h1>";//
    		return $link;
    		mysqli_close($link);
    	}//FIN if
    	mysql_query("SET NAMES 'utf8'");//esto arregla el problema al mostrar los acentos y las Ã‘ guardadas en la base
    	if(!(mysql_select_db($this->db,$link))){
    		$link = false;//"<h1> [:(] Error al seleccionar la base de datos</h1>";//
    		return $link;
    		mysqli_close($link);
    	}//FIN if
    	return $link;
    	mysqli_close($link);
    }//FIN conectaPersonal
    
    /*<02>Query's de lectura base de datos intranetv2*/
	function selectEasyTasks($query){		
		$conexion = $this->conectaEasyTasks();
		// enviamos la consulta a MySQL
		if(!($Emp = mysql_query($query, $conexion))){
			$Emp = false;//"[:(] Error de consulta:".$query;//
		}//FIN if
		// verificamos si la consulta retorna datos
		if(mysql_num_rows($Emp)==0){
			$Emp = false;//"[:(] Sin Datos";//
		}//FIN if
		return $Emp;
		mysql_close($conexion);
	}//FIN function

    /*<03>Query's de escritura base de datos intranetv2*/
	function insertEasyTasks($query){		
		$conexion = $this->conectaEasyTasks();
		// enviamos la consulta a MySQL
		if(!($Emp = @mysql_query($query, $conexion))){
			$Emp = false;//"[:(] Error de consulta:".$query;//
		}//FIN if
		return $Emp;
		mysql_close($conexion);
	}//FIN function
    

}//FIN clase

?>