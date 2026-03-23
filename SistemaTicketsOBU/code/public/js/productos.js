
$(".tablas").on("click", ".btnEditarProductos", function(){

	var idProductos = $(this).attr("idProductos");

	$.ajax({

		url:base_url + "Productos/AjaxProductos/" + idProductos,
		type: "POST",
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){

			$("#idProductos").val(respuesta["id"]);
			$("#editarcodigo").val(respuesta["codigo"]);
			$("#editardescripcion").val(respuesta["descripcion"]);
			$("#editarprecio").val(respuesta["precio"]);
		

		}

	})


})



$(".tablas").on("click", ".btnEliminarProductos", function(){

	var id = $(this).attr("idProductos");

	 swal({
	 	title: '¿Está seguro de borrar el producto?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: '¡Si, borrar producto!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = base_url + "Productos/EliminarProductos/" + id;

	 	}

})

	 
})