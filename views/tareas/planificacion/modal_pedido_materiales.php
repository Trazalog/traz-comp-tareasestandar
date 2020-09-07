<!-- The Modal -->
<div class="modal modal-fade" id="mdl-pedidos">
    <div class="modal-dialog modal-lm">
        <?php
            $this->load->view(TST.'pedidos/pedidos_tarea');
      ?>
    </div>
</div>


<script>
function verDetallePedido() {
    var data = getJson2(s_tarea);
    reload('#lista-pedidos', data.tapl_id);
    if (data.rece_id != "0") reload('#lista-receta', data.rece_id);
    $('#mdl-pedidos').modal('show');
}
</script>