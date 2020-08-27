	<?php include 'include/template/header.php'?>

	<!-- Consulta para llamar los datos de los animes buscados -->
	<?php
		if (isset($_GET['nombre'])) {
			$nombre = $_GET['nombre'];
		}


		try {
			require_once "include/funciones/conexion.php";
			$sql = "SELECT Id_anime, Nombre, Descripcion FROM `anime` WHERE Nombre LIKE '% {$nombre} %';";
			$resultado = $conn->query($sql);
		} catch (Exception $e) {
			echo "Error";	
		}

	?>



	<main>
		<section class="resultado">
			<h2>resultados de su busqueda</h2>
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
					echo "<p>No hubo resultados en su busqueda</p>";
				}?>
		</section>
		
	</main><!-- fin main -->
<?php $conn->close(); ?>
<?php include 'include/template/footer.php'; ?>
