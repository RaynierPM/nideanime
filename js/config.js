if (document.querySelector('body').classList.value === "perfil") {
		// si me encuentro en la pagina perfil
	

		// Ajax para editar la foto de perfil!
		var editarImg = document.querySelector('div.infoImg div.editar');

		editarImg.addEventListener('click', cambiarImagen);




		function cambiarImagen() {
			(async () => {

			const { value: file } = await Swal.fire({
			  title: 'Select image',
			  input: 'file',
			  inputAttributes: {
			    'accept': 'image/*',
			    'aria-label': 'Upload your profile picture',
			    'name': 'imagen'
			  }
			})
			if (file) {
			  //mostrar modal cargando 
			  cargando();

			  const reader = new FileReader()
			  reader.onload = (e) => {

			  	var xhr = new XMLHttpRequest();

			  	xhr.open('POST', 'include/funciones/editar perfil.php', true);

			  	// CREAR FormData para enviar los datos!
			  	var datos = new FormData();
			  	datos.append('imagen', file);
			  	datos.append('accion', "Cambiar Imagen");

			  	xhr.onreadystatechange = () => {
			  		if (xhr.readyState === 4 && xhr.status === 200) {
						let respuesta = JSON.parse(xhr.responseText);

						if (respuesta.icon === "success") {
							// si no hay error
				  			Swal.fire({
						      title: respuesta.title,
						      imageUrl: e.target.result,
						      imageAlt: 'The uploaded picture'
						    });

				  			//funcion que cambia las imagenes de manera asincrona
				  			cambiarTemplate(respuesta);



						}else {
							Swal.fire({
						      title: respuesta.title,
						      imageAlt: 'The uploaded picture'
						    });
						}
			  		}
			  	}
			    
			    xhr.send(datos);
			  }
			  reader.readAsDataURL(file)
			}

			})()
		}

		function cambiarTemplate(respuesta) {
			// imagenes que cambiaran
			var imagenUsuario = document.querySelector('div.imgUsuario img');
			imagenUsuario.src = "usuarios/" + respuesta.nombre + "/" + respuesta.archivo; 

			var imagenUsuario = document.querySelector('div.perfil img');
			imagenUsuario.src = "usuarios/" + respuesta.nombre + "/" + respuesta.archivo;

		}

		// Ajax para editar el estado
		var editarEstado = document.querySelector('div.estado div.editar');
		editarEstado.addEventListener('click', cambiarEstado);

		function cambiarEstado() {
			(async () => {
				const { value: text } = await Swal.fire({
				  title: 'Escriba su descripcion',
				  input: 'textarea',
				  inputPlaceholder: 'Type your message here...',
				  inputAttributes: {
				    'aria-label': 'Ingrese su nueva descripcion aqui...'
				  },
				  showCancelButton: true
				})


				if (text) {
					//mostrar modar cargando
					swal.fire({allowOutsideClick: false}); swal.showLoading();
					// iniciar xmlHttpRequest
					var xhr = new XMLHttpRequest();

					xhr.open('POST', 'include/funciones/editar perfil.php', true);


					// var estado, contiene la informacion que sera enviada
					var estado = new FormData();
					estado.append('accion', 'Cambiar Estado');
					estado.append('Estado', text.trim());

					xhr.onreadystatechange = () => {
						if (xhr.readyState === 4 && xhr.status === 200) {
				  			Swal.fire(text);

				  			document.querySelector('div.estado p').innerText = text;
						}
					}

				  	xhr.send(estado);
				}
			})();
		};


		// ajax para las configuraciones de usuario
		var opcion = document.querySelectorAll('section.settings div.opcion');

		for (var i = opcion.length - 1; i >= 0; i--) {
			// iteraion del array opcion, que contiene cada boton del las opciones del usuario
			let accion = opcion[i].firstElementChild.innerText;
			opcion[i].addEventListener('click', () => { configurar(accion);});
		}

		function configurar(accion) {
			// funcion para los botones de configuracion de usuarios
			switch(accion) {
				case 'Eliminar Imagen':
					Swal.fire({
					  title: 'Estas seguro?',
					  text: "No podras revertir esto!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Si, seguro!'
					}).then((result) => {
					  if (result.value) {
					  		cargando();
							var xhr = new XMLHttpRequest();
							xhr.open('POST', 'include/funciones/editar perfil.php');
							// crear variable con los datos a enviar
							var datos = new FormData();
							datos.append('accion', accion);

							xhr.onreadystatechange = () => {
								if (xhr.readyState === 4 && xhr.status === 200) {
								let respuesta = JSON.parse(xhr.responseText);
								console.log(respuesta);
									
									alertar(respuesta);

									// imagenes que cambiaran
									var imagenUsuario = document.querySelector('div.imgUsuario img');
									imagenUsuario.src = "img/noimage.jpg";

									var imagenUsuario = document.querySelector('img.foto');
									imagenUsuario.src = "img/noimage.jpg";



								}
							};
							xhr.send(datos);
						}
					});

					break;
				
				case 'Eliminar Descripcion':
					Swal.fire({
					  title: 'Estas seguro?',
					  text: "No podras revertir esto!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Si, seguro!'
					}).then((result) => {
					  if (result.value) {
					  	cargando();
					    var xhr = new XMLHttpRequest();
						xhr.open('POST', 'include/funciones/editar perfil.php');
						// crear variable con los datos a enviar
						var datos = new FormData();
						datos.append('accion', accion);

						xhr.onreadystatechange = () => {
							if (xhr.readyState === 4 && xhr.status === 200) {
								let respuesta = JSON.parse(xhr.responseText);

								alertar(respuesta);
								
								//cambiar el texto del div.estado p
					  			document.querySelector('div.estado p').innerText = "No hay Descripcion actualmente";
							}
						};
						xhr.send(datos);
					  }
					})

					


					break;
				
				case 'Cambiar Nombre':
					(async() => {

					const {value: text} = await swal.fire({
							title: 'Ingrese su nuevo nombre de usuario',
							input: "text",
							inputPlaceholder: 'Nuevo nombre',
							inputAttributes: {
								'aria-label': "Nuevo Nombre"
							},
							showCancelButton: true,
							showCloseButton: true,
							allowOutsideClick: false/*,
							footer: "Este acto es irreversible"*/
						});
						if (text) {

							if (text.trim().length >= 3) {
								swal.fire({
									icon: 'warning',
									title: 'Estas seguro?',
									showCancelButton: true,
									cancelButtonText: 'No',
									cancelButtonColor: "#d33",
									confirmButtonText: "Sí, Seguro",
									confirmButtonColor: "#3d3"
								}).then((result) => {
									if (result.value) {
										// mostrar modal cargando
										cargando();

										var xhr = new XMLHttpRequest();

										xhr.open('POST', 'include/funciones/editar perfil.php', true);
										// crear variable con los datos a enviar
										var datos = new FormData();
										datos.append('accion', accion);
										datos.append('nombre', text);

										xhr.onreadystatechange = () => {

											if (xhr.readyState === 4 && xhr.status === 200) {
												let respuesta = JSON.parse(xhr.responseText);

												if (respuesta.icon === "success") {
													// si no hay error
													alertar(respuesta);

													// cambiar los nombre de la interfaz
													var tmpNombre = document.querySelector('p.nombre a');
													tmpNombre.innerText = respuesta.nuevoNombre;
													var tmpNombre = document.querySelector('div.infoImg h2');
													tmpNombre.innerText = respuesta.nuevoNombre;

												}else {
													alertar(respuesta);
												}									
											}


										}

										xhr.send(datos);
									}
								})
							}else {
								swal.fire({
									icon: 'warning',
									text: 'los nombre deben tener un minimo de de 3 caracteres'
								});
							}
						}
					})();
					break;
				
				case 'Cambiar Contraseña':
					swal.mixin({
						input: 'password',
						confirmButtonText: 'Siguiente &rarr;',
						showCancelButton: true,
						cancelButtonText: 'Cancelar',
						cancelButtonColor: '#d33',
						allowOutsideClick: false,
						progressSteps: ['1', '2', '3'],
					}).queue([
						{
							title: 'Ingrese su Contraseña'
						},
						'Ingrese la nueva Contraseña',
						'Repita su nueva Contraseña'
					]).then((result) => {
						if (result.value) {
							cargando();

							// crear XMLHttpRequest
							var xhr = new XMLHttpRequest();
							xhr.open('POST', 'include/funciones/editar perfil.php', true);

							var datos = new FormData();
							datos.append('accion', accion);
							datos.append('password', result.value[0]);
							datos.append('nuevaPassword', result.value[1]);
							datos.append('confirmarPassword', result.value[2]);

							xhr.onreadystatechange = cambiarContra;

							function cambiarContra() {
								if (xhr.readyState === 4 && xhr.status === 200) {
									let respuesta = JSON.parse(xhr.responseText);

									if (respuesta.icon == 'success') {
										alertar(respuesta);
									}else {
										alertar(respuesta);
									}

								}
							};


							xhr.send(datos);
						}
					});
					break;

				case 'Borrar Cuenta':
					Swal.fire({
					  title: 'Estas seguro?',
					  text: "No podras revertir esto!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Si, seguro!'
					}).then((result) => {
					  if (result.value) {
					  	cargando();
					    var xhr = new XMLHttpRequest();
						xhr.open('POST', 'include/funciones/editar perfil.php');
						// crear variable con los datos a enviar
						var datos = new FormData();
						datos.append('accion', accion);

						xhr.onreadystatechange = () => {
							if (xhr.readyState === 4 && xhr.status === 200) {
								let respuesta = JSON.parse(xhr.responseText);

								swal.fire({
									icon: respuesta.icon,
									title: respuesta.title
								}).then((result) => {
									if (result) {
										location.href = "index.php";
									}
								});
							}
						};
						xhr.send(datos);
					  }
					})

				break;
			}



		}


		function alertar(respuesta) {
			swal.fire({
				icon: respuesta.icon,
				title: respuesta.title
			});
		}


		function cargando() {
			swal.fire({allowOutsideClick: false});swal.showLoading();
		}
	}//fin perfil 