<!-- The Modal -->
<div class="modal modal-fade" id="nueva_subtarea">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus text-primary mr-2"></i>Nueva Subtarea</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="frm-subtarea">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripcion:</label>
                                <input id="descripcion" name="descripcion" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Formulario Asociado:</label>
                                <select id="form_id" name="form_id" class="form-control">
                                    <option value="0" selected> - Seleccionar Item -</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary mr-25" onclick="guardarSubtarea()"><i
                                    class="fa fa-plus mr-2"></i>Agregar</button>
                        </div>
                    </div>
                </form>
                <div class="reload">
                    <?php
                    $this->load->view('tareas/tabla_subtareas');
                    ?>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>

function guardarSubtarea() {
    var data = getForm('#frm-subtarea');
    data.tare_id = tare_id;
    wo()
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(TST) ?>Tarea/guardarSubtarea',
        data: {
            data
        },
        success: function(result) {
            $('#frm-subtarea')[0].reset();
            reload('#subtareas', tare_id);
            alert('Hecho');
        },
        error: function(result) {
            alert('Error')
        },
        complete:function(){
            wc();
        }
    });
}

function eliminarSubtarea(e) {

    if (!confirm('¿Desea eliminar este elemento?')) return;
    const id = $(e).closest('.data-json').attr('id');
    wo();
    $.ajax({
        type: 'DELETE',
        url: '<?php echo base_url(TST) ?>Tarea/eliminarSubtarea/' + id,
        success: function(result) {
            $('tr#' + id).remove();
            alert('Hecho')
        },
        error: function(result) {
            alert('Error')
        },
        complete:function(){
            wc();
        }
    });
}
</script>   