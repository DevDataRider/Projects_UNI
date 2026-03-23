
$(".tablas").on("click", ".btnEditarCategorias", function(){

	var idCategorias = $(this).attr("idCategorias");

	$.ajax({

		url:base_url + "Categorias/AjaxCategorias/" + idCategorias,
		type: "POST",
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){

			$("#idCategorias").val(respuesta["id"]);
			$("#editarcategorias").val(respuesta["categoria"]);
		

		}

	})
})



$(".tablas").on("click", ".btnEliminarCategorias", function(){

	var id = $(this).attr("idCategorias");

	 swal({
	 	title: '¿Está seguro de borrar la categoria?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: '¡Si, borrar categorias!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = base_url + "Categorias/EliminarCategorias/" + id;
	 	}

})
})