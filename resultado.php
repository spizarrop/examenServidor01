<?php
require_once "conexionDB.php";

// Creamos la conexion
$conexion = new mysqli(SERVER,USER,PASS,DB);

// Driver para los errores
/* $driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ALL | MYSQLI_REPORT_STRICT; */

try {
	// Variables
	$clase = $_GET['clase'];
	$tutor = $_GET['tutor'];
	$observaciones = $_GET['observaciones'];
	
	if(!isset($_GET['participa'])){
		$participa = 0;
	}else{
		$participa = 1;
	}
	
	$alumno1 = $_GET['alumno1'];
	$alumno2 = $_GET['alumno2'];
	$alumno3 = $_GET['alumno3'];
	$alumno4 = $_GET['alumno4'];

	if($clase != ""){
	
		$sql = "INSERT INTO inscripciones (clase, idTutor, observaciones, participa_organizacion) VALUES ('".$clase."',".$tutor.",'".$observaciones."',".$participa.");";
		$conexion->query($sql);

		// Se que hay otra forma de obtener el id de la ultima consulta
		$sql = "SELECT idInscripcion FROM inscripciones WHERE clase='".$clase."' AND idTutor=".$tutor." AND observaciones='".$observaciones."' AND participa_organizacion=".$participa;
		$resultado = $conexion->query($sql);
		$fila = $resultado->fetch_assoc();
		$idInscripcion = $fila['idInscripcion'];

		if($alumno1 != ""){
			$sql = "INSERT INTO inscripciones_alumnos (idInscripcion, nombre) VALUES (".$idInscripcion.",'".$alumno1."');";
			$conexion->query($sql);
		}
		if($alumno2 != ""){
			$sql = "INSERT INTO inscripciones_alumnos (idInscripcion, nombre) VALUES (".$idInscripcion.",'".$alumno2."');";
			$conexion->query($sql);
		}
		if($alumno3 != ""){
			$sql = "INSERT INTO inscripciones_alumnos (idInscripcion, nombre) VALUES (".$idInscripcion.",'".$alumno3."');";
			$conexion->query($sql);
		}
		if($alumno4 != ""){
			$sql = "INSERT INTO inscripciones_alumnos (idInscripcion, nombre) VALUES (".$idInscripcion.",'".$alumno4."');";
			$conexion->query($sql);
		}
	
	}
	
	// Funcion para mostrar los datos de una inscripcion pasandole por marametro una clase
	function mostarDatosInscripcion($clase){
		$conexion = new mysqli(SERVER,USER,PASS,DB);
		
		$sql = "SELECT i.clase AS clase, p.nombre AS profesor, i.observaciones AS observaciones, i.participa_organizacion AS participa 
		FROM inscripciones i
		INNER JOIN profesores p ON p.idProfesor = i.idTutor
		WHERE clase='".$clase."';";
		$resultado = $conexion->query($sql);
		$fila = $resultado->fetch_assoc();
		
		if($fila['participa']){
			$participa = "Si";
		}else{
			$participa = "No";
		}
		echo "Clase: ".$clase." <br>Profesor: ".$fila['profesor']." <br>Observaciones: ".$fila['observaciones']." <br>Participa: ".$participa;
		
		$sql = "SELECT ia.nombre AS nombre FROM inscripciones_alumnos ia
		INNER JOIN inscripciones i ON ia.idInscripcion = i.idInscripcion
		WHERE i.clase='".$clase."';";
		$resultado = $conexion->query($sql);

		echo "<br>Alumnos:";
		foreach ($resultado as $fila) {
			echo "<br>- ".$fila['nombre'];
		}
	}

	// llamada a la funcion
	//mostarDatosInscripcion("1daw");

	function mostarDatosInscripciones(){
		$conexion = new mysqli(SERVER,USER,PASS,DB);
		
		$sql = "SELECT i.clase AS clase, p.nombre AS profesor, i.observaciones AS observaciones, i.participa_organizacion AS participa 
		FROM inscripciones i
		INNER JOIN profesores p ON p.idProfesor = i.idTutor";
		$resultado = $conexion->query($sql);
		
		while($fila = $resultado->fetch_assoc()){

			if($fila['participa']){
				$participa = "Si";
			}else{
				$participa = "No";
			}
			
			echo "Clase: ".$fila['clase']." <br>Profesor: ".$fila['profesor']." <br>Observaciones: ".$fila['observaciones']." <br>Participa: ".$participa;

			$sql = "SELECT ia.nombre AS nombre FROM inscripciones_alumnos ia
			INNER JOIN inscripciones i ON ia.idInscripcion = i.idInscripcion
			WHERE i.clase='".$fila['clase']."';";
			$resultado = $conexion->query($sql);

			echo "<br>Alumnos:";
			foreach ($resultado as $fila) {
				echo "<br>- ".$fila['nombre'];
			}
		}
	}

	mostarDatosInscripciones();


} catch(mysqli_sql_exception $e){
	$mensaje_error = $e->getMessage();
	$codigo_error = $e->getCode();
	
	switch ($e->getCode()){
		case 1062:
			echo 'Has introducido una clave unica duplicada';
			echo $mensaje_error;
		break;
		default:
			echo 'Error: '.$mensaje_error.' Codigo: '.$codigo_error;
		break;
	}
	
}

?>