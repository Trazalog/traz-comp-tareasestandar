<?php
    $this->load->view('tareas/tabla_plantillas');
?>


<script>
var plan_id;

function editarPlantilla(e) {
    var data = getJson($(e).closest('.data-json'));
    plan_id = data.plan_id;
    $('#nombre').val(data.nombre);
    $('#nueva_plantilla').modal('show');
}

function guardarPlantilla(id = false) {
    const data = getForm('#frm-plantilla');
    if (id) data.plan_id = id;
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url()?>Tarea/guardarPlantilla',
        data: {
            data
        },
        success: function(result) {
            reload('#plantillas');
            $('#frm-plantilla')[0].reset();
            plan_id = false;
            alert('Hecho');
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

var selectPlan;

function getTareasPlantilla(e) {
    $('#tareas_asociadas .tabla').empty();
    var data = getJson($(e).closest('.data-json'));
    $('plantilla').html(data.nombre);
    selectPlan = data.plan_id;
    $.ajax({
        type: 'GET',
        url: '<?php echo base_url() ?>Tarea/tablaTareasPlantilla/' + data.plan_id,
        success: function(res) {
            $('#tareas_asociadas .tabla').html(res);
            $('#tareas_asociadas').modal('show');
            actualizarTareasSelect();
        },
        error: function(res) {
            error();
        },
        complete: function() {

        }
    });
}

function actualizarTareasSelect() {
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url() ?>Tarea/obtener',
        success: function(res) {
            var html  = '<option value="" disabled selected>- Seleccionar -</option>';
            if(res.status & res.data){
                res.data.forEach(function(e){
                    $html + = `<option value="${e.tare_id}">${e.nombre}</option>`;
                });
            }
            $('select#tareas').html(html);

            $('#tareas_plantillas tbody tr').each(function() {
                
                $('select#tareas').find("[value='"+this.id+"']").hide();

            })
        },
        error: function(res) {
            error();
        },
        complete: function() {

        }
    });
}

function asociarTareaPlantilla() {
    var plan_id = selectPlan;
    var tare_id = $('select#tareas').val();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url() ?>Tarea/asociarTareaPlantilla',
        data: {
            plan_id,
            tare_id
        },
        success: function(res) {
            reload('#tareas_plantillas');
            $('select#tareas').val('');
            hecho();
        },
        error: function(res) {
            error();
        },
        complete: function() {

        }
    });
}
</script>

<!-- The Modal -->
<div class="modal modal-fade" id="nueva_plantilla">
    <div class="modal-dialog">
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
                <button type="button" class="btn btn-success" data-dismiss="modal"
                    onclick="guardarPlantilla(plan_id)"><i class="fa fa-save mr-2"></i>Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-fade" id="tareas_asociadas">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-list text-primary mr-2"></i><b>Tareas Plantilla:</b>
                    <plantilla></plantilla>
                </h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

                <form>
                    <div class="form-group">
                        <label>Ascociar Tarea:</label>

                        <div class="input-group">
                            <select id="tareas" class="form-control">
                                <option value="" selected disabled>- Seleccionar -</option>
                                <?php

                                    foreach ($tareas as $key => $o) {
                                                    
                                        echo "<option value='$o->tare_id'>$o->nombre</option>";

                                    }

                                ?>
                            </select>
                            <span class="input-group-btn"><button onclick="asociarTareaPlantilla()" type="button"
                                    class="btn btn-success"><i class="fa fa-plus"></i></button></span>
                        </div>
                    </div>
                </form>

                <div class="tabla"></div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>