(function () {
	document.addEventListener("DOMContentLoaded", function(){
	//DOCUMENTO CARGADO

	// boton del buscador
	var boton = document.querySelector('button#enviar');
	//input#nombre
	var buscador = document.querySelector("input#nombre");
	var resultado = document.querySelector('div.resultado');












	boton.addEventListener("click", function() {
		if(buscador.value.trim() === "") {

			buscador.classList.toggle("oculto");
		
		}else if(buscador.value.length > 1) {
			document.querySelector("input[name='enviar']").click();
		
		}
	});

	// inmpedir el envio de informacion del buscador utilizando la tecla enter
	buscador.addEventListener("keydown", function(e) {
		if (e.keyCode == 13 && buscador.value.length < 2) {
			event.preventDefault();

		}

		aparecer(buscador);
	}) 


	buscador.addEventListener('blur', function() {
		setTimeout(() => {
			resultado.classList.add('oculto');
			borrarElementosAnteriores()
		}, 100);
	});


	// AJAX PARA BUSCADOR
	function borrarElementosAnteriores() {
		let animes = document.querySelectorAll('div.resultado div.anime');
			for (var i = 0; i < animes.length; i++) {
				animes[i].remove();
			}
	}


	function crearElementos(animes) {
		for (var i = 0; i < animes.length; i++) {
			
			//crear enlace
			var enlace = document.createElement('a');
			enlace.href = "ver.php?Id=" + animes[i].Id;

			// Crear div.anime
			//crear enlace
			var animeDiv = document.createElement('div');
			animeDiv.classList.add('anime');

			//crear imagen
			var animeImg = document.createElement('img');
			animeImg.src = "anime/" + animes[i].Nombre + "/poster.jpg";

			//crear p
			var animeNombre = document.createElement('p');
			var nombre = document.createTextNode(animes[i].Nombre);
			animeNombre.appendChild(nombre);



			// Ensamblar elementos del template
			animeDiv.appendChild(animeImg);
			animeDiv.appendChild(animeNombre);

			enlace.appendChild(animeDiv);

			// agregar elementos al div.resultado
			resultado.appendChild(enlace);

		}
	}



	function aparecer(obj) {
			var xhr = new XMLHttpRequest();
		

		if (obj.value.length > 2) {
			resultado.classList.remove('oculto');

			var nombre = obj.value;
			// ajax

			xhr.open('GET', 'include/funciones/buscadorAJAX.php?nombre=' + nombre, true);

			xhr.onreadystatechange = function() {
				
				if (xhr.readyState == 4 && xhr.status == 200) {
					var animes = JSON.parse(xhr.responseText);

					borrarElementosAnteriores();

					crearElementos(animes);

				}else {

				}
			}

			xhr.send();
			
		} else {
			resultado.classList.add('oculto');
			borrarElementosAnteriores();
		}
	}

	//fin ajax






		//POSiCION DEL USUARIO en la las paginas
	if (document.querySelector("body").classList == "index") {
		document.querySelector("body.index nav.principal a[href='index.php']").classList.add("active");


	}else if (document.querySelector("body").classList == "anime") {
		document.querySelector("body.anime nav.principal a[href='anime.php']").classList.add("active");

	}
	

	//slick
	$("div.slider").slick({
			autoplay: true,
			autoplaySpeed: 5000,
			focusOnSelect: true,
			slidesToShow: 2,
			centerMode: true,
			prevArrow: '<button type="button" class="slick-prev"><</button>',
			nextArrow:'<button type="button" class="slick-prev">></button>',
			dots: true,
			responsive: [
			{
				breakpoint: 786,
				settings: {
					slidesToShow: 2,
					centerMode: true
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					centerMode: false
				}
			}]
		});

		

	});//DOM CONTENT LOADED
})();
