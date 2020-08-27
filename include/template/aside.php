<aside class="proximos">
	<h3>Anime Proximos</h3>
	<div class="top">
		<?php 
			$sql = "SELECT Id_anime, Nombre FROM `anime` WHERE Estado = 'Proximamente' ORDER BY RAND();";
		 	$Proximos = $conn->query($sql);
		 ?>
		 <?php if ($Proximos->num_rows > 0) { ?>
		 	
			 <?php while($proximos_animes = $Proximos->fetch_assoc()) : ?>
				<a href="ver.php?Id=<?php echo $proximos_animes['Id_anime'];?> ">
					<div class="proximo">
						<img src="anime/<?php echo $proximos_animes['Nombre'];?>/poster.jpg">
						<h2><?php echo $proximos_animes['Nombre']; ?></h2>
						<div class="spine"></div>
					</div>
				</a>
			<?php endwhile; ?>
		 <?php }else { ?>
 			<p>NO HAY ANIMES PROXIMOS</p>
		 <?php } ?>
	</div><!-- div.top -->
</aside><!-- aside.populares -->