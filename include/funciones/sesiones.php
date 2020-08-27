<?php
	require_once 'conexion.php';
	// nombrar variable con la informacion dada 
	$nombre = htmlspecialchars($_POST['nombre']);
	$password = htmlspecialchars($_POST['password']);

	$accion = $_POST['accion'];

	if ($accion == "Crear") {
		// CREAR UN NUEVO USUARIO


		// sentencia sql que revisa si hay un usuario con el mismo nombre
		$sql = "SELECT Id_usuario ,nombre_usuario, Password FROM `usuarios` WHERE nombre_usuario = '{$nombre}';";
		$resultado = $conn->query($sql);

		if($resultado->num_rows == 0) {
			// si no hay algun resultado en la busqueda del nombre de usuario se procede a crear el nuevo usuario


			// preparar la insercion a la bd
			$stmt = $conn->prepare("INSERT INTO `usuarios`(nombre_usuario, Password) VALUES (?,?)");

			// preparar parametros
			$stmt->bind_param('ss', $nombre, password_hash($password, PASSWORD_DEFAULT));

			// ejecutar insercion
			$stmt->execute();

			// iniciar la sesion para 
			session_start();
			$_SESSION['Id'] = $stmt->insert_id;
			$_SESSION['Nombre'] = $nombre;

			// Crear carpeta donde se alojara la informacion del usuario

			if (!is_dir("../../usuarios/" . $nombre)) {
				mkdir("../../usuarios/" . $nombre);
			}

			//respuesta enviada al archivo js
			$respuesta = array(
				'icon' => "success",
				'title' => "La cuenta ha sido creada con exito!"
			);


			// cerrar la conexion a la bd y el statment
			$stmt->close();
			$conn->close();

		}else {
			// envia un error, diciendo que ya hay un usuario con tal nombre
			$respuesta = array(
				'icon' => 'error',
				'title' => 'Este nombre de usuario ya existe!'
			);

		}


 	}else {
 		// INICIAR(loguear) UN USUARIO

 		// preparar la busqueda
 		$stmt = $conn->prepare("SELECT Id_usuario, nombre_usuario, Password, Imagen, Estado_usuario FROM `usuarios` WHERE nombre_usuario = ?");

 		// preparar paramtro
 		$stmt->bind_param('s', $nombre);
 		// ejecutar el statement
 		$stmt->execute();
 		// preparar el resultado
 		$stmt->bind_result($Id_usuario, $Nombre_usuario, $Password, $Imagen, $Estado);
 		// fetch a los resultados
 		$stmt->fetch();

 		if ($Nombre_usuario) {
 			// Verifica que exista el usuario
 			if (password_verify($password, $Password)) {
 				// verifica que la contrasenia sea correcta
 				
 				// inicia la variable superglobal $_SESSION
 				session_start();
 				$_SESSION['Id'] = $Id_usuario;
 				$_SESSION['Nombre'] = $Nombre_usuario;
 				$_SESSION['Imagen'] = $Imagen;
 				$_SESSION['Estado'] = $Estado;

 				// crea la respuesta que sera enviada al archivo js
 				$respuesta = array(
		 			'icon' => "success",
		 			'title' => "Usted ha logeado correctamente!"
 				);
 			}else {
 				// crea la respuesta que sera enviada al archivo js
 				$respuesta = array(
		 			'icon' => "error",
		 			'title' => "Nombre o Contraseña incorrecta!"
 				);
 			}
 		}else {
 			// crea la respuesta que sera enviada al archivo js
 			$respuesta = array(
		 		'icon' => "error",
		 		'title' => "Nombre o Contraseña incorrecta!"
 			);

 		}

 		
 	}

	echo json_encode($respuesta);

?>