
$(".tablas").on("click", ".btnEditarUsuarios", function(){

	var idUsuarios = $(this).attr("idUsuarios");

	$.ajax({

		url:base_url + "Usuarios/AjaxUsuarios/" + idUsuarios,
		type: "POST",
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){

			$("#idUsuario").val(respuesta["id"]);
			$("#editarnombre").val(respuesta["nombre"]);
			$("#editarusuario").val(respuesta["usuario"]);
			$("#editarperfil").html(respuesta["perfil"]);
			$("#editarperfil").val(respuesta["perfil"]);

		}

	})


})



$(".tablas").on("click", ".btnEliminarUsuarios", function(){

	var id = $(this).attr("idUsuarios");

	 swal({
	 	title: '¿Está seguro de borrar el usuario?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: '¡Si, borrar usuario!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = base_url + "Usuarios/EliminarUsuarios/" + id;

	 	}

})

	 
})