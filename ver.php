	<?php include 'include/template/header.php'?>
		<?php 
		// Id de el anime a ver
		if (isset($_GET['Id'])) :
			$Id = $_GET['Id'];
		

		?>


	<main>

		<!-- consulta de informacion del anime -->
			<?php try {
				require_once "include/funciones/conexion.php";
				$sql = "SELECT Nombre, categoria, Descripcion FROM `anime` WHERE Id_anime = {$Id};";
				$resultado = $conn->query($sql);

				$registro = $resultado->fetch_assoc();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		endif;
		?>
		<section class="tarjetaAnime">
			
			<div class="descripcionAnime">
				<h2><?php echo $registro['Nombre']; ?></h2>
				<?php $categorias = json_decode($registro['categoria']); ?>
				
				<?php foreach ($categorias as $value) : ?>
					<small><?php echo $value; ?></small>
				<?php endforeach ?>
				<div class="imgAnime">
					<img src="anime/<?php echo $registro['Nombre']; ?>/info.jpg">
					<?php if (isset($_SESSION['Id'])) : ?>
						<div class="gustar">
							<i class="fas fa-heart"></i>
						</div>
					<?php endif; ?>
				</div>
				<p><?php echo $registro['Descripcion'];?></p>
			</div>
		</section>
		
		<?php include "include/template/aside.php"; ?>

		<section class="capitulos">

			<article class="listaCaps">
				<div class="buscadorAnime">
					<h3>Lista de capitulos</h3>
					<input type="text" name="anime" placeholder="capitulos">
				</div>

				<div class="lista">
					<!-- consulta para capitulos -->
					<?php 
					$sql = "SELECT Id_capitulos, Nombre,Episodio FROM `capitulos` INNER JOIN `anime` ON capitulos.Id_nombre_anime =  anime.Id_anime WHERE Id_nombre_anime = '{$Id}' ORDER BY Episodio ASC;";
					$resultado = $conn->query($sql);
					?>

					<?php while ($registro = $resultado->fetch_assoc()) : ?>
						<a href="capitulo.php?Id=<?php echo $registro['Id_capitulos']; ?>">
							<div class="capitulo">
								<img src="anime/<?php echo $registro['Nombre'];?>/poster.jpg" alt="poster">
								<p><?php echo $registro['Nombre'] . " capitulo " . $registro['Episodio']; ?></p>
							</div>
						</a>
					<?php endwhile; ?>


				</div>
			</article>
		</section>

	</main><!-- fin main -->
<?php $conn->close(); ?>
<?php include 'include/template/footer.php';