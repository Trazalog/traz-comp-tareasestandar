<div class="box box-primary">
    <div class="box-header">
        <button class="btn btn-primary" onclick="$('#nueva_plantilla').modal('show')"><i
                class="fa fa-plus mr-2"></i>Nueva Plantilla</button>
    </div>
    <div class="box-body">
        <?php
            $this->load->view('tareas/tabla_plantillas');
        ?>
    </div>
</div>

<script>
function guardarPlantilla() {
    const data = getForm('#frm-plantilla');
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url()?>Tarea/guardarPlantilla',
        data: {
            data
        },
        success: function(result) {
            reload('#plantillas');
            $('#frm-plantilla')[0].reset();
            alert('Hecho')
        },
        error: function(result) {
            alert('Error')
        }
    });
}

function eliminarPlantilla(e) {
    const id = $(e).closest('.data-json').attr('id');
    $.ajax({
        type: 'DELETE',
        dataType: 'JSON',
        url: '<?php echo base_url()?>Tarea/eliminarPlantilla/' + id,
        success: function(result) {
            $('#plantillas').find('tr#' + id).remove();
            alert('Hecho');
        },
        error: function(result) {
            alert('Error')
        }
    });
}
</script>

<!-- The Modal -->
<div class="modal modal-fade" id="nueva_plantilla">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus text-primary mr-2"></i>Nueva Plantilla</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="frm-plantilla">
                    <div class="form-group">
                        <label>Nombre Plantilla:</label>
                        <input id="nombre" name="nombre" class="form-control" type="text">
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarPlantilla()"><i
                        class="fa fa-save mr-2"></i>Guardar</button>
            </div>
        </div>
    </div>
</div>