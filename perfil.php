<?php require "include/template/header.php";?>

<main>
	<?php 
		if (isset($_SESSION['Id'])) {
			$Id = $_SESSION['Id'];

			try {
				require_once "include/funciones/conexion.php";
				// Preparar el statements
				$stmt = $conn->prepare("SELECT Id_usuario, Nombre_usuario, Password, Imagen FROM `usuarios` WHERE Id_usuario = ? ;");

				// preparar parametro
				$stmt->bind_param("i", $Id);

				// preparar variables
				$stmt->bind_result($Id_usuario, $Nombre_usuario, $Password, $Imagen);

				// executar el statement
				$stmt->execute();
				$stmt->fetch();

				// cerrar el statment
				$stmt->close();




			} catch (Exception $e) {
				$error = $e->getMessage();
				echo $error;
			}
		}
	?>
	<section class="perfil">
		<div class="infoImg">
			<h2><?php echo $_SESSION['Nombre']; ?></h2>
			<div class="imgUsuario">
				<img 
					<?php if (is_file("usuarios/" . $_SESSION['Nombre'] . "/" . $_SESSION['Imagen']) && isset($_SESSION['Imagen'])) {
						// si exite la imagen de usuario guardada en su carpeta cargarla
						echo "src='usuarios/" . $_SESSION['Nombre'] . "/" . $_SESSION['Imagen'] . "'";
					} else {
						// si no exite la imagen, cargar una imagen predeterminada
						echo "src='img/noimage.jpg'";
					}?>
				>

				<div class="editar">
					<i class="fas fa-pen"></i>
				</div>
			</div>
			<small>recomendado imagenes cuadradas.</small>

		</div>

		<div class="estadoUsuario">
			<h4>Descripcion</h4>
			<div class="estado">
				<p>
					<?php
						if (isset($_SESSION['Estado'])) {
							echo $_SESSION['Estado'];
						}else {
							echo "No hay Descripcion actualmente";
						}
					?>
				</p>

				<div class="editar">
					<i class="fas fa-pen"></i>
				</div>
			</div>
		</div>
	</section><!-- section.perfil -->

	<!-- aside -->		
	<?php include "include/template/aside.php";?>

	<section class="settings">
		<h2>Configuraciones</h2>
		<div class="opcion"><p><i class="fas fa-trash"></i>Eliminar Imagen</p></div>
		<div class="opcion"><p><i class="fas fa-trash"></i>Eliminar Descripcion</p></div>
		<div class="opcion"><p><i class="fas fa-pen"></i>Cambiar Nombre</p></div>
		<div class="opcion"><p><i class="fas fa-pen"></i>Cambiar Contraseña</p></div>
		<div class="opcion"><p><i class="fas fa-trash"></i>Borrar Cuenta</p></div>
	</section>


	<section class="gustados">
		<h2>Animes que te gustaron</h2>
	</section>
</main>
<!-- cerrar conexion a la bd -->
<?php $conn->close(); ?>
<?php require "include/template/footer.php" ?>