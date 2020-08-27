<footer>
			<p>nideAnime&copy; <b>Derechos reservados</b></p>
	</footer><!-- fin footer -->	

<!-- sweetalert2 -->
<?php if ($pagina == "login" || $pagina == "perfil" || $pagina == "crear sesion") : ?>
	<script type="text/javascript" src="js/sweetalert2.all.min.js"></script>
<?php endif;?>
<!-- jquery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>

<!-- fontawesome -->
<script type="text/javascript" src="js/all.min.js"></script>

<!-- SLICK -->
<script type="text/javascript" src="slick/slick.js"></script>

<!-- script -->
<script type="text/javascript" src="js/script.js"></script>

<?php if ($pagina == "crear sesion" || $pagina == "login") : ?>
<!-- script para el inicio y creacion de sesion -->
<script type="text/javascript" src="js/formularios.js"></script>
<?php endif; ?>

<?php if ($pagina === "perfil") : ?>
<!-- script para la configuracion de los usuarios -->
<script type="text/javascript" src="js/config.js"></script>
<?php endif; ?>

</body>
</html>
