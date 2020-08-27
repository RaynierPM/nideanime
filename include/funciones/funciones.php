<?php 





	function anterior($capitulo, $anime, $conn) {
		$anterior = $capitulo - 1;
		$sql = "SELECT Id_capitulos FROM `capitulos` WHERE Id_nombre_anime = {$anime} AND Episodio = {$anterior};";
		$atras = $conn->query($sql);
		$atras = $atras->fetch_assoc();

		return $atras['Id_capitulos'];
	}

	function siguiente($capitulo, $anime, $conn) {
		$anterior = $capitulo + 1;
		$sql = "SELECT Id_capitulos FROM `capitulos` WHERE Id_nombre_anime = {$anime} AND Episodio = {$anterior};";
		$atras = $conn->query($sql);
		$atras = $atras->fetch_assoc();

		return $atras['Id_capitulos'];
	}

	function capitulos_cantidad($conn, $anime) {
		$sql = "SELECT * FROM `capitulos` WHERE Id_nombre_anime = {$anime};";
		$cantidad = $conn->query($sql);

		return $cantidad->num_rows;
	}





?>