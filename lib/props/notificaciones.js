function hecho(msj="Hecho", detalle="Guardado con Éxito!"){
    Swal.fire(
        msj,
        detalle,
        'success'
      )
}

function rehecho(msj="Hecho", detalle="Guardado con Éxito!"){
  Swal.fire(
      msj,
      detalle,
      'success'
    ).then((result) => {
      $('.modal-backdrop ').remove();
      if(result.value) linkTo();
    });
}

function error(msj='Error!', detalle="Algo salio mal"){
    Swal.fire(
        msj,
        detalle,
        'error'
      )
}