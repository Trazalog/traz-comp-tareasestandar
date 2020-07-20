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
        <th width="5%"></th>
    </thead>
    <tbody>
        <?php
            if(isset($pedido->detalles) && $pedido->detalles){
                foreach ($pedido->detalles as $o) {
                    echo "<tr class='data-json' data-json='".json_encode($o)."'>";
                    echo "<td>$o->descripcion</td>";
                    echo "<td>$o->cantidad</td>";
                    echo "<td><button class='btn btn-link' onclick='$(this).closest(\"tr\").remove()'><i class='fa fa-trash text-danger'></i></button></td>";
                    echo "</tr>";
                }
            }
        ?>
    </tbody>
</table>

<script>
function agregarItem() {
    var pedido = getForm('#pedido');
    var art = getJson2('#articulos');
    $('#detalle_pedido > tbody').append(
        `<tr class="data-json" data-json='${JSON.stringify(pedido)}'><td>${art.descripcion}</td><td class="text-center">${pedido.cantidad}</td><td><button class="btn btn-link" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash text-danger"></i></button></td></tr>`
    );
    $('#pedido')[0].reset();
    $('#articulos').val("0").trigger('change');
}

function guardarPedido() {
    var pedido = {
        batch_id: "655"
    };

    var detalle = [];
    $('#detalle_pedido > tbody > tr').each(function() {
        detalle.push(getJson2(this));
    });

    var pema_id = getJson2(s_tarea).pema_id;

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(TST) ?>Pedido/guardar' + (pema_id ? '/' + pema_id : ''),
        data: {
            pedido,
            detalle
        },
        success: function(res) {
            if (res.status) {
                setAttr(s_tarea, 'pema_id', res.data);
                hecho();
            } else falla();
        },
        error: function(res) {
            error();
        },
        complete: function() {

        }
    });
}
</script>