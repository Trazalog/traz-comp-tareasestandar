<!-- The Modal -->
<div class="modal modal-fade" id="mdl-pema">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-check-square-o mr-2 text-primary"></i>Pedido Rec. Materiales
                </h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">


            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="guardarPedido()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
function verDetallePedido() {
    var data = getJson2(s_tarea);
    $('#mdl-pema').find('.modal-body').load('<?php echo base_url(TST) ?>Pedido/verDetalle' + (data.hasOwnProperty('pema_id') ?
        '/' + data.pema_id : ''))
    $('#mdl-pema').modal('show');
}
</script>