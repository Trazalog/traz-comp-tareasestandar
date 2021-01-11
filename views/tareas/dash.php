<style>
.nav-tabs>li {
    font-size: 15px;
}
</style>

<div class="box" id="pnl-tareas">
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i
                            class="fa fa-arrow-circle-right mr-2"></i>Tareas</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i
                            class="fa fa-arrow-circle-right mr-2"></i>Plantillas</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php $this->load->view('tareas/tabla')?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <?php $this->load->view('tareas/plantillas')?>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal modal-fade" id="nuevo">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus text-primary mr-2"></i>Nueva Tarea</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?php echo comp('nueva-tarea', base_url(TST.'tarea/guardar'),1) ?>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success btn-accion" onclick="guardarTarea()"><i
                        class="fa fa-save mr-2"></i>Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal modal-fade" id="editar">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-edit text-primary mr-2"></i>Editar Tarea</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?php $this->load->view('tareas/form', ['id' => 'frm-tarea-e'])?>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success btn-accion" onclick="guardarTarea(tare_id)"><i
                        class="fa fa-save mr-2"></i>Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
initForm();
var tare_id;
function agregarSubtareas(e) {
    var data = getJson($(e).closest('tr'));
    tare_id = data.tare_id;
    reload('#subtareas', tare_id);
    $('#nueva_subtarea').modal('show');
}

function editarTarea(e) {
    var data = getJson($(e).closest('tr'));
    tare_id = data.tare_id;
    fillForm(data, '#frm-tarea-e');
    $('#editar').modal('show');
}

var eliminarTarea = function(e) {
    var data = getJson($(e).closest('tr'));
    wo();
    $.ajax({
        type: 'DELETE',
        url: '<?php echo base_url(TST) ?>Tarea/eliminar/' + data.tare_id,
        success: function(result) {
            alert('Hecho');
            reload('#tareas');
        },
        error: function(result) {
            alert('Error')
        },
        complete:function(){
            wc();
        }
    });
}

function guardarTarea(id = false) {
    if (id) {
        var data = getForm('#frm-tarea-e');
    } else {
        if(!frm_validar('#frm-tarea')) return;
        var data = getForm('#frm-tarea');
    }
    wo();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(TST) ?>Tarea/guardar' + (id ? '/' + id : ''),
        data: {
            data
        },
        success: function(result) {
            if(result.status){
                $('#nuevo').modal('hide');
                $('#editar').modal('hide');
                reload('#frm-tarea');
                frmReset('#frm-tarea-e');
                reload('#tareas');
                alert('Hecho');
                actualizarTareasSelect();
            }else{
                falla();
            }
        },
        error: function(result) {
            error();
        },
        complete:function(){
            wc();
        }
    });
}
</script>