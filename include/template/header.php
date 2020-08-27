<?php 
	session_start();
	$archivo = basename($_SERVER["PHP_SELF"]);
	$pagina = str_replace(".php", "", $archivo);

	if (isset($_GET['cerrar'])) {
		$_SESSION = array();
	}

	if ($pagina == "crear sesion" || $pagina == "login") {
		if(isset($_SESSION['Nombre'])) {
			header('location: index.php');
			exit();			
		}
	}elseif ($pagina == "perfil") {
		if (!isset($_SESSION['Nombre'])) {
			header("location: index.php");
			exit();
		}
	}

	// variable con la ruta de las imagenes
	$ruta = "usuarios/" . $_SESSION['Nombre'] . "/";
?>


<!DOCTYPE html>
<html>
<head>
	<title>nideAnime</title>
	<!-- slick css -->
	<link rel="stylesheet" type="text/css" href="slick/slick.css">
	<!-- fuentes -->
	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<?php if($pagina == "crear sesion" || $pagina == "login" || $pagina == "perfil") :?>
		<!-- estilos de libreria 'sweetalert' -->
		<link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css"> 
	<?php endif; ?>
	<!-- Estilos -->
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<!-- meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body class="<?php echo $pagina; ?>">
	<header>
		<div class="hero">
			<div class="logo"><h1>nide<span>A</span>nime</h1></div>
		</div>

		<div class="barra">
			<nav class="principal">
				<a href="index.php">Inicio</a>
				<a href="anime.php">Animes</a>
			</nav><!-- nav.principal -->

			<div class="buscador">
				<form action="buscar.php" method="get">
					<input type="text" name="nombre" id="nombre" placeholder="Buscar Anime" class="oculto" autocomplete="off" max="40">

					<div class="resultado oculto">
					</div>

					<input type="submit" name="enviar">
				</form>
				<button id="enviar"><i class="fas fa-search"></i></button>
			</div><!-- div.buscador -->
			<?php if (isset($_SESSION['Nombre'])) {?>
			<!-- si hay sesion iniciada -->
				<div class="perfil">
						<?php if (is_file($ruta . $_SESSION['Imagen']))  {?>
								
							<?php $ruta = $ruta . $_SESSION['Imagen'];?>
								
							<img src="<?php echo $ruta?>">
						<?php }else {?>
							<img src="img/noimage.jpg">
						<?php 	} ?>
					<div class="menu">
						<p class="nombre"><a href="perfil.php"><?php echo $_SESSION['Nombre']; ?></a></p>
						<a href="<?php echo $archivo ?>?cerrar=true" class="cerrarSesion">CERRAR SESION</a>
					</div>
				</div>
			<?php }else { ?>
				<div class="perfil">
					<a class="iniciarSesion" href="login.php">Iniciar Sesion</a>
					<a class="crearSesion" href="crear sesion.php">Crear Sesion</a>
				</div>
			<?php } ?>
		</div>
	</header><!-- fin header -->