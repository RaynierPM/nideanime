<?php 
	// iniciar sesion
	session_start();

	// definir la constante de MB
	define('MB', 1048576);

	switch ($_POST['accion']) {
		case 'Cambiar Imagen':
			if (isset($_FILES['imagen'])) {
					// si existe el archivo imagen
					// variable con el nombre del archivo
					$nombreArchivo = $_FILES['imagen']['name'];

					// variable de ruta
					$ruta = "../../usuarios/" . $_SESSION['Nombre'];

					if (is_dir($ruta)) {
						if (is_file($ruta . "/" . $nombreArchivo)) {

							//respuesta enviada al AJAX
							$respuesta = array(
								'Nombre' => $nombreArchivo,
								'icon' => "error",
								'title' => "Esta imagen ya existe!",
								'Nombre_Usuario' => $_SESSION['Nombre']
							);

						}else {
							if ($_FILES['imagen']['size'] > 1.5*MB) {
								//respuesta enviada al AJAX
								$respuesta = array(
									'Nombre' => $nombreArchivo,
									'icon' => "error",
									'title' => "El tamaño del archivo debe ser menor a 1.5MB",
									'Nombre_Usuario' => $_SESSION['Nombre']
								);
							}else {
								// si no hay error ejecutar codigo para subir la imagen y añadir la informacion a la bd
								include "conexion.php";
								// Eliminar la imagen que se enconraba anterior mente en la carpeta del usuario
								unlink($ruta . "/" . $_SESSION['Imagen']);

								// subir el la imagen al la carpeta del usuario
								move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . "/" . $_FILES['imagen']['name']);


								//actualizar en la bd al usuario
								$stmt = $conn->prepare("UPDATE `usuarios` SET Imagen = ? WHERE Id_usuario = ?");

								//preparar los parametros
								$stmt->bind_param('si', $nombreArchivo, $_SESSION['Id']);
								$stmt->execute();

								$_SESSION['Imagen'] = $nombreArchivo;



								//respuesta enviada al AJAX
								$respuesta = array(
									'icon' => 'success',
									'title' => 'La imagen se ha subido correctamente!',
									'nombre' => $_SESSION['Nombre'],
									'archivo' => $_SESSION['Imagen']
								);

								$stmt->close();
								$conn->close();

							}
						}
					}else {
						// si la ruta no existe

						//respuesta enviada al AJAX
						$respuesta = array(
								'Nombre' => $nombreArchivo,	
								'icon' => "error",
								'title' => "Esta ruta no existe!"
							);
					}
				}

			break;
			case 'Cambiar Estado'://CON ESTADO ME REFIERO A LA DESCRIPCION DEL USUARIO
				if (isset($_POST['Estado'])) {
						$_SESSION['Estado'] = htmlspecialchars(trim($_POST['Estado']));
						
						// llamar la conexion
						include "conexion.php";
						$stmt = $conn->prepare("UPDATE `usuarios` SET Estado_usuario = ? WHERE Id_usuario = ?");

						// preparar parametros
						$stmt->bind_param('si', $_SESSION['Estado'], $_SESSION['Id']);
						$stmt->execute();

						$stmt->close();
						$conn->close();
				}

			break;
			case 'Eliminar Imagen':
				//borrar imagen de la carpeta de usuarios
				$ruta = "../../usuarios/" . $_SESSION['Nombre'];
				unlink($ruta . "/" . $_SESSION['Imagen']);


				// Llamar la conexion
				include "conexion.php";
				$stmt = $conn->prepare("UPDATE `usuarios` SET Imagen = ? WHERE Id_usuario = ?");
				$_SESSION['Imagen'] = null;

				// preparar parametros
				$stmt->bind_param('si', $_SESSION['Imagen'], $_SESSION['Id']);
				$stmt->execute();

				$stmt->close();
				$conn->close();

				$respuesta = array(
					'icon' => 'success',
					'title' => 'Imagen eliminada correctamente!'
				);
				
			break;
			case 'Eliminar Descripcion':
				// Llamar la conexion
				include "conexion.php";
				$stmt = $conn->prepare("UPDATE `usuarios` SET Estado_usuario = ? WHERE Id_usuario = ?");
				$_SESSION['Estado'] = null;

				// preparar parametros
				$stmt->bind_param('si', $_SESSION['Estado'], $_SESSION['Id']);
				$stmt->execute();

				$stmt->close();
				$conn->close();

				$respuesta = array(
					'icon' => 'success',
					'title' => 'Descripcion Eliminado correctamente!'
				);


			break;

			case 'Cambiar Nombre':


				if (isset($_POST['nombre'])) {
					if ($_POST['nombre'] === $_SESSION['Nombre']) {
						// si los nombre son iguales enviar error al ajax

						$respuesta = array(
							'icon' => 'error',
							'title' => 'Este nombre es igual al que tenia'
						);

					}else {
						if (strlen(trim($_POST['nombre'])) > 2) {
							

							// Llamar la conexion
							include "conexion.php";

							// preparar consulta sql
							$sql = "SELECT Nombre_Usuario FROM `usuarios` WHERE Nombre_Usuario = '{$_POST['nombre']}';";
							$resultado = $conn->query($sql);

							if ($resultado->num_rows == 0) {
								// si no hay error iniciar el proceso de cambio de nombre

								// cambiar el nombre de la carpeta del usuario
								$ruta = "../../usuarios/";
								if (is_dir($ruta . $_SESSION['Nombre'])) {
									//si existe la carpeta del usuario cambiar el nombre
									rename($ruta . $_SESSION['Nombre'], $ruta . $_POST['nombre']);
								}

								//sustituir la session con el nuevo nombre
								$_SESSION['Nombre'] = $_POST['nombre'];


								$stmt = $conn->prepare("UPDATE `usuarios` SET Nombre_Usuario = ? WHERE Id_usuario = ?");
								// preparar parametross
								$stmt->bind_param('si', $_SESSION['Nombre'], $_SESSION['Id']);
								$stmt->execute();


								$respuesta = array(
									'icon' => 'success',
									'title' => 'El nombre ha sido cargado con exito',
									'nuevoNombre' => $_SESSION['Nombre'],
									'sql' => $sql
								);

								// cerrar el statement y la conexion
								$stmt->close();
								$conn->close();
							

							}else {
								//enviar error(Este nombre ya existe)
								$respuesta = array(
									'icon' => 'error',
									'title' => 'Este nombre ya existe'
								);
							}


						}else {
							// enviar error(El nombre debe ser mayor a 2 caracteres)
							$respuesta = array(
								'icon' => 'error',
								'title' => 'El nombre debe tener un minimo de 3 caracteres'
							);
						}
					}
				}

			break;

			case 'Cambiar Contraseña':
				if (isset($_POST['password'])) {
					//si existe la contrasenia iniciar proceso 
					include 'conexion.php';
					//crear el statement con la sentecia sql que retornara la contraseña del usuario
					$stmt = $conn->prepare("SELECT Password FROM `usuarios` WHERE Id_usuario = ?");
					//preparar los parametro de la busqueda
					$stmt->bind_param('i', $_SESSION['Id']);
					$stmt->execute();

					// retornar resultados
					$stmt->bind_result($hash);
					$stmt->fetch();
					// cerrar el statement
					$stmt->close();
					if (password_verify($_POST['password'], $hash)) {
						// si la contraseña es correcrta iniciar con el cambio de la contraseña
						if (strlen(trim($_POST['nuevaPassword'])) >= 7) {
							// si la contraseña tiene mas de 7 caracteres continuar
							if ($_POST['nuevaPassword'] == $_POST['confirmarPassword']) {
								//si las nuevas contraseñas son iguales continuar con el proceso
								$stmt = $conn->prepare("UPDATE `usuarios` SET Password = ? WHERE Id_usuario = ?");
								// preparar parametros
								$stmt->bind_param('si', password_hash($_POST['nuevaPassword'], PASSWORD_DEFAULT), $_SESSION['Id']);
								$stmt->execute();

								// enviar respuesta 
								$respuesta = array(
									'icon' => 'success',
									'title' => 'Contraseña cambiada satisfactoriamente'
								);

								// cerrar la conexion y el statement
								$stmt->close();
								$conn->close();
							}else {
								// enviar error(Las contrasenias con coinciden)
								$respuesta = array(
									'icon' => 'error',
									'title' => 'Las contraseñas no coinciden'
								);
							}


						}else {
							// La nueva contraseña debe tener un minimo de 7 digitos
							$respuesta = array(
								'icon' => 'error',
								'title' => 'La nueva contraseña debe tener un minimo de 7 caracteres'
							);
						}
					}else {
						// enviar error(la contrasenia no es correcta)
						$respuesta = array(
							'icon' => 'error',
							'title' => 'Su contraseña es Incorrecta, intentelo otra vez'
						);
					}



				}	


			break;
			case "Borrar Cuenta":
				//borrar la carpeta del usuario
				$ruta = "../../usuarios/" . $_SESSION['Nombre'];
				unlink($ruta . "/" . $_SESSION['Imagen']);
				rmdir($ruta);

				require "conexion.php";
				$stmt = $conn->prepare("DELETE FROM `usuarios` WHERE Id_usuario = ?");
				//preparar parametros
				$stmt->bind_param("i", $_SESSION['Id']);
				//ejecutar statement
				$stmt->execute();

				// borrar la session
				$_SESSION = array();


				//enviar respuesta
				$respuesta = array(
					'icon' => 'success',
					'title' => 'Su cuenta ha sido borrada exitosamente'
				);

				//cerrar el statement y la conexion a la bd
				$stmt->close();
				$conn->close();				
			break;

	}


	

	echo json_encode($respuesta);

?>