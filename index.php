	<?php include 'include/template/header.php'?>

	<main>

		<section class="recientes">

			<!-- consulta sobre los ultimos capitulos -->

			<?php 
				try {
					require_once "include/funciones/conexion.php";
					$sql = "SELECT Id_capitulos, Nombre, Episodio FROM `capitulos` INNER JOIN `anime` ON capitulos.Id_nombre_anime=anime.Id_anime ORDER BY Id_capitulos DESC LIMIT 18";
					$resultado = $conn->query($sql);					


				} catch (Exception $e) {
					echo "error";
				}

			?>

			<h2>Lo mas reciente!</h2>
			<?php while ($registro = $resultado->fetch_assoc()) :?>
				<article class="capitulo">
					<a href="capitulo.php?Id=<?php echo $registro['Id_capitulos'];?>">
						<img src="anime/<?php echo $registro['Nombre']; ?>/poster.jpg" alt="<?php echo $registro['Nombre'];?>">
						<h3><?php echo $registro['Nombre'] . " " . $registro['Episodio']; ?></h3>
					</a>
				</article>
			<?php endwhile; ?>	
		</section><!-- section.recientes -->

		<!-- consulta a la base de datos sobre los animes recomendados -->

		<?php
			$sql = "SELECT Id_anime, Nombre, descripcion FROM `anime` WHERE Estado = 'Finalizado' AND Tipo = 'Anime' ORDER BY RAND() LIMIT 5;";
			$resultado = $conn->query($sql);
		?>





		<section class="recomendados">
			<h2>recomendaciones!</h2>
			<div class="slider">


			<?php while($registro = $resultado->fetch_assoc()) : ?>
				<a href="ver.php?Id=<?php echo $registro['Id_anime']; ?>">
					<article class="anime">
						<div class="contenedor">
							<img src="anime/<?php echo $registro['Nombre']; ?>/info.jpg">
							<div class="descripcion">
								<h4><?php echo $registro['Nombre']; ?></h4>
								<p><?php echo $registro['descripcion']; ?></p>
							</div><!-- div.descripcion -->
						</div>
					</article><!-- article.anime -->
				</a>
			<?php endwhile;?>


			</div>
		</section><!-- section.recomendados -->

		<?php include "include/template/aside.php" ?>

		<!-- consulta para animes en emision -->
		<?php 
		$sql = "SELECT Id_anime, Nombre, Descripcion FROM `anime` WHERE Estado = 'Emision' LIMIT 12;";
		$resultado = $conn->query($sql);

		?>


		<section class="resultado">
			<h2>Animes en emision</h2>
			<?php if($resultado->num_rows != 0) { ?>
				<?php while ($registro = $resultado->fetch_assoc()) : ?>
					<a href="ver.php?Id=<?php echo $registro['Id_anime']; ?>">
						<article class="anime">
							<div class="contenedor">
								<img src="anime/<?php echo $registro['Nombre']; ?>/info.jpg">
								<div class="descripcion">
									<h4><?php echo $registro['Nombre']; ?></h4>
									<p><?php echo $registro['Descripcion']; ?></p>
								</div>
							</div>
						</article>
					</a>
				<?php endwhile; ?>
			<?php }else {
					echo "<p>No hay anime en emision/p>";
				}?>
		</section>
	</main><!-- fin main -->
	<?php $conn->close(); ?>
	<?php include "include/template/footer.php"?>
<!-- crear seccion para animes que vendran -->