
/*=============================================
AGREGANDO PRODUCTOS A LA COTIZACION DESDE LA TABLA
=============================================*/

$(".tablas tbody").on("click", ".agregarProducto", function(){

  var id = $(this).attr("idProducto");

  $(this).removeClass("btn-primary agregarProducto");

  $(this).addClass("btn-default");

     $.ajax({

        url: base_url + "Cotizaciones/AjaxCotizaciones/" + id,
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success:function(respuesta){

            var descripcion = respuesta["descripcion"];
            var precio = respuesta["precio"];
            var codigoPDF = respuesta["codigo"];

            /*=============================================
            
            =============================================*/

          

            $(".nuevoProducto").append(
            
        '<div class="row" style="padding:5px 15px">'+

        '<!-- Descripción del producto -->'+
            
            '<div class="col-xs-6" style="padding-right:0px">'+
            
              '<div class="input-group">'+
                
                '<span style="cursor: pointer;" class="input-group-addon"><a class="btn-danger btn-xs quitarProducto" idProducto="'+id+'"><i class="fa fa-times"></i></a></span>'+

                '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+id+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+

              '</div>'+

            '</div>'+

            '<!-- Cantidad del producto -->'+

            '<div class="col-xs-3">'+
              
               '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1"  required>'+

            '</div>' +

            '<!-- Precio del producto -->'+

            '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

              '<div class="input-group">'+

                '<span class="input-group-addon"><i class="fa fa-usd"></i></span>'+
                   
                '<input type="text" class="form-control nuevoPrecioProducto" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+precio+'" readonly required>'+
   
              '</div>'+
               
            '</div>'+

             '<!-- Codigo del producto -->'+
            
            '<div class="col-xs-6" style="padding-right:0px">'+
            
              '<div class="input-group">'+
                 
                '<input type="hidden" class="form-control code"  name="Codigoimagen" value="'+codigoPDF+'" readonly required>'+

              '</div>'+

            '</div>'+


      




          '</div>') 

          // SUMAR TOTAL DE PRECIOS

          sumarTotalPreciosCotizacion()

          // AGREGAR IMPUESTO

        agregarImpuestoCotizacion()

          // AGRUPAR PRODUCTOS EN FORMATO JSON

          listarProductosCotizacion()

          // PONER FORMATO AL PRECIO DE LOS PRODUCTOS

          $(".nuevoPrecioProducto").number(true, 2);


      localStorage.removeItem("quitarProducto");

        }

     })

});



/*=============================================
BOTON EDITAR COTIZACION
=============================================*/
$(".tablas tbody").on("click", ".btnEditarCotizacion", function(){

 var id = $(this).attr("id");

 window.location = base_url + "Cotizaciones/EditarCotizaciones/" + id;


})



/*=============================================
ELIMINAR COTIZACIÓN
=============================================*/

$(".tablas").on("click", "button.btnEliminarProductoCotizacion", function(){

  var id = $(this).attr("id");
  // var base_url = "<?php echo base_url();?>";
  
  swal({

    title: '¿Está seguro de borrar la cotización?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: '¡Si, borrar cotización!'
        }).then(function(result) {
        if (result.value) {

          window.location = base_url + "Cotizaciones/EliminarCotizaciones/" + id;

        }

  })

})






/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablas").on("draw.dt", function(){

  if(localStorage.getItem("quitarProducto") != null){

    var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

    for(var i = 0; i < listaIdProductos.length; i++){

      $("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
      $("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

    }


  }


})




/*=============================================
QUITAR PRODUCTOS DE LA COTIZACIÓN Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(".formularioCotizacion").on("click", ".quitarProducto", function(){

  $(this).parent().parent().parent().parent().remove();

  var idProducto = $(this).attr("idProducto");

  /*=============================================
  ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
  =============================================*/

  if(localStorage.getItem("quitarProducto") == null){

    idQuitarProducto = [];
  
  }else{

    idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

  }

  idQuitarProducto.push({"idProducto":idProducto});

  localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

  $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

  $("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

  if($(".nuevoProducto").children().length == 0){

    $("#nuevoImpuestoVenta").val();
    $("#nuevoTotalCotizacion").val();
    $("#totalVentaCotizacion").val(0);
    $("#nuevoTotalCotizacion").attr("total",0);
    //$("#descuento").val(0);

  }else{

    // SUMAR TOTAL DE PRECIOS

      sumarTotalPreciosCotizacion()

      // AGREGAR IMPUESTO
          
        agregarImpuestoCotizacion()

        // AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductosCotizacion()

  }

})



/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPreciosCotizacion(){

  var precioItem = $(".nuevoPrecioProducto");
  
  var arraySumaPrecio = [];  

  for(var i = 0; i < precioItem.length; i++){

     arraySumaPrecio.push(Number($(precioItem[i]).val()));
    
     
  }

  function sumaArrayPreciosCotizacion(total, numero){

    return total + numero;

  }

  var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPreciosCotizacion);
  
  $("#nuevoTotalCotizacion").val(sumaTotalPrecio);
  $("#totalVentaCotizacion").val(sumaTotalPrecio);
  $("#nuevoTotalCotizacion").attr("total",sumaTotalPrecio);


}



/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuestoCotizacion(){

  var impuesto = $("#nuevoImpuestoVenta").val();
  var precioTotal = $("#nuevoTotalCotizacion").attr("total");

  var precioImpuesto = Number(precioTotal * impuesto/100);

  var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);
  
  $("#nuevoTotalCotizacion").val(totalConImpuesto);

  $("#totalVentaCotizacion").val(totalConImpuesto);

  $("#nuevoPrecioImpuesto").val(precioImpuesto);

  $("#nuevoPrecioNeto").val(precioTotal);

}



/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoVenta").change(function(){

  agregarImpuestoCotizacion();

});






/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalCotizacion").number(true, 2);



/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductosCotizacion(){

  var listaCotizacion = [];

  var descripcion = $(".nuevaDescripcionProducto");

  var cantidad = $(".nuevaCantidadProducto");

  var precio = $(".nuevoPrecioProducto");

  var ven = $(".code");

  var van = $(".imachas");

  for(var i = 0; i < descripcion.length; i++){

    listaCotizacion.push({ "id" : $(descripcion[i]).attr("idProducto"),
                "codigo" : $(ven[i]).val(), 
                "descripcion" : $(descripcion[i]).val(),
                "cantidad" : $(cantidad[i]).val(),
                "imagen" : $(van[i]).val(),
                "precio" : $(precio[i]).attr("precioReal"),
                "total" : $(precio[i]).val()})

  }

  $("#listaCotizacion").val(JSON.stringify(listaCotizacion)); 

}


