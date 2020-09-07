<h4>Detalle Receta</h4>
<form>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Descripción:</label>
                <input class="form-control" type="text" value="<?php echo $receta->formula->descripcion ?>" readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Aplicación:</label>
                <input class="form-control" type="text" value="<?php echo $receta->formula->aplicacion ?>" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Cantidad:</label>
                <input class="form-control" id="frm-cantidad" type="text"
                    value="<?php echo $receta->formula->cantidad ?>" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Unidad Medida:</label>
                <input class="form-control" type="text" value="<?php echo $receta->formula->unidad_medida ?>" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group-input">
                <div class="input-group">
                    <label>Cantidad a aplicar:</label>
                    <input type="number" class="form-control" id="cantidad-aplicar">
                    <div class="input-group-btn">
                        <button style="margin-top: 25px;" type="button" class="btn btn-success"
                            onclick="calcular($('#cantidad-aplicar').val())">Calcular</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<table class="table table-hover table-striped">
    <thead>
        <th>Artículos Receta</th>
        <th>Cantidad Calculada</th>
    </thead>
    <tbody>
        <?php
            foreach ($receta->formula->articulos->articulo as $o) {
                echo "<tr>";
                echo "<td>";
                echo "$o->descripcion<br>";
                echo "<p class='text-info'>Cantidad: $o->cantidad ($o->unidad_medida) x ".$receta->formula->cantidad;
                echo "</p></td>";
                echo "<td class='cc text-center' data-articulo='$o->arti_id' data-cantidad='$o->cantidad' data-unme='$o->unidad_medida'> - </td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<div class="modal-footer">
    <button class="btn btn-primary" onclick="guardarPedidoReceta()">Realizar Pedido</button>
</div>

<script>
var pedido = [];

function calcular(valorAplicar) {
    pedido = [];
    if (!valorAplicar) {
        $('.cc').html('-');
        alert('Ingrese un valor válido');
        return;
    }
    var frmCantidad = parseFloat($('#frm-cantidad').val());
    var cantidadAplicar = parseFloat(valorAplicar);
    $('.cc').each(function() {
        var artCantidad = parseFloat(this.dataset.cantidad);
        var resultado = ((cantidadAplicar * artCantidad) / frmCantidad).toFixed(2);
        $(this).html(resultado + ' x ' + this.dataset.unme);
        pedido.push({
            arti_id: this.dataset.articulo,
            cantidad: resultado
        });
    });
}

function guardarPedidoReceta() {
    var data = getJson2(s_tarea);
    if (pedido.length == 0) {
        alert('Debes ingresar una cantidad a aplicar');
        return;
    }
    var batch_id = $('#batch_id').val();

    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo TST ?>pedido/guardar/'+data.tapl_id,
        data: {
            detalle: pedido,
            pedido: {
                batch_id
            }
        },
        success: function(res) {
            $('#cantidad-aplicar').val('');
            $('.cc').html('-');
            $('#tab-lista-pedidos').click();
            reload('#lista-pedidos',data.tapl_id);
            hecho();
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