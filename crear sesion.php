<?php include 'include/template/header.php'?>

<main>
	<section class="crearS">
		<h2>crear cuenta!</h2>
		<div class="form">
			<form method="post" id="formulario">
				<div class="campo">
					<label for="Nombre">Nombre: </label>
					<input type="text" id="Nombre" autocomplete="off" placeholder="nombre de usuario">
				</div>
				<div class="campo">
					<label for="password">Password: </label>
					<input type="password" id="password" placeholder="contraseña">
				</div>
				<div class="campo">
					<input type="submit" id="enviar" value="Crear">
				</div>
			</form>
		</div>
	</section>
</main>


<?php include "include/template/footer.php"?>