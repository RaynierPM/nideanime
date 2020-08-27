<?php 
	if (isset($_GET['nombre'])) {
		$nombre = htmlspecialchars($_GET['nombre']);
	}



	try {
		require_once "conexion.php";
		$sql = "SELECT Id_anime, Nombre FROM `anime` WHERE Nombre LIKE '%{$nombre}%' ORDER BY Id_anime LIMIT 5";

		$resultado = $conn->query($sql);

		$animes = array();
		$i = 0;

		while($registro = $resultado->fetch_assoc()) {

			$animes[$i]['Id'] = $registro['Id_anime'];
			$animes[$i]['Nombre'] = $registro['Nombre']; 

			$i++;

		}

		echo json_encode($animes);
		// var_dump($animes);



	} catch (Exception $e) {
		
	}



?>