	// AJAX para el inicio y creacion de sesiones!


	// Input#enviar(formularios de ingreso y creacion de sesiones)
	var formulario = document.querySelector('form#formulario');
	
	if(document.querySelector('body').classList.value === "login" ||
	 document.querySelector('body').classList.value === "crear sesion") {
		formulario.addEventListener('submit', enviarForm);
	}
	

	function enviarForm(e) {
		e.preventDefault();

		let nombre = document.querySelector('input#Nombre').value,
		 password = document.querySelector('input#password').value,
		 accion = document.querySelector('input#enviar').value;

		var datos = new FormData();
		datos.append('nombre', nombre);
		datos.append('password', password);
		datos.append('accion', accion);

		if (nombre.trim().length >= 3 && password.trim().length >= 7) {

			// Crear el XMLHttpRequest
			var xhr = new XMLHttpRequest();

			// Abrir el XMLHttpRequest
			xhr.open('POST', 'include/funciones/sesiones.php', true);


			// Onready state change
			xhr.onreadystatechange = function() {

				if (xhr.readyState === 4 && xhr.status === 200) {
				// si la informacion es hallada y la respuesta es cargada
				let respuesta = JSON.parse(xhr.responseText);
					
					if (respuesta.icon === "success") {


						const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000,
						  timerProgressBar: true,
						});
						Toast.fire({
						  icon: respuesta.icon,
						  title: respuesta.title
						});

						// redireccionar al usuario
						setTimeout(() => {location.href = "index.php"}, 3000);


					}else {
					const Toast = Swal.mixin({
					  toast: true,
					  position: 'top-end',
					  showConfirmButton: false,
					  timer: 3000,
					  timerProgressBar: true,
					  onOpen: (toast) => {
					    toast.addEventListener('mouseenter', Swal.stopTimer)
					    toast.addEventListener('mouseleave', Swal.resumeTimer)
					  }
					});
					Toast.fire({
					  icon: respuesta.icon,
					  title: respuesta.title
					});
					
					}
				}
			}


			xhr.send(datos);
			


		}else {
			const Toast = Swal.mixin({
			  toast: true,
			  position: 'top-end',
			  showConfirmButton: false,
			  timer: 3000,
			  timerProgressBar: true,
			  onOpen: (toast) => {
			    toast.addEventListener('mouseenter', Swal.stopTimer)
			    toast.addEventListener('mouseleave', Swal.resumeTimer)
			  }
			})

			Toast.fire({
			  icon: 'error',
			  title: 'Los campos no tienen la informacion necesaria!'
			})
		}
			

	}

