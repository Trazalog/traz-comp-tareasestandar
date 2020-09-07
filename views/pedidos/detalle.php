<form id="pedido">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group" style="margin-top: 8px;">
                <label>Artículos:</label>
                <?php  echo selectBusquedaAvanzada('articulos', 'arti_id', $articulos, 'arti_id', 'barcode', array('descripcion', 'Unidad Medida:' => 'unidad_medida')) ?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <div class="form-group-input">
                    <div class="input-group margin">
                        <label>Cantidad:</label>
                        <input type="text" class="form-control" name="cantidad" placeholder="Cantidad">
                        <div class="input-group-btn">
                            <button style="margin-top: 25px;" type="button" class="btn btn-success"
                                onclick="agregarItem()"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<table class="table table-striped table-hover" id="detalle_pedido">
    <thead>
        <th>Pedido Artículos</th>
        <th width="10%">Cantidad</th>
        <th width="5%">Acciones</th>
    </thead>
    <tbody>

    </tbody>
</table>
<div class="modal-footer">
    <button class="btn btn-primary" onclick="guardarPedido()">Realizar Pedido</button>
</div>
<script>
function agregarItem() {
   
    var pedido = getForm('#pedido');
    var art = getJson2('#articulos');

    if(!art.descripcion){
        alert('Debes seleccionar un artículo');
        return;
    }

    if(!pedido.cantidad){
        alert('Ingrese una cantidad válida');
        return
    }
    $('#detalle_pedido > tbody').append(
        `<tr class="data-json" data-json='${JSON.stringify(pedido)}'>
            <td>${art.descripcion}</td>
            <td class="text-center">${pedido.cantidad}</td>
            <td><button class="btn btn-link" onclick="$(this).closest('tr').remove()"><i class="fa fa-times text-danger"></i></button></td>
        </tr>`
    );
    $('#pedido')[0].reset();
    $('#articulos').val("0").trigger('change');
}

function guardarPedido() {
    var data = getJson2(s_tarea);
    var pedido = {
        batch_id: $('#batch_id').val()
    };

    var detalle = [];
    $('#detalle_pedido > tbody > tr').each(function() {
        detalle.push(getJson2(this));
    });

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(TST) ?>Pedido/guardar/'+data.tapl_id,
        data: {
            pedido,
            detalle
        },
        success: function(res) {
            if (res.status) {
                $('#detalle_pedido > tbody').empty();
                $('#tab-lista-pedidos').click();
                reload('#lista-pedidos', data.tapl_id);
                hecho();
            } else falla();
        },
        error: function(res) {
            error();
        },
        complete: function() {
            wc();
        }
    });
}
</script>