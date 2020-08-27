<?php include "include/template/header.php"; ?>
<main>
	<!-- Consulta que llama todos los animes -->
	<?php
	try {
		require_once "include/funciones/conexion.php";
		$sql = "SELECT Id_anime, Nombre, Descripcion, Tipo FROM `anime` WHERE Estado != 'Proximamente' ORDER BY Nombre ASC LIMIT 27;";
		$resultado = $conn->query($sql);

		$division = array();
	} catch (Exception $e) {
		
	}

	?>
	<section class="resultado">
		<h2>Directorio anime</h2>
		<?php while ($registro = $resultado->fetch_assoc()) { 
			$division[$registro['Tipo']][] = $registro	;
		} ?> <!-- introduccion de un array para separar los animes segun su tipo -->

		<?php foreach ($division as $tipo => $anime) :?>
			<div class="division">
				<h3><?php echo $tipo . "S"; ?></h3>


				<?php foreach ($anime as $info) { ?>
					<a href="ver.php?Id=<?php echo $info['Id_anime']; ?>">
						<article class="anime">
							<div class="contenedor">
								<img src="anime/<?php echo $info['Nombre']; ?>/info.jpg">
								<div class="descripcion">
									<h4><?php echo $info['Nombre']; ?></h4>
									<p><?php echo $info['Descripcion']; ?></p>
								</div><!-- div.descripcion -->
							</div>
						</article><!-- article.anime -->
					</a>
				<?php } ?>


			</div><!-- div.division -->
		<?php endforeach; ?> <!-- foreach para el array division -->
	</section>
</main>

<?php $conn->close(); ?>
<?php include "include/template/footer.php"; ?>