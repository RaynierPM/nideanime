	<?php include 'include/template/header.php'?>
	<?php include 'include/funciones/funciones.php'; ?>
	<!-- consulta para llamar el capitulo desde la base de datos -->
	<?php 
		if (isset($_GET['Id'])) {
			$Id = $_GET['Id'];
		}
		
		try {
			require_once "include/funciones/conexion.php";
			$sql = "SELECT Id_anime, Nombre, Episodio, Ruta_capitulo FROM `capitulos` INNER JOIN `anime` ON capitulos.Id_nombre_anime = anime.Id_anime WHERE Id_capitulos = {$Id}";

			$resultado = $conn->query($sql);
			$registro = $resultado->fetch_assoc();

		} catch (Exception $e) {
			
		}

	?>

	<main>
		<section class="ver">
			<a href="ver.php?Id=<?php echo $registro['Id_anime'];?>"><h2><?php echo $registro['Nombre'] . " " . $registro['Episodio'];?></h2></a>
				<video controls="">
					<source src="anime/<?php echo $registro['Nombre'] . '/' . $registro['Ruta_capitulo']; ?>" type="video/mp4">
				</video>

				<div class="controles">
					<?php if($registro['Episodio'] != 1) :?>
					<div class="anterior"><a href="capitulo.php?Id=<?php echo anterior($registro['Episodio'], $registro['Id_anime'], $conn); ?>"><</a></div>
					<?php endif; ?>

					<a href="ver.php?Id=<?php echo $registro['Id_anime']; ?>">
						<div class="episodios">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</a>
					<?php if (capitulos_cantidad($conn, $registro['Id_anime']) != $registro['Episodio']) : ?>
					<div class="siguiente"><a href="capitulo.php?Id=<?php echo siguiente($registro['Episodio'], $registro['Id_anime'], $conn); ?>">></a></div>
					<?php endif; ?>
				</div>
		</section><!-- section.ver -->

		<?php include 'include/template/aside.php'; ?>


		<section class="comentarios">
			<h2>comentarios</h2>
			<div class="proximamente">
				<p>PROXIMAMENTE!</p>
			</div>
		</section>
	</main><!-- fin main -->
<?php $conn->close();?>
<?php include 'include/template/footer.php'; ?>