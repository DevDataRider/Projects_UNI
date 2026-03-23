$(".tablas").on("click", ".btnEditarClientes", function(){

	var idClientes = $(this).attr("idClientes");

	$.ajax({

		url:base_url + "Clientes/AjaxClientes/" + idClientes,
		type: "POST",
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){

			$("#idClientes").val(respuesta["id"]);
			$("#editarnombre").val(respuesta["nombre"]);
			$("#editardocumento").val(respuesta["documento"]);
			$("#editaremail").val(respuesta["email"]);
			$("#editartelefono").val(respuesta["telefono"]);
			$("#editardireccion").val(respuesta["direccion"]);
		

		}


	})

})



$(".tablas").on("click", ".btnEliminarClientes", function(){

	var id = $(this).attr("idClientes");

	 swal({
	 	title: '¿Está seguro de borrar el cliente?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: '¡Si, borrar clientes!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = base_url + "Clientes/EliminarClientes/" + id;

	 	}

})

	 
})