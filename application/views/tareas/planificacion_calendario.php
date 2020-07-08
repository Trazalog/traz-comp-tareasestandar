<?php
    $this->load->view('tareas/planificacion/modal_equipos');
    $this->load->view('tareas/planificacion/modal_pedido_materiales');
    $this->load->view('tareas/planificacion/modal_asignar_usuario');
?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-calendario">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sector:</label>
                            <select name="sector" id="sector" class="form-control">
                                <option value="0">- Seleccionar -</option>
                                <?php
                                    foreach ($sectores as $o) {
                                        echo "<option value='$o->sect_id' data-json='".json_encode($o->equipos)."'>$o->nombre</option>";
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
        <div class="box">
            <div class="box-body">
                <div class="table-responsive" style="height: 600px;">
                    <table class="table table-striped table-hover table-fixed" id="tareas-calendario">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
var s_tarea = null;

function clickCalendario(info) {
    //HARDCODE
    const hora = " 00:00";
    var fecha = dateFormat(info.dateStr);
    if (selectCalendario) {
        $(s_tarea).closest('.tarea').attr('data-fecha', fecha);
        $(s_tarea).closest('.tarea').attr('data-hora', hora);
        $(s_tarea).find('span').remove();
        $(s_tarea).append(bolita(fecha + hora, 'blue'));
        guardarTarea($(s_tarea).closest('.tarea'));

        //Actualizar Vista
        foco();
        selectCalendario = false;
    }
}

$('#sector').change(function() {
    $('#equipo').empty();
    var equipos = getJson($(this).find('option:selected'));
    $('#equipo').append(`<option value="0">- Seleccionar -</option>`)
    equipos.forEach(function(e) {
        $('#equipo').append(`<option value="${e.equi_id}">${e.nombre}</option>`)
    })
})

$('#equipo').change(function() {
    console.log('Filtrar Calendarios');
});

function guardarTarea() {
    var tarea = getJson2(s_tarea);

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'Tarea/guardarPlanificada',
        data: tarea,
        success: function(res) {
            console.log('RSPAJAX:');

            console.log(res);

            $(t).attr('data-tapl-id', res.data.tarea.tapl_id),
                hecho();
        },
        error: function(res) {

        },
        complete: function() {

        }
    });

}
</script>