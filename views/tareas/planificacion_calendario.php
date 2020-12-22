<?php
    $this->load->view('tareas/planificacion/modal_equipos');
    $this->load->view('tareas/planificacion/modal_pedido_materiales');
    $this->load->view('tareas/planificacion/modal_asignar_usuario');
    $this->load->view('tareas/planificacion/mdl_hora');
?>

<div class="row">
    <div class="col-md-6">
        <div id="box-calendario" class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sector:</label>
                            <select name="sector" id="sector" class="form-control">
                                <option value="0">- Seleccionar -</option>
                                <?php
                                    foreach ($sectores as $o) {
                                        echo "<option value='$o->sect_id' data-json='".json_encode($o->equipos)."'>$o->descripcion</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Equipo:</label>
                            <select name="equipo" id="equipo" class="form-control">
                                <option value="0">- Seleccionar -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php $this->load->view(CAL.'calendario'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box" id="bolsa-tareas">
            <div class="box-body">
                <div class="table-responsive" style="height: 540px;">
                    <table class="table table-striped table-hover table-fixed" id="tareas-calendario">
                        <thead>
                            <th>Tareas Planificadas</th>
                            <th width="50%"></th>
                        </thead>
                        <tbody>
                            <?php
                                if($tareas_planificadas){

                                    foreach ($tareas_planificadas as $o) {
                                        
                                        echo "<tr class='data-json' data-json='".json_encode($o)."'>";
                                        echo "<td><h5>$o->nombre</h5></td>";
                                        echo "<td class='text-right acciones'></td>";
                                        echo "</tr>";
                                        
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var s_tarea = null;
var s_fecha = false;
function clickCalendario(info) {
    if (Date.parse(info.date) >= Date.parse(dateNow())) {
        //HARDCODE
        s_fecha = dateFormat(info.dateStr);
        if (selectCalendario) {
            //Actualizar Vista
            foco();
            selectCalendario = false;

            $('#mdl-hora').modal('show');
        }
    } else {
        alert('No se puede seleccionar fechas anteriores a la actual.');
    }
}

function guardarTodasTareas() {
    $('#tareas-calendario').find('.tarea').each(function() {
        guardarTarea('#' + this.id);
    })
}

function guardarTarea(id) {

    var tarea = getJson2(id);
    tarea.origen = getJson2($('#origen'));
    wbox('#bolsa-tareas');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo TST ?>Tarea/guardarPlanificada',
        data: tarea,
        success: function(res) {
            setJson(id, res);
        },
        error: function(res) {
            error();
        },
        complete: function() {
            s_tarea = false;
            wbox();
            wc();
            calendarRefetchEvents();
        }
    });

}

function showForm(e) {
    var data = getJson2(e);
    $mdl = $('#mdl-generico');
    $mdl.find('.modal-title').html('Formulario Asociado');
    $mdl.find('.modal-body').empty();
    if (!data.info_id || data.info_id == "false") {
        alert('Tarea sin formulario asociado');
        return;
    }
    wo();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url(FRM) ?>Form/obtener/' + data.info_id,
        success: function(res) {
            $mdl.find('.modal-body').html(res.html);
            $mdl.modal('show');
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