<?php
require_once "./conexionDB.php";

$conexion = new mysqli(SERVER,USER,PASS,DB);

$sql = "SELECT * FROM profesores";
$resultado = $conexion->query($sql);

$profesores = [];
forEach ($resultado as $fila){
	$profesores[$fila['idProfesor']] = $fila['nombre'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF8">
	<title>Formulario</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<form action="resultado.php" method="GET">
		<h1>INSCRIPCIÓN TORNEO AJEDREZ</h1>
		<label for="clase">Clase:</label>
		<input type="text" name="clase">
		<label for="tutor">Tutor:</label>
		<select name="tutor">
		<?php
			forEach ($profesores as $id => $tutor) {
			echo "<option value='".$id."'>".$tutor."</option>";
			}
		?>
		</select>
		<label for="observaciones">Observaciones:</label>
		<input type="text" name="observaciones">
		<label for="participa">Participa en la organización:</label>
		<input type="checkbox" value="participa">
		<label for="alumnos">Alumnos:</label>
		<input type="text" name="alumno1">
		<input type="text" name="alumno2">
		<input type="text" name="alumno3">
		<input type="text" name="alumno4">
		<button type="submit">Enviar</button>
	</form>
</body>
</html>